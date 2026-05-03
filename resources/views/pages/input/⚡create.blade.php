<?php

use Livewire\Component;
use App\Models\InputData;
use App\Models\VariantConfig;
use App\Models\Variant;
use App\Models\JobMixing;
use App\Models\Machine;
use Livewire\Attributes\Locked; // Tambahkan ini
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;

new class extends Component {
    #[Locked]
    public $variant; // Diproteksi agar tidak hilang saat refresh/update

    public $visibleColumns = [];

    // Properti Input
    public $batch, $job_number, $ph_1, $ph_2, $ph_3;
    public $viscosity_1, $viscosity_2, $viscosity_3;
    public $specific_gravity, $active_ingredient, $zpt, $soap_percentage;
    public $rad, $rgx, $rxb, $ryc;
    public $appearance = 'ok',
        $odor = 'ok',
        $capacity,
        $shift,
        $job_code,
        $notes;
    public $prod_date;
    public $job_mixing_id; // Properti untuk menampung pilihan user
    public $machine_id;
    public $one_day;

    public function mount($slug)
    {
        // Link Unik
        $this->variant = Variant::where('slug', $slug)->firstOrFail();

        // Auto-select Job Mixing yang aktif (Langsung ambil satu saja, lebih hemat memori)
        $activeJob = JobMixing::where('variant_id', $this->variant->id)->where('is_active', true)->first();

        if ($activeJob) {
            $this->job_mixing_id = $activeJob->id;
            $this->job_code = $activeJob->code_job_mixing;
        }

        // Config Kolom
        $config = VariantConfig::where('variant_id', $this->variant->id)->first();
        $this->visibleColumns = $config ? $config->visible_columns : $this->allFields();

        $this->batch = $this->determineBatch();
        $this->capacity = $this->variant->capacity;

        // Job Number untuk job default langsung terisi
        if ($this->job_mixing_id) {
            $this->job_number = $this->determineJobNumber();
        }

        $this->dispatch('focus-input');
    }

    // Listener untuk menangkap update dari komponen Setting
    #[On('columns-updated')]
    public function updateVisibleColumns($columns)
    {
        $this->visibleColumns = $columns;
    }

    public function updatedJobMixingId($value)
    {
        if ($value) {
            $job = JobMixing::find($value);
            $this->job_code = $job?->code_job_mixing;
            // OTOMATIS hitung job number sesuai memori job tersebut
            $this->job_number = $this->determineJobNumber();
            if ($job) {
                // Hanya update job_code, capacity dibiarkan apa adanya
                $this->job_code = $job->code_job_mixing;
            }
        } else {
            $this->job_code = '';
            $this->job_number = '';
        }
    }

    public function allFields()
    {
        return ['one_day','batch', 'machine_id', 'job_number', 'ph_1', 'ph_2', 'ph_3', 'viscosity_1', 'viscosity_2', 'viscosity_3', 'specific_gravity', 'active_ingredient', 'zpt', 'soap_percentage', 'rad', 'rgx', 'rxb', 'ryc', 'appearance', 'odor', 'capacity', 'shift', 'job_code', 'notes'];
    }

    private function determineShift()
    {
        $now = now();
        $day = $now->dayOfWeek;
        $time = $now->format('H:i');

        // FORMAT BARU: Tanggal-Bulan-Tahun (Contoh: 210326)
        $this->prod_date = $now->format('dmy');

        // LOGIKA SABTU
        if ($day === 6) {
            if ($time >= '06:00' && $time <= '11:00') {
                return 'Shift 1';
            }
            if ($time > '11:00' && $time <= '16:00') {
                return 'Shift 2';
            }

            // Shift 3 Sabtu dini hari (sebelum jam 6 pagi) ikut hari Jumat
            if ($time >= '00:00' && $time <= '05:59') {
                $this->prod_date = $now->subDay()->format('dmy');
            }
            return 'Shift 3';
        }

        // LOGIKA NORMAL
        if ($time >= '06:00' && $time <= '14:00') {
            return 'Shift 1';
        }
        if ($time > '14:00' && $time <= '22:00') {
            return 'Shift 2';
        }

        // Shift 3 dini hari (00:00 - 05:59) ikut hari kemarin
        if ($time >= '00:00' && $time <= '05:59') {
            $this->prod_date = $now->subDay()->format('dmy');
        }
        return 'Shift 3';
    }

    private function determineBatch()
    {
        // Isi prod_date lewat fungsi shift
        $this->shift = $this->determineShift();

        $prodDate = $this->prod_date;

        // Cari data yang batch-nya diawali dengan dmy hari ini
        $lastEntry = InputData::where('variant_id', $this->variant->id) // Filter murni per varian ini
            ->where('batch', 'like', $prodDate . '%')
            ->latest('id')
            ->first();

        if (!$lastEntry) {
            // Jika belum ada, hasilkan: 2103261
            return $prodDate . '1';
        }

        // Ambil string batch (misal 21032610)
        // substr(..., 6) membuang 6 digit awal (210326)
        $lastCounter = (int) substr($lastEntry->batch, 6);

        // Gabungkan kembali: 210326 + (10+1) = 21032611
        return $prodDate . ($lastCounter + 1);
    }

    private function determineJobNumber()
    {
        // 1. Ambil data Job Mixing yang terpilih
        $job = JobMixing::find($this->job_mixing_id);
        if (!$job) {
            return null;
        }

        // 2. Tentukan batas awal tahun (Aturan: Reset jam 06:00 pagi setiap 1 Januari)
        $now = now();
        $currentYear = $now->year;

        // Logika: Jika sekarang masih sebelum jam 06:00 di tanggal 1 Januari,
        // maka dianggap masih tahun lalu secara sistem produksi.
        if ($now->month == 1 && $now->day == 1 && $now->format('H:i') < '06:00') {
            $startYear = $currentYear - 1;
        } else {
            $startYear = $currentYear;
        }

        // Tanggal cut-off reset (Contoh: 2026-01-01 06:00:00)
        $cutoffTime = Carbon::create($startYear, 1, 1, 6, 0, 0);

        // 3. Cari entri terakhir di tabel InputData KHUSUS untuk Job ini sejak cut-off
        $lastEntry = InputData::where('job_mixing_id', $this->job_mixing_id)->where('created_at', '>=', $cutoffTime)->latest('id')->first();

        // 4. Hitung angka berikutnya
        $counter = 1;
        if ($lastEntry) {
            // Hapus huruf (seperti 'T') dan ambil angkanya saja untuk ditambah 1
            $lastNumericValue = preg_replace('/[^0-9]/', '', $lastEntry->job_number);
            $counter = (int) $lastNumericValue + 1;
        }

        // 5. Beri prefix 'T' jika type adalah true (Trial)
        $prefix = $job->type == true ? 'T' : '';

        return $prefix . $counter;
    }

    public function save()
    {
        // 1. Tambahkan validasi remix jika checkbox dicentang
        $rules = [
            'job_mixing_id' => 'required|exists:job_mixings,id',
            'machine_id' => 'required',
            'batch' => 'required', // Tambahkan unique agar tidak double input
        ];

        if ($this->useRemix) {
            $rules['selectedReworkId'] = 'required';
            $rules['remixWeight'] = 'required|numeric|min:0.01';
        }

        $this->validate($rules);

        // Gunakan Transaction agar data aman
        \DB::transaction(function () {
            $job = JobMixing::find($this->job_mixing_id);
            if ($job) {
                $this->job_code = $job->code_job_mixing;
            }

            $userId = auth()->user()->getAttributes()['id'];

            // 2. Eksekusi Create Data Utama
            $newInput = InputData::create([
                'job_mixing_id' => $this->job_mixing_id,
                'user_id' => $userId,
                'variant_id' => $this->variant->id,
                'machine_id' => $this->machine_id,
                'batch' => $this->batch,
                'job_number' => $this->determineJobNumber(),
                'ph_1' => $this->ph_1,
                'ph_2' => $this->ph_2,
                'ph_3' => $this->ph_3,
                'viscosity_1' => $this->viscosity_1,
                'viscosity_2' => $this->viscosity_2,
                'viscosity_3' => $this->viscosity_3,
                'specific_gravity' => $this->specific_gravity,
                'active_ingredient' => $this->active_ingredient,
                'zpt' => $this->zpt,
                'soap_percentage' => $this->soap_percentage,
                'rad' => $this->rad,
                'rgx' => $this->rgx,
                'rxb' => $this->rxb,
                'ryc' => $this->ryc,
                'appearance' => $this->appearance,
                'odor' => $this->odor,
                'capacity' => $this->variant->capacity,
                'shift' => $this->shift,
                'job_code' => $this->job_code,
                'notes' => $this->notes,
                'oneday' => $this->one_day,
            ]);

            // 3. LOGIKA REMIX: Potong stok jika checkbox aktif
            if ($this->useRemix && $this->selectedReworkId) {
                $reworkLog = \App\Models\ReworkLog::lockForUpdate()->find($this->selectedReworkId);

                // Cek manual stok sekali lagi untuk keamanan
                if ($this->remixWeight > $reworkLog->current_quantity) {
                    throw new \Exception('Stok Remix tidak mencukupi!');
                }

                // Catat Detail Penggunaan
                $reworkLog->details()->create([
                    'quantity_used' => $this->remixWeight,
                    'target_batch_number' => $newInput->batch, // Mengacu ke batch baru yg baru dibuat
                    'shift' => $this->shift,
                    'notes' => 'Auto-remix during input data',
                ]);

                // Kurangi sisa kuota
                $reworkLog->current_quantity -= $this->remixWeight;
                if ($reworkLog->current_quantity <= 0) {
                    $reworkLog->status = 'done';
                    $reworkLog->current_quantity = 0;
                }
                $reworkLog->save();
            }
        });

        // 4. Reset Field (Tambahkan variabel remix di sini)
        $this->reset(['machine_id', 'batch', 'job_number', 'ph_1', 'ph_2', 'ph_3', 'viscosity_1', 'viscosity_2', 'viscosity_3', 'specific_gravity', 'active_ingredient', 'zpt', 'soap_percentage', 'rad', 'rgx', 'rxb', 'ryc', 'appearance', 'odor', 'capacity', 'shift', 'job_code', 'notes', 'useRemix', 'selectedReworkId', 'remixWeight', 'one_day']);

        // Isi ulang batch otomatis
        $this->batch = $this->determineBatch();
        $this->capacity = $this->variant->capacity;
        $this->job_number = $this->determineJobNumber();

        $this->dispatch('focus-input');
        $this->dispatch('data-added');
        $this->dispatch('alert-success', message: 'Data & Remix info has been saved!');
    }

    // Hook ini otomatis terpanggil jika validasi gagal di mana pun (save, update, dll)
    public function exception($e)
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $this->dispatch('alert-error', message: $e->validator->errors()->first());
        }
    }

    public $useRemix = false;
    public $selectedReworkId = null;
    public $remixWeight = 0;

    public function getAvailableReworksProperty()
    {
        return \App\Models\ReworkLog::where('status', 'active')
            ->where('current_quantity', '>', 0)
            ->with('inputData.variant') // Asumsi relasi inputData ada di model ReworkLog
            ->get();
    }

    public function render()
    {
        return $this->view([
            'jobMixingSelect' => JobMixing::where('variant_id', $this->variant->id)->where('is_active', true)->pluck('code_job_mixing', 'id'), // 'label', 'value'
            'machineSelect' => Machine::with('category') // Eager load relasi kategori
                ->get()
                ->mapWithKeys(function ($machine) {
                    // Gabungkan Nama Mesin - Nama Kategori
                    $categoryName = $machine->category->name ?? 'No Category';
                    return [$machine->id => "{$machine->name} - {$categoryName}"];
                }),
        ]);
    }
};
?>

