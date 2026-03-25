<?php

use Livewire\Component;
use App\Models\JobMixing;
use App\Models\Variant;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification;
    public $show = false;
    public $jobMixingId;

    public $name;
    public $type = true;
    public $code_job_mixing;
    public $capacity;
    public $no_document;
    public $no_ftd;
    public $no_revisi;
    public $is_active = true;
    public $variant_id;

    protected $listeners = ['edit-job-mixing' => 'loadJobMixing'];

    public function loadJobMixing($id)
    {
        $this->resetValidation();
        $this->show = true;
        $this->jobMixingId = $id;

        $jobMixing = JobMixing::findOrFail($id);

        $this->name = $jobMixing->name;
        $this->variant_id = $jobMixing->variant_id;
        $this->type = $jobMixing->type;
        $this->code_job_mixing = $jobMixing->code_job_mixing;
        $this->capacity = $jobMixing->capacity;
        $this->no_document = $jobMixing->no_document;
        $this->no_ftd = $jobMixing->no_ftd;
        $this->no_revisi = $jobMixing->no_revisi;
        $this->is_active = $jobMixing->is_active;
    }

    public function cancel()
    {
        $this->resetValidation();
        $this->show = false;
    }

    public function update()
    {
        $this->validate([
            'variant_id' => 'required|exists:variants,id', // Validasi variant
            'name' => 'required|string|max:255',
            'type' => 'required|boolean',
            'code_job_mixing' => 'required|string|max:255',
            'capacity' => 'required|string|max:50',
            'no_document' => 'required|string|max:100',
            'no_ftd' => 'required|string|max:100',
            'no_revisi' => 'required|string|max:50',
            'is_active' => 'required|boolean',
        ]);

        $jobs = JobMixing::find($this->jobMixingId);
        $jobName = $this->name;
        $jobs->update([
            'variant_id' => $this->variant_id,
            'name' => $this->name,
            'type' => $this->type,
            'code_job_mixing' => $this->code_job_mixing,
            'capacity' => $this->capacity,
            'no_document' => $this->no_document,
            'no_ftd' => $this->no_ftd,
            'no_revisi' => $this->no_revisi,
            'is_active' => $this->is_active,
        ]);

        $this->sendNotification(
            action: 'EDIT', 
            target: 'Job: ' . $jobName,
            details: "Job Mixing '{$jobName}' **has been edited**"
        );


        $this->dispatch('job-mixing-updated');
        $this->dispatch('alert-success', message: 'Data berhasil diedit');
        $this->show = false;
    }

    public function render(){
        return $this->view([
            'variantOptions' => Variant::orderBy('name')->pluck('name', 'id'),
        ]);
    }
};
?>

<div>

    <x-modal :show="$show">

        <form wire:submit.prevent="update">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-sm text-sm">
                    <ul class="text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <x-form-input wire:model="name" label="Name" forId='name' />
            <x-form-input wire:model="code_job_mixing" label="Code Job" forId='code_job_mixing' />
            <x-form-input wire:model="capacity" label="Capacity" forId='capacity' />
            <x-form-input wire:model="no_document" label="No Document" forId='no_document' />
            <x-form-input wire:model="no_ftd" label="No FTD" forId='no_ftd' />
            <x-form-input wire:model="no_revisi" label="No Revisi" forId='no_revisi' />

            <x-select-form label="Type" model="type" :options="[
                '1' => 'Trial',
                '0' => 'Terkendali',
            ]" />

            <x-select-form label="Status" model="is_active" :options="[
                '1' => 'Active',
                '0' => 'Inactive',
            ]" />

            <x-select-form label="Target Variant" model="variant_id" :options="$variantOptions" />

            

            <div class="flex justify-end gap-2">
                <button type="button" wire:click="cancel"
                    class="px-4 py-2 text-sm bg-gray-200 rounded-sm hover:bg-gray-300 cursor-pointer">Cancel</button>

                <x-button type="submit">Update</x-button>
            </div>



        </form>
    </x-modal>
    <x-loading wire:target="cancel, update" />

</div>
