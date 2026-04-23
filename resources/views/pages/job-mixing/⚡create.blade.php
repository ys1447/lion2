<?php

use Livewire\Component;
use App\Models\Variant;
use App\Models\JobMixing;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $name = '';
    public $variant_id = '';
    public $type = true;
    public $code_job_mixing = '';
    public $capacity = '';
    public $no_document = '';
    public $no_ftd = '';
    public $no_revisi = '';
    public $is_active = true;
    public $file_pdf;

    public function save()
    {
        $this->validate([
            'variant_id' => 'required|exists:variants,id', // Validasi variant
            'name' => 'required|string|max:255',
            'type' => 'required|boolean',
            'code_job_mixing' => 'required|string',
            'capacity' => 'required|string|max:50',
            'no_document' => 'required|string|max:100',
            'no_ftd' => 'required|string|max:100',
            'no_revisi' => 'required|string|max:50',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',

            // is active sementara nullable soalnya blm relasi
            'is_active' => 'nullable',
        ]);

        $filePath = null;
        if ($this->file_pdf) {
            // Simpan ke folder 'job_mixing_files' di disk 'public'
            $filePath = $this->file_pdf->store('job_mixing_files', 'public');
        }


        JobMixing::create([
            'variant_id' => $this->variant_id,
            'name' => $this->name,
            'type' => $this->type,
            'code_job_mixing' => $this->code_job_mixing,
            'capacity' => $this->capacity,
            'no_document' => $this->no_document,
            'no_ftd' => $this->no_ftd,
            'no_revisi' => $this->no_revisi,
            'is_active' => $this->is_active,
            'file_path' => $filePath,
        ]);

        $this->reset();
        $this->dispatch('job-added');
        $this->dispatch('alert-success', message: 'Data berhasil ditambahkan');
    }

    public function render()
    {
        return $this->view([
            'variantOptions' => Variant::orderBy('name')->pluck('name', 'id'),
        ]);
    }
};
?>

<div>
    {{-- Order your soul. Reduce your wants. - Augustine --}}


    <div class="w-full p-6 bg-white rounded-sm shadow-sm">
        <h2 class="text-xl font-semibold mb-2 text-indigo-800">Input Job Mixing</h2>

        <form wire:submit.prevent='save'>
            <x-form-input wire:model='name' label="Name" class="first-input" forId='name' placeholder="Jeruk Nipis 13T"
                :error="$errors->first('name')" />
            <x-form-input wire:model='code_job_mixing' label="Code Job" forId='code_job' placeholder="RLE11"
                :error="$errors->first('code_job_mixing')" />
            <x-form-input wire:model='capacity' label="Capacity (kg)" forId='capacity' placeholder="13000"
                :error="$errors->first('capacity')" />
            <x-form-input wire:model='no_revisi' label="No Revisi" forId='no_revisi' placeholder="0 ,. -"
                :error="$errors->first('no_revisi')" />
            <x-form-input wire:model='no_document' label="No Document" forId='no_document' placeholder="0 ,. -"
                :error="$errors->first('no_document')" />
            <x-form-input wire:model='no_ftd' label="No FTD" forId='no_ftd' placeholder="0 ,. -" :error="$errors->first('no_ftd')" />
            <x-select-form label="Type" model="type" :options="[
                '1' => 'Trial',
                '0' => 'Terkendali',
            ]" />
            <x-select-form label="Target Variant" model="variant_id" :options="$variantOptions" />
            <x-form-input wire:model="file_pdf" type="file" label="Upload Document (PDF, Max 2MB)" forId="file_pdf"
                :error="$errors->first('file_pdf')"
                class="file:mr-4 file:py-1 file:px-4 file:rounded-sm file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />

            {{-- Progress Loading (Opsional tapi sangat disarankan untuk File Upload) --}}
            <div wire:loading wire:target="file_pdf" class="text-[10px] text-indigo-600 mb-4 italic animate-pulse">
                Sistem sedang memproses file, mohon tunggu...
            </div>
            <x-button type="submit"> Create New Job </x-button>
        </form>
    </div>
</div>