<div>

    <x-loading wire:target='save' />
    <livewire:pages::input.column :variant="$variant" />

    <form wire:submit.prevent='save'>

        {{-- GRID 3 KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


            {{-- LEFT --}}
            <div class="space-y-3">
                <h3 class="font-bold">Production Info</h3>

                @if (in_array('batch', $visibleColumns))
                    <x-form-input wire:model='batch' label="Next Batch" forId="batch" />
                @endif

                @if (in_array('job_number', $visibleColumns))
                    <x-form-input wire:model='job_number' label="Next Job Number" forId="job_number" />
                @endif

                <x-select-form wire:key="select-job-{{ $variant->id }}" label="Job Code"
                    wire:model.live="job_mixing_id" :options="$jobMixingSelect" />

                @if (in_array('machine_id', $visibleColumns))
                    <x-select-form label="Machine" wire:model.live="machine_id" :options="$machineSelect" />
                @endif

                <h3 class="font-bold mt-4">pH</h3>

                @if (in_array('ph_1', $visibleColumns))
                    <x-form-input class="first-input" wire:model='ph_1' label="pH 1" forId="ph_1" type="number"
                        step="0.01" />
                @endif
                @if (in_array('ph_2', $visibleColumns))
                    <x-form-input wire:model='ph_2' label="pH 2" forId="ph_2" type="number" step="0.01" />
                @endif
                @if (in_array('ph_3', $visibleColumns))
                    <x-form-input wire:model='ph_3' label="pH 3" forId="ph_3" type="number" step="0.01" />
                @endif

                <h3 class="font-bold">Viscosity</h3>

                @if (in_array('viscosity_1', $visibleColumns))
                    <x-form-input wire:model='viscosity_1' label="Viscosity 1" forId="viscosity_1" type="number"
                        step="0.01" />
                @endif
                @if (in_array('viscosity_2', $visibleColumns))
                    <x-form-input wire:model='viscosity_2' label="Viscosity 2" forId="viscosity_2" type="number"
                        step="0.01" />
                @endif
                @if (in_array('viscosity_3', $visibleColumns))
                    <x-form-input wire:model='viscosity_3' label="Viscosity 3" forId="viscosity_3" type="number"
                        step="0.01" />
                @endif
                



            </div>

            {{-- CENTER --}}
            <div class="space-y-3">


                <h3 class="font-bold mt-4">Parameters</h3>

                @if (in_array('specific_gravity', $visibleColumns))
                    <x-form-input wire:model='specific_gravity' label="Specific Gravity" forId="specific_gravity" />
                @endif
                @if (in_array('active_ingredient', $visibleColumns))
                    <x-form-input wire:model='active_ingredient' label="Active Ingredient" forId="active_ingredient" />
                @endif
                @if (in_array('zpt', $visibleColumns))
                    <x-form-input wire:model='zpt' label="ZPT" forId="zpt" />
                @endif
                @if (in_array('soap_percentage', $visibleColumns))
                    <x-form-input wire:model='soap_percentage' label="Soap (%)" forId="soap_percentage" />
                @endif
                @if (in_array('notes', $visibleColumns))
                    <div class="mt-6">
                        <label for="notes" class="block text-sm font-medium mb-1">
                            Notes
                        </label>
                        <textarea wire:model="notes" id="notes" rows="4"
                            class="w-full text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 p-2"></textarea>
                    </div>
                @endif
                @if (in_array('one_day', $visibleColumns))
                    <div class="mt-6">
                        <label for="1day" class="block text-sm font-medium mb-1">
                            1 Day
                        </label>
                        <textarea wire:model="one_day" id="1day" rows="4" placeholder="pH / visco / sg ..."
                            class="w-full text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 p-2"></textarea>
                    </div>
                @endif
            </div>

            {{-- RIGHT --}}
            <div class="space-y-3">
                <h3 class="font-bold">Adjustment</h3>

                @if (in_array('rad', $visibleColumns))
                    <x-form-input wire:model='rad' label="RAD" forId="rad" />
                @endif
                @if (in_array('rgx', $visibleColumns))
                    <x-form-input wire:model='rgx' label="RGX" forId="rgx" />
                @endif
                @if (in_array('rxb', $visibleColumns))
                    <x-form-input wire:model='rxb' label="RXB" forId="rxb" />
                @endif
                @if (in_array('ryc', $visibleColumns))
                    <x-form-input wire:model='ryc' label="RYC" forId="ryc" />
                @endif

                <h3 class="font-bold mt-4">Others</h3>

                @if (in_array('appearance', $visibleColumns))
                    <x-form-input wire:model='appearance' label="Appearance" forId="appearance" />
                @endif
                @if (in_array('odor', $visibleColumns))
                    <x-form-input wire:model='odor' label="Odor" forId="odor" />
                @endif
                @if (in_array('capacity', $visibleColumns))
                    <x-form-input wire:model='capacity' label="Capacity" forId="capacity" />
                @endif
                @if (in_array('shift', $visibleColumns))
                    <x-form-input wire:model='shift' label="Shift" forId="shift" />
                @endif

                <div class="mt-6 p-5 border border-gray-200 rounded-sm bg-gray-50/50">
                    <!-- Header Section -->
                    <div class="flex items-center gap-3 pb-3 border-b border-gray-200 mb-4">
                        <input type="checkbox" wire:model.live="useRemix" id="remixCheck"
                            class="w-4 h-4 text-indigo-600 rounded-sm border-gray-300 focus:ring-indigo-500 cursor-pointer">
                        <label for="remixCheck"
                            class="text-xs font-bold uppercase tracking-wider text-gray-700 cursor-pointer">
                            Gunakan Bahan Remix?
                        </label>
                    </div>

                    @if ($useRemix)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 animate-fadeIn">

                            {{-- Pilih Batch Asal --}}
                            <div class="my-2">
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Pilih Batch Asal Remix
                                </label>
                                <select wire:model.live="selectedReworkId"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 bg-white">
                                    <option value="">-- Pilih Tersedia --</option>
                                    @foreach ($this->availableReworks as $rw)
                                        <option value="{{ $rw->id }}">
                                            {{ $rw->inputData->batch }} | {{ $rw->inputData->variant->name }}
                                            (Sisa: {{ number_format($rw->current_quantity) }} KG)
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedReworkId')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Berat yang digunakan --}}
                            <div class="my-2">
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Berat Remix yang Dipakai (KG)
                                </label>
                                <input type="number" wire:model="remixWeight"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                    placeholder="0.00">
                                @error('remixWeight')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-2">
                            <p class="text-[10px] text-gray-400 italic">
                                *Stok akan otomatis terpotong setelah data disimpan.
                            </p>
                        </div>
                    @endif
                </div>

            </div>

        </div>




        {{-- BUTTON --}}
        <div class="mt-4">
            <x-button type="submit">
                Create Input Data
            </x-button>
        </div>

    </form>
</div>
