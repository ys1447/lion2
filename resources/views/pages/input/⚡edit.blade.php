<?php

use Livewire\Component;
use App\Models\InputData;
use App\Models\JobMixing;
use App\Models\Machine;
use App\Models\VariantConfig;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification;

    public $show = false;
    public $inputDataId;

    // Properti sesuai database
    public $batch, $job_number, $ph_1, $ph_2, $ph_3;
    public $viscosity_1, $viscosity_2, $viscosity_3;
    public $specific_gravity, $active_ingredient, $zpt, $soap_percentage;
    public $rad, $rgx, $rxb, $ryc;
    public $appearance, $odor, $capacity, $shift, $job_code, $notes;
    public $job_mixing_id, $machine_id, $variant_id;

    public $visibleColumns = [];

    protected $listeners = ['edit-input-data' => 'loadInputData'];

    public function allFields()
    {
        return ['machine_id', 'batch', 'job_number', 'job_code', 'ph_1', 'ph_2', 'ph_3', 'viscosity_1', 'viscosity_2', 'viscosity_3', 'specific_gravity', 'active_ingredient', 'zpt', 'soap_percentage', 'rad', 'rgx', 'rxb', 'ryc', 'appearance', 'odor', 'capacity', 'shift', 'notes'];
    }

    public function loadInputData($id)
    {
        $this->inputDataId = $id;

        $data = InputData::findOrFail($id);

        // Isi semua properti
        $this->variant_id = $data->variant_id;
        $this->job_mixing_id = $data->job_mixing_id;
        $this->machine_id = $data->machine_id;
        $this->batch = $data->batch;
        $this->job_number = $data->job_number;
        $this->ph_1 = $data->ph_1;
        $this->ph_2 = $data->ph_2;
        $this->ph_3 = $data->ph_3;
        $this->viscosity_1 = $data->viscosity_1;
        $this->viscosity_2 = $data->viscosity_2;
        $this->viscosity_3 = $data->viscosity_3;
        $this->specific_gravity = $data->specific_gravity;
        $this->active_ingredient = $data->active_ingredient;
        $this->zpt = $data->zpt;
        $this->soap_percentage = $data->soap_percentage;
        $this->rad = $data->rad;
        $this->rgx = $data->rgx;
        $this->rxb = $data->rxb;
        $this->ryc = $data->ryc;
        $this->appearance = $data->appearance;
        $this->odor = $data->odor;
        $this->capacity = $data->capacity;
        $this->shift = $data->shift;
        $this->notes = $data->notes;

        // Ambil config kolom berdasarkan varian data tersebut
        $config = VariantConfig::where('variant_id', $this->variant_id)->first();
        $this->visibleColumns = $config ? $config->visible_columns : $this->allFields();

        $this->show = true;
    }

    // Method ini akan terpanggil otomatis saat dropdown Job Code diubah (karena wire:model.live)
    public function updatedJobMixingId($value)
    {
        if ($value) {
            $job = JobMixing::find($value);
            $this->job_code = $job?->code_job_mixing;

            // OTOMATIS hitung job number baru untuk record ini
            $this->job_number = $this->determineJobNumber();
        }
    }

    private function determineJobNumber()
    {
        $job = JobMixing::find($this->job_mixing_id);
        if (!$job) {
            return null;
        }

        $now = now();
        // Logika reset tahunan jam 06:00 (sama dengan logic create)
        $startYear = $now->month == 1 && $now->day == 1 && $now->format('H:i') < '06:00' ? $now->year - 1 : $now->year;

        $cutoffTime = \Illuminate\Support\Carbon::create($startYear, 1, 1, 6, 0, 0);

        // Cari entri terakhir (kecuali data yang sedang di-edit ini agar tidak bentrok)
        $lastEntry = InputData::where('job_mixing_id', $this->job_mixing_id)
            ->where('id', '!=', $this->inputDataId) // Penting: Jangan hitung dirinya sendiri
            ->where('created_at', '>=', $cutoffTime)
            ->latest('id')
            ->first();

        $counter = 1;
        if ($lastEntry) {
            $lastNumericValue = preg_replace('/[^0-9]/', '', $lastEntry->job_number);
            $counter = (int) $lastNumericValue + 1;
        }

        $prefix = $job->type == true ? 'T' : '';
        return $prefix . $counter;
    }

    public function cancel()
    {
        $this->show = false;
    }

    public function render()
    {
        return $this->view([
            // Tambahkan optional chaining atau default value agar tidak error saat variant_id null
            'jobMixingOptions' => $this->variant_id ? JobMixing::where('variant_id', $this->variant_id)->pluck('code_job_mixing', 'id') : [],
            'machineOptions' => Machine::with('category')->get()->mapWithKeys(fn($m) => [$m->id => "{$m->name} - {$m->category->name}"]),
        ]);
    }

    public function update()
    {
        // 1. Validasi Data terlebih dahulu
        $validated = $this->validate([
            'job_mixing_id' => 'required|exists:job_mixings,id',
            'machine_id' => 'required|exists:machines,id',
            'batch' => 'nullable|string',
            'job_number' => 'nullable|string',
            'ph_1' => 'nullable|numeric',
            'ph_2' => 'nullable|numeric',
            'ph_3' => 'nullable|numeric',
            'viscosity_1' => 'nullable|numeric',
            'viscosity_2' => 'nullable|numeric',
            'viscosity_3' => 'nullable|numeric',
            'specific_gravity' => 'nullable|numeric',
            'active_ingredient' => 'nullable|numeric',
            'zpt' => 'nullable|numeric',
            'soap_percentage' => 'nullable|numeric',
            'rad' => 'nullable|numeric',
            'rgx' => 'nullable|numeric',
            'rxb' => 'nullable|numeric',
            'ryc' => 'nullable|numeric',
            'appearance' => 'nullable|string',
            'odor' => 'nullable|string',
            'shift' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $data = InputData::findOrFail($this->inputDataId);

            $dataVariant = $data->variant->name;
            $dataBatch = $data->batch;

            // Simpan ID Job Mixing yang LAMA sebelum diupdate
            $oldJobMixingId = $data->job_mixing_id;
            $newJobMixingId = $this->job_mixing_id;

            $jobMixing = JobMixing::find($newJobMixingId);
            if ($jobMixing) {
                $validated['job_code'] = $jobMixing->code_job_mixing;
            }

            // 2. Jalankan Update Data Utama
            $data->update($validated);

            // 3. LOGIC RE-SEQUENCE (Penting!)
            // Kita rapikan urutan untuk Job yang lama DAN Job yang baru
            $this->reSequenceJobNumbers($oldJobMixingId);

            if ($oldJobMixingId != $newJobMixingId) {
                $this->reSequenceJobNumbers($newJobMixingId);
            }

            $this->sendNotification(action: 'EDIT', target: 'Input Variant: ' . $dataVariant, details: "Edited data batch '{$dataBatch}' in the system");

            $this->show = false;

            $this->dispatch('input-data-updated');
            $this->dispatch('alert-success', message: 'Data berhasil diperbarui dan urutan dirapikan!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Fungsi untuk mengurutkan ulang semua job_number berdasarkan urutan input (ID atau created_at)
     */
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
};
?>

<div>
    <x-modal :show="$show">
        {{-- Hapus p-6 di sini agar scroll bisa sampai ke tepi --}}

        <x-loading wire:target='cancel, update' />

        <form wire:submit.prevent="update">
            {{-- Area Scroll: padding dipindah ke dalam sini (px-6) agar konten tidak menempel tapi scrollbar tetap di tepi --}}
            <div class="overflow-y-auto space-y-8">

                {{-- GROUP 1: Production Info --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-2 border-l-4 border-slate-400 pl-2">
                        <h3 class="text-xs font-bold text-slate-500 uppercase">Production Info</h3>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-sm space-y-4 border border-slate-100">
                        <x-select-form label="Job Code" forId="job_mixing_id" wire:model.live="job_mixing_id"
                            :options="$jobMixingOptions" />
                        <x-select-form label="Machine" forId="machine_id" wire:model.live="machine_id"
                            :options="$machineOptions" />
                        {{-- Input Batch --}}
                        @if (in_array('batch', $visibleColumns))
                            <x-form-input label="Batch Number" forId="batch" wire:model="batch"
                                placeholder="-" />
                        @endif

                    </div>

                </div>

                {{-- GROUP 2: pH & Viscosity --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-2 border-l-4 border-blue-400 pl-2">
                        <h3 class="text-xs font-bold text-blue-600 uppercase">Chemical & Physical</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-3">
                            @if (in_array('ph_1', $visibleColumns))
                                <x-form-input label="pH 1" forId="ph_1" wire:model="ph_1" type="number"
                                    step="0.01" />
                            @endif
                            @if (in_array('ph_2', $visibleColumns))
                                <x-form-input label="pH 2" forId="ph_2" wire:model="ph_2" type="number"
                                    step="0.01" />
                            @endif
                            @if (in_array('ph_3', $visibleColumns))
                                <x-form-input label="pH 3" forId="ph_3" wire:model="ph_3" type="number"
                                    step="0.01" />
                            @endif
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            @if (in_array('viscosity_1', $visibleColumns))
                                <x-form-input label="Visc 1" forId="v1" wire:model="viscosity_1" type="number" />
                            @endif
                            @if (in_array('viscosity_2', $visibleColumns))
                                <x-form-input label="Visc 2" forId="v2" wire:model="viscosity_2" type="number" />
                            @endif
                            @if (in_array('viscosity_3', $visibleColumns))
                                <x-form-input label="Visc 3" forId="v3" wire:model="viscosity_3" type="number" />
                            @endif
                        </div>
                        @if (in_array('specific_gravity', $visibleColumns))
                            <x-form-input label="Specific Gravity (SG)" forId="sg" wire:model="specific_gravity" />
                        @endif
                    </div>
                </div>

                {{-- GROUP 3: Ingredients & Active Compounds --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-2 border-l-4 border-emerald-400 pl-2">
                        <h3 class="text-xs font-bold text-emerald-600 uppercase">Ingredients & Active</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            @if (in_array('active_ingredient', $visibleColumns))
                                <x-form-input label="Active Ingredient" forId="active" wire:model="active_ingredient" />
                            @endif
                            @if (in_array('zpt', $visibleColumns))
                                <x-form-input label="ZPT" forId="zpt" wire:model="zpt" />
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            @if (in_array('soap_percentage', $visibleColumns))
                                <x-form-input label="Soap %" forId="soap" wire:model="soap_percentage" />
                            @endif
                        </div>
                        {{-- Row untuk RAD, RGX, RXB, RYC --}}
                        <div class="grid grid-cols-4 gap-2">
                            @if (in_array('rad', $visibleColumns))
                                <x-form-input label="RAD" forId="rad" wire:model="rad" />
                            @endif
                            @if (in_array('rgx', $visibleColumns))
                                <x-form-input label="RGX" forId="rgx" wire:model="rgx" />
                            @endif
                            @if (in_array('rxb', $visibleColumns))
                                <x-form-input label="RXB" forId="rxb" wire:model="rxb" />
                            @endif
                            @if (in_array('ryc', $visibleColumns))
                                <x-form-input label="RYC" forId="ryc" wire:model="ryc" />
                            @endif
                        </div>
                    </div>
                </div>

                {{-- GROUP 4: Organoleptic & Notes --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-2 border-l-4 border-purple-400 pl-2">
                        <h3 class="text-xs font-bold text-purple-600 uppercase">Final Inspection</h3>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-sm space-y-4 border border-slate-100">
                        <div class="grid grid-cols-2 gap-3">
                            @if (in_array('appearance', $visibleColumns))
                                <x-form-input label="Appearance" forId="appearance" wire:model="appearance" />
                            @endif
                            @if (in_array('odor', $visibleColumns))
                                <x-form-input label="Odor" forId="odor" wire:model="odor" />
                            @endif
                        </div>
                        @if (in_array('notes', $visibleColumns))
                            <div class="col-span-2">
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Notes</label>
                                <textarea wire:model="notes" rows="3"
                                    class="w-full text-sm border border-slate-300 rounded-sm focus:border-blue-400 focus:ring-1 focus:ring-blue-100 outline-none transition duration-150"></textarea>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tombol: Sekarang berada di dalam area scroll paling bawah --}}
                <div class="flex justify-end gap-2 mt-10 pt-6 pb-6">
                    <button type="button" wire:click="cancel"
                        class="px-4 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-200 hover:bg-slate-200 rounded-sm transition cursor-pointer">
                        Cancel
                    </button>
                    <x-button type="submit">Update Data</x-button>
                </div>

            </div> {{-- Tutup Area Scroll --}}
        </form>

    </x-modal>
    <x-loading wire:target="update" />
</div>
