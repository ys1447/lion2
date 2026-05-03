<?php

use Livewire\Component;
use App\Models\InputData;
use App\Models\JobMixing;
use App\Models\VariantConfig;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\HasNotification;

new class extends Component {
    use WithPagination, HasNotification;

    protected $listeners = ['data-added', 'input-data-updated' => '$refresh'];

    #[Locked]
    public $variantId;
    public $selectedBatch;
    public $visibleColumns = [];

    public $search = '';
    public $filterStatus = '';

    public $co_job;

    public function mount($variantId)
    {
        $this->variantId = $variantId;

        // Ambil config berdasarkan variant_id
        $config = VariantConfig::where('variant_id', $this->variantId)->first();

        // Jika config ada, gunakan kolom yang disimpan, jika tidak munculkan semua (default)
        $this->visibleColumns = $config ? $config->visible_columns : $this->allFields();
    }

    // Listener jika ada update kolom secara realtime dari komponen Setting
    #[On('columns-updated')]
    public function updateVisibleColumns($columns)
    {
        $this->visibleColumns = $columns;
    }

    public function allFields()
    {
        return ['machine_id', 'batch', 'job_number', 'job_code', 'ph_1', 'ph_2', 'ph_3', 'viscosity_1', 'viscosity_2', 'viscosity_3', 'specific_gravity', 'active_ingredient', 'zpt', 'soap_percentage', 'rad', 'rgx', 'rxb', 'ryc', 'appearance', 'odor', 'capacity', 'shift', 'notes', 'one_day'];
    }

    public function edit($id)
    {
        $this->dispatch('edit-input-data', id: $id);
    }

    public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'input-data', // beda tiap component
        );
    }

    #[On('delete-input-data')]
    public function delete($id)
    {
        $input = InputData::findOrFail($id);
        $inputVariant = $input->variant->name;
        $inputBatch = $input->batch;
        $jobMixingId = $input->job_mixing_id;

        $input->delete();

        $this->reSequenceJobNumbers($jobMixingId);

        $this->sendNotification(action: 'DELETE', target: 'Input Variant: ' . $inputVariant, details: "Delete data batch {$inputBatch} from system");

        $this->dispatch('alert-success', message: 'Data berhasil dihapus');
    }

    private function reSequenceJobNumbers($jobMixingId)
    {
        $job = JobMixing::find($jobMixingId);
        if (!$job) {
            return;
        }

        $prefix = $job->type == true ? 'T' : '';

        // Ambil semua data dengan Job Mixing tersebut, urutkan berdasarkan waktu input
        $allEntries = InputData::where('job_mixing_id', $jobMixingId)->orderBy('created_at', 'asc')->orderBy('id', 'asc')->get();

        // Loop dan update satu per satu job_number-nya secara berurutan (1, 2, 3...)
        foreach ($allEntries as $index => $entry) {
            $newNumber = $prefix . ($index + 1);

            // Update langsung ke database (tanpa memicu event listeners jika perlu)
            $entry->update(['job_number' => $newNumber]);
        }
    }

    public function updatedFilterStatus()
    {
        // Setiap kali ganti filter, balikkan ke halaman 1
        $this->resetPage();
    }

    public $fromDate = '';
    public $toDate = '';

    // Reset halaman jika tanggal diubah
    public function updatedFromDate()
    {
        $this->resetPage();
    }
    public function updatedToDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        return $this->view([
            'datas' => InputData::query()
                ->with(['variant.standards', 'variant', 'user', 'machine', 'machine.category', 'reworkLogs' => fn($q) => $q->where('status', 'active')])
                ->where('variant_id', $this->variantId)
                ->search($this->search)
                ->withStatus($this->filterStatus)
                ->betweenDates($this->fromDate, $this->toDate)
                ->latest()
                ->paginate(15),
        ]);
    }

    public $selectedId;
    public $holdReason;
    public $showHoldModal = false;
    // 1. Trigger saat tombol di tabel diklik
    public function confirmHold($id)
    {
        // Sekali query untuk ambil semua data yang dibutuhkan
        $inputData = InputData::findOrFail($id);

        $this->selectedId = $id;
        $this->selectedBatch = $inputData->batch; // Simpan ke properti
        $this->holdReason = '';
        $this->showHoldModal = true;
    }

    // 2. Simpan ke Database
    public function saveHold()
    {
        $this->validate([
            'holdReason' => 'required|min:5',
        ]);

        $inputData = InputData::findOrFail($this->selectedId);

        // Proteksi: Jika statusnya sudah hold, hentikan proses
        if ($inputData->status === 'hold') {
            $this->showHoldModal = false;
            return;
        }

        // Update status di tabel utama
        $inputData->update(['status' => 'hold']);

        // Buat jejak di tabel log
        $inputData->holdLogs()->create([
            'user_id' => auth()->user()->getAttributes()['id'],
            'reason' => $this->holdReason,
            'hold_at' => now(),
        ]);

        $this->showHoldModal = false;
        $this->dispatch('alert-success', message: 'Data berhasil dipindahkan ke List Hold');
    }

    public function cancelHold()
    {
        $this->showHoldModal = false;
        $this->reset(['selectedId', 'selectedBatch', 'holdReason']);
    }

    public $showReworkModal = false;
    public $reworkInitialQty;

    public function confirmRework($id)
    {
        $inputData = InputData::findOrFail($id);

        $this->selectedId = $id;
        $this->reworkInitialQty = ''; // Reset input
        $this->selectedBatch = $inputData->batch;
        $this->showReworkModal = true;
    }

    public function saveRework()
    {
        $this->validate([
            'reworkInitialQty' => 'required|numeric|min:1',
        ]);

        $inputData = InputData::findOrFail($this->selectedId);

        // Buat data di tabel rework_logs
        $inputData->reworkLogs()->create([
            'initial_quantity' => $this->reworkInitialQty,
            'current_quantity' => $this->reworkInitialQty, // Sisa awal sama dengan kuantitas awal
            'status' => 'active',
            // Kolom lain (shift, target_batch, dll) biarkan null dulu karena diisi saat proses remix nanti
        ]);

        $this->showReworkModal = false;
        $this->dispatch('alert-success', message: 'Data berhasil masuk ke Daftar Rework');

        // Refresh aside bar jika menggunakan component berbeda (opsional)
        $this->dispatch('rework-added');
    }

    public function cancelRework()
    {
        $this->showReworkModal = false;
        // Reset data agar bersih saat modal dibuka lagi nanti
        $this->reset(['selectedId', 'selectedBatch', 'reworkInitialQty']);

        // Opsional: Hapus pesan error validasi (jika ada)
        $this->resetValidation();
    }

    public function toggleCoJob($id)
    {
        $data = InputData::findOrFail($id);

        // Toggle nilai boolean
        $data->update([
            'co_job' => !$data->co_job,
        ]);
    }

    public function exportCsv()
    {
        $data = InputData::query()
            ->with(['variant', 'user', 'machine', 'machine.category'])
            ->where('variant_id', $this->variantId)
            ->search($this->search)
            ->withStatus($this->filterStatus)
            ->betweenDates($this->fromDate, $this->toDate)
            ->latest()
            ->get();

        if ($data->isEmpty()) {
            return session()->flash('error', 'No data to export.');
        }

        // 1. Definisikan semua kemungkinan kolom dan labelnya
        $allPossibleColumns = [
            'created_at' => 'Tanggal Input',
            'user.name' => 'Inspector',
            'status' => 'Status',
            'batch' => 'Batch',
            'job_number' => 'Job Number',
            'ph_1' => 'pH 1',
            'ph_2' => 'pH 2',
            'ph_3' => 'pH 3',
            'viscosity_1' => 'Viscosity 1',
            'viscosity_2' => 'Viscosity 2',
            'viscosity_3' => 'Viscosity 3',
            'specific_gravity' => 'SG',
            'active_ingredient' => 'Active Ingredient',
            'appearance' => 'Appearance',
            'odor' => 'Odor',
            'shift' => 'Shift',
            'notes' => 'Notes',
            'oneday' => '1 Day',
        ];

        // 2. Filter kolom: Hanya ambil kolom yang setidaknya punya 1 baris berisi data (tidak null)
        $activeColumns = [];
        foreach ($allPossibleColumns as $key => $label) {
            // Cek apakah ada minimal satu baris yang kolomnya tidak null/kosong
            $hasValue = $data->contains(function ($row) use ($key) {
                $value = data_get($row, $key);
                return !is_null($value) && $value !== '';
            });

            if ($hasValue) {
                $activeColumns[$key] = $label;
            }
        }

        // 3. Proses Pembuatan CSV
        $fileName = 'QC_Export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        $callback = function () use ($data, $activeColumns) {
            $file = fopen('php://output', 'w');

            // Tulis Header berdasarkan kolom yang aktif saja
            fputcsv($file, array_values($activeColumns));

            // Tulis Data
            foreach ($data as $row) {
                $line = [];
                foreach ($activeColumns as $key => $label) {
                    $val = data_get($row, $key);

                    // Formatting khusus untuk tanggal
                    if ($key === 'created_at') {
                        $line[] = $val->format('d/m/Y H:i');
                    } else {
                        $line[] = $val ?? '-';
                    }
                }
                fputcsv($file, $line);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public $showOneDayModal = false;
    public $oneDayValue;

    public function openOneDayModal($id)
    {
        $data = InputData::findOrFail($id);

        $this->selectedId = $id;
        $this->oneDayValue = $data->oneday;
        $this->showOneDayModal = true;
    }

    public function saveOneDay()
    {
        $this->validate([
            'oneDayValue' => 'nullable|max:25',
        ]);

        InputData::findOrFail($this->selectedId)->update(['oneday' => $this->oneDayValue]);

        $this->showOneDayModal = false;
    }

    public function cancelModal1D()
    {
        $this->showOneDayModal = false;
        // Reset data agar bersih saat modal dibuka lagi nanti
        $this->reset(['oneDayValue']);

        // Opsional: Hapus pesan error validasi (jika ada)
        $this->resetValidation();
    }
};
?>

<div>

    <x-loading
        wire:target="openOneDayModal,saveOneDay,cancelModal1D ,delete, edit, saveHold, confirmHold, cancelHold, cancelRework, saveRework, confirmRework, toggleCoJob, search, filterStatus, fromDate, toDate" />

    <x-modal :show="$showOneDayModal" title="Input One Day">
        <div class="space-y-4">

            <div>
                <label for="oneday" class="block text-sm font-medium text-slate-700 mb-1">
                    1 Day Notes
                </label>

                <textarea x-data
                    x-init="$nextTick(() => $el.focus())" wire:model="oneDayValue" id="oneday" rows="4" placeholder="pH / visco / sg ..."
                    class="w-full text-sm border border-slate-200 rounded-md  
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 p-2"></textarea>

                @error('oneDayValue')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <button wire:click="cancelModal1D"
                    class="px-3 py-1.5 text-sm text-slate-500 hover:bg-slate-100 rounded">
                    Cancel
                </button>

                <button wire:click="saveOneDay"
                    class="px-3 py-1.5 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Save
                </button>
            </div>

        </div>
    </x-modal>

    <x-modal :show="$showReworkModal" title="Setup Rework Batch">
        <div class="space-y-4">
            <div class="p-3 bg-amber-50 rounded-lg border border-amber-100 flex gap-3">
                <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-amber-700">
                    Masukkan total berat (KG) yang akan diproses ulang untuk Batch
                    <strong>{{ $selectedBatch }}</strong>.
                </p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Initial Quantity (KG)</label>
                <input type="number" wire:model="reworkInitialQty"
                    class="w-full p-2 border border-slate-200 rounded text-sm focus:ring-amber-500"
                    placeholder="Contoh: 500">
                @error('reworkInitialQty')
                <span class="text-red-500 text-[10px]">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <button wire:click="cancelRework"
                    class="px-3 py-1.5 text-xs text-slate-500 hover:bg-slate-100 rounded">Cancel</button>
                <x-button wire:click="saveRework" class="bg-amber-600 hover:bg-amber-700">Add to Rework List</x-button>
            </div>
        </div>
    </x-modal>

    <x-modal :show="$showHoldModal" title="Reason for Hold">
        <div class="space-y-4">
            <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg border border-red-100 mb-4">
                <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-xs text-red-700">
                    Memberikan status <strong>HOLD</strong> akan memindahkan batch {{ $selectedBatch }} ini ke daftar
                    pemantauan khusus
                    sampai dikonfirmasi kembali.
                </p>
            </div>

            <textarea wire:model="holdReason"
                class="p-2 w-full rounded-md border-slate-200 text-sm focus:ring-red-500 focus:border-red-500 placeholder:text-slate-400"
                rows="4" placeholder="Contoh: Terjadi penyimpangan suhu pada tangki mixing..."></textarea>

            @error('holdReason')
            <span class="text-red-500 text-xs font-medium">{{ $message }}</span>
            @enderror

            <div class="flex justify-end gap-2 mt-2">
                <button wire:click="cancelHold" type="button"
                    class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </button>

                <x-button wire:click="saveHold" type="button">
                    Confirm Hold
                </x-button>
            </div>
        </div>
    </x-modal>



    <div class="flex gap-2">
        <x-search model='search' placeholder="Search Batch, Job, or Machine" />
        <x-filter model="filterStatus">
            <option value="">All Status</option>
            <option value="hold">On Hold ⚠️</option>
            <option value="releaseHold">Released ✅</option>
        </x-filter>
        {{-- Date Range --}}

        <x-range fromModel="fromDate" toModel="toDate" />

        {{-- Tombol Reset (Muncul hanya jika ada filter aktif) --}}
        @if ($search || $filterStatus || $fromDate || $toDate)
        <button wire:click="$set('search', ''); $set('filterStatus', ''); $set('fromDate', ''); $set('toDate', '')"
            class="p-2 text-red-500 hover:bg-red-50 rounded-sm transition-colors" title="Clear All Filters">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        @endif
    </div>

    @if ($search || $filterStatus || $fromDate || $toDate)
    <button wire:click="exportCsv" wire:loading.attr="disabled"
        class="flex items-center gap-1 mb-2 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-sm text-xs font-bold transition shadow-sm">

        <!-- Ikon Download (Hilang saat loading) -->
        <svg wire:loading.remove wire:target="exportCsv" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>

        <!-- Ikon Loading (Muncul saat proses) -->
        <svg wire:loading wire:target="exportCsv" class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>

        <span class="tracking-tight">EXPORT</span>
    </button>
    @endif

    <x-data-table title="QC Inspection Data">
        <div class="overflow-x-auto w-full border-t border-slate-100/50">
            <table class="w-full min-w-max table-auto border-separate border-spacing-0 text-xs">
                <thead class="bg-slate-50/80 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center w-12">
                            No
                        </th>

                        {{-- Group: Production --}}
                        @if (array_intersect(['batch', 'job_number', 'job_code'], $visibleColumns))
                        <th
                            class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-left min-w-40">
                            Production</th>
                        @endif

                        {{-- Group: pH --}}
                        @if (array_intersect(['ph_1', 'ph_2', 'ph_3'], $visibleColumns))
                        <th
                            class="px-4 py-4 font-semibold text-blue-600 border-b border-slate-200 text-left bg-blue-50/30">
                            pH Levels</th>
                        @endif

                        {{-- Group: Viscosity --}}
                        @if (array_intersect(['viscosity_1', 'viscosity_2', 'viscosity_3'], $visibleColumns))
                        <th
                            class="px-4 py-4 font-semibold text-emerald-600 border-b border-slate-200 text-left bg-emerald-50/30">
                            Viscosity</th>
                        @endif



                        @if (in_array('specific_gravity', $visibleColumns))
                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center">SG
                        </th>
                        @endif
                        @if (in_array('active_ingredient', $visibleColumns))
                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center">AI
                        </th>
                        @endif
                        @if (in_array('zpt', $visibleColumns))
                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center">
                            ZPT
                        </th>
                        @endif
                        @if (in_array('soap_percentage', $visibleColumns))
                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center">
                            Soap</th>
                        @endif

                        @if (in_array('one_day', $visibleColumns))
                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center">1D
                        </th>
                        @endif

                        {{-- Group: Adjustment --}}
                        @if (array_intersect(['rad', 'rgx', 'rxb', 'ryc'], $visibleColumns))
                        <th
                            class="px-4 py-4 font-semibold text-purple-600 border-b border-slate-200 text-left bg-purple-50/30">
                            Adjustment</th>
                        @endif

                        @if (array_intersect(['appearance', 'odor'], $visibleColumns))
                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-left">
                            Organoleptic</th>
                        @endif

                        @if (array_intersect(['capacity', 'shift', 'machine_id'], $visibleColumns))
                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center">
                            Cap/Machine/Shift</th>
                        @endif

                        @if (in_array('notes', $visibleColumns))
                        <th
                            class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-left min-w-45">
                            Notes</th>
                        @endif

                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center w-32">
                            QC Decision
                        </th>

                        <th class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-left">
                            Inspector
                        </th>
                        <th
                            class="px-4 py-4 font-semibold text-slate-500 border-b border-slate-200 text-center sticky right-0 bg-white">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($datas as $i => $data)
                    <tr wire:key="data-{{ $data->id }}"
                        class="hover:bg-slate-50 transition-all duration-200 {{ $data->status === 'hold' ? 'bg-red-100 hover:bg-red-200 border-l-4 border-l-red-500' : 'hover:bg-slate-50' }} {{-- Tambahan: Jika Ada Data Out Spec (OOS) tapi tidak di-hold, beri warna oranye muda/merah tipis --}} {{ $data->status !== 'hold' && $data->hasAnyOutSpec() ? 'bg-orange-50 border-l-4 border-l-orange-400' : '' }}">

                        <td class="px-4 py-4 text-center text-slate-400 font-medium italic">
                            {{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}
                        </td>

                        {{-- Col: Production --}}
                        @if (array_intersect(['batch', 'job_number', 'job_code'], $visibleColumns))
                        <td class="px-4 py-4">
                            <div class="flex flex-col">
                                @if (in_array('batch', $visibleColumns))
                                <span class="font-bold text-slate-700 tracking-tight text-[9px]">Batch -
                                    {{ $data->batch }}</span>
                                @endif
                                @if (in_array('job_number', $visibleColumns))
                                <span class="text-[9px] text-slate-400 font-mono">No Job -
                                    {{ $data->job_number }}</span>
                                @endif
                                @if (in_array('job_code', $visibleColumns))
                                <span
                                    class="text-[9px] px-1.5 py-0.5 rounded w-fit mt-1 {{ $data->job_color }}">
                                    {{ $data->job_code ?? 'N/A' }}
                                </span>
                                @endif
                            </div>
                        </td>
                        @endif


                        {{-- Col: pH --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1.5">
                                @foreach (['ph_1', 'ph_2', 'ph_3'] as $field)
                                @if ($data->$field && in_array($field, $visibleColumns))
                                <span
                                    class="px-2 py-1 font-mono font-bold 
                                                {{-- Logika Merah jika OOS --}}
                                                {{ $data->isOutSpec($field)
                                                    ? 'bg-red-600 text-white border-red-700 animate-pulse'
                                                    : 'text-blue-700' }}">
                                    {{ $data->$field }}
                                </span>
                                @endif
                                @endforeach
                            </div>
                        </td>

                        {{-- Col: Viscosity --}}
                        @if (array_intersect(['viscosity_1', 'viscosity_2', 'viscosity_3'], $visibleColumns))
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1.5">
                                @foreach (['viscosity_1', 'viscosity_2', 'viscosity_3'] as $field)
                                @if ($data->$field && in_array($field, $visibleColumns))
                                <span
                                    class="px-2 py-1 font-mono font-bold transition-all duration-300
                                                    {{ $data->isOutSpec($field)
                                                        ? 'bg-red-600 text-white border-red-700 animate-pulse'
                                                        : 'text-emerald-700' }}">

                                    {{ number_format((float) $data->$field, 0, ',', '.') }}
                                </span>
                                @endif
                                @endforeach
                            </div>
                        </td>
                        @endif



                        @if (in_array('specific_gravity', $visibleColumns))
                        <td
                            class="px-4 py-4 text-center font-mono 
                                    {{ $data->isOutSpec('specific_gravity')
                                        ? 'bg-red-600 text-white border-red-700 animate-pulse'
                                        : 'text-slate-600' }}">
                            {{ $data->specific_gravity ?? '-' }}
                        </td>
                        @endif

                        @if (in_array('active_ingredient', $visibleColumns))
                        <td
                            class="px-4 py-4 text-center font-mono text-slate-600 {{ $data->isOutSpec('active_ingredient')
                                        ? 'bg-red-600 text-white border-red-700 animate-pulse'
                                        : 'text-slate-600' }}">
                            {{ $data->active_ingredient ?? '-' }}
                        </td>
                        @endif

                        @if (in_array('zpt', $visibleColumns))
                        <td
                            class="px-4 py-4 text-center font-mono text-slate-600 {{ $data->isOutSpec('zpt') ? 'bg-red-600 text-white border-red-700 animate-pulse' : 'text-slate-600' }}">
                            {{ $data->zpt ?? '-' }}
                        </td>
                        @endif
                        @if (in_array('soap_percentage', $visibleColumns))
                        <td
                            class="px-4 py-4 text-center font-mono text-slate-600 {{ $data->isOutSpec('soap_percentage')
                                        ? 'bg-red-600 text-white border-red-700 animate-pulse'
                                        : 'text-slate-600' }}">
                            {{ $data->soap_percentage ?? '-' }}
                        </td>
                        @endif

                        @if (in_array('one_day', $visibleColumns))
                        <td class="px-4 py-4 text-center font-mono text-slate-600 w-32">

                            <button wire:click="openOneDayModal({{ $data->id }})"
                                class="px-2 py-1 text-[10px] rounded-sm transition-all duration-150 cursor-pointer {{ $data->oneday ? 'bg-amber-500 hover:bg-amber-600 text-white shadow-sm' : 'bg-indigo-500 hover:bg-indigo-600 text-white shadow-sm' }}">
                                {{ $data->oneday ? 'Edit' : 'Input' }}
                            </button>

                            <div class="mt-1 text-[10px] text-slate-500 italic">
                                {{ $data->oneday }}
                            </div>

                        </td>
                        @endif

                        {{-- Col: Adjustment --}}
                        @if (array_intersect(['rad', 'rgx', 'rxb', 'ryc'], $visibleColumns))
                        <td class="px-4 py-4 bg-purple-50/10">
                            <div class="flex gap-1 text-[10px] font-mono">
                                @foreach (['rad', 'rgx', 'rxb', 'ryc'] as $field)
                                @if (in_array($field, $visibleColumns))
                                <span
                                    class="text-purple-400 @if (!$loop->first) ml-1 @endif">{{ ucfirst($field) }}:</span>
                                <span
                                    class="text-purple-700 font-bold">{{ $data->$field ?? '-' }}</span>
                                @endif
                                @endforeach
                            </div>
                        </td>
                        @endif

                        {{-- Col: Organoleptic --}}
                        @if (array_intersect(['appearance', 'odor'], $visibleColumns))
                        <td class="px-4 py-4">
                            <div class="flex flex-col gap-0.5 text-[10px]">
                                @if (in_array('appearance', $visibleColumns))
                                <div class="flex justify-between gap-2 text-slate-500"><span>App:</span>
                                    <span
                                        class="text-slate-700 font-medium">{{ $data->appearance ?? '-' }}</span>
                                </div>
                                @endif
                                @if (in_array('odor', $visibleColumns))
                                <div class="flex justify-between gap-2 text-slate-500"><span>Odor:</span>
                                    <span
                                        class="text-slate-700 font-medium">{{ $data->odor ?? '-' }}</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        @endif

                        @if (array_intersect(['capacity', 'shift', 'machine_id'], $visibleColumns))
                        <td class="px-4 py-4 text-center">
                            {{-- Kapasitas --}}
                            @if (in_array('capacity', $visibleColumns))
                            <span class="font-bold text-slate-700">
                                {{ number_format((float) $data->variant->capacity, 0, ',', '.') }}
                            </span>
                            @endif

                            {{-- Nama Mesin (Baru) --}}
                            @if (in_array('machine_id', $visibleColumns))
                            <div
                                class="text-[10px] font-extrabold text-indigo-600 mt-1 uppercase leading-none">
                                {{ $data->machine->name ?? 'No Machine' }} -
                                {{ $data->machine->category->name }}
                            </div>
                            @endif

                            {{-- Shift --}}
                            @if (in_array('shift', $visibleColumns))
                            <div
                                class="text-[9px] font-bold text-white bg-slate-400 rounded-full px-1 mt-1 uppercase tracking-tighter inline-block">
                                {{ $data->shift ?? '-' }}
                            </div>
                            @endif
                        </td>
                        @endif

                        @if (in_array('notes', $visibleColumns))
                        <td
                            class="px-4 py-4 text-slate-500 text-[10px] leading-relaxed whitespace-normal italic">
                            {{ \Str::limit($data->notes, 100) ?? '-' }}
                        </td>
                        @endif

                        <td class="px-4 py-4 text-center">
                            <div class="inline-flex p-1 bg-slate-100 rounded-sm shadow-inner gap-1">

                                @if ($data->status !== 'hold')
                                <button wire:click="confirmHold({{ $data->id }})" {{-- Logic Disable --}}
                                    @if ($data->status === 'hold') disabled @endif
                                    class="p-1 rounded-sm text-slate-400 hover:bg-red-500 hover:text-white hover:shadow-sm transition-all duration-50"
                                    title="Hold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.36 6.64a9 9 0 11-12.73 0M12 7v5m0 3h.01" />
                                    </svg>
                                </button>
                                @endif

                                {{-- Tombol Rework/Remix --}}
                                {{-- Sembunyikan jika sudah ada di list rework atau sedang di-hold --}}
                                @if ($data->status !== 'active' && !$data->reworkLogs()->where('status', 'active')->exists())
                                <button wire:click="confirmRework({{ $data->id }})"
                                    class="p-1 rounded-sm text-slate-400 hover:bg-amber-500 hover:text-white transition-all"
                                    title="Send to Rework">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>

                        {{-- Inspector & Date (Always Visible) --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-[10px]">
                                    {{ substr($data->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex flex-col text-[10px]">
                                    <span
                                        class="text-slate-700 font-semibold">{{ $data->user->name ?? 'Unknown' }}</span>
                                    <span
                                        class="text-slate-400 font-mono">{{ $data->created_at->format('d/m/y H:i') }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Actions (Always Visible) --}}
                        <td
                            class="px-4 py-4 sticky right-0 bg-white/95 backdrop-blur-sm border-l-2 border-slate-100 {{ $data->status === 'hold' ? 'border-l-4 border-l-red-500' : '' }}">
                            <div class="flex items-center justify-center">
                                {{-- Button CO Job (Disamakan ukurannya dengan Edit/Delete) --}}
                                <button wire:click="toggleCoJob({{ $data->id }})"
                                    class="flex items-center justify-center focus:outline-none transition-all duration-50
                                        {{-- Kotak Luar --}}
                                        w-4 h-4 rounded-[3px] border mr-2 {{-- rounded kecil agar tetap proporsional --}}
                                        {{ $data->co_job
                                            ? 'bg-emerald-500 border-emerald-600 text-white shadow-sm'
                                            : 'bg-white border-slate-300 text-transparent hover:border-indigo-400' }}">

                                    {{-- Icon Centang di dalam Kotak --}}
                                    <svg class="w-2.5 h-2.5 " fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>

                                <span wire:click="edit({{ $data->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 cursor-pointer">
                                    <x-edit-svg />
                                </span>

                                <span wire:click="confirm_delete({{ $data->id }})"
                                    class="text-red-600 hover:text-red-900 cursor-pointer">
                                    <x-delete-svg />
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="20" class="px-5 py-20 text-center">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <div class="p-4 bg-slate-50 rounded-full">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-slate-400 italic text-sm font-medium">No inspection records
                                    found</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="m-2">{{ $datas->links() }}</div>
        </div>
    </x-data-table>
</div>