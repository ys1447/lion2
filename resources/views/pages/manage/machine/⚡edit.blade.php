<?php

use Livewire\Component;
use App\Models\Machine;
use App\Models\Category;
use App\Traits\HasNotification;

new class extends Component
{
    use HasNotification;

    public $machineId;
    public $name;
    public $category_id;
    public $show = false;

    protected $listeners = ['edit-machine' => 'loadMachine'];

    public function loadMachine($id)
    {
        $this->show = true;
        $this->machineId = $id;

        $machine = Machine::findOrFail($id);

        $this->name = $machine->name;
    }

    public function cancel()
    {
        $this->show = false;
    }
    public function update(){
        $this->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);

        $machine = Machine::find($this->machineId);
        $oldName = $machine->name;
        $machineName = $this->name;
        $machine->update([
            'name' => $this->name,
            'category_id' => $this->category_id,
        ]);

        $this->sendNotification(
            action: 'EDIT', 
            target: 'Machine: ' . $machineName,
            details: "Changed machine from '{$oldName}' to '{$machineName}'"
        );

        $this->dispatch('machine-updated');
        $this->dispatch('alert-success', message: 'Mesin berhasil diedit');
        $this->show = false;
    }

    public function render(){
        return $this->view([
            'categories' => Category::pluck('name','id'),
        ]);
    }



};
?>

<div>
    <x-modal :show="$show">

        <form wire:submit.prevent="update">
            <x-form-input wire:model="name" label="Name" forId='name' />
            <x-select-form label="Category" model="category_id" :options="$categories" />
        
            <div class="flex justify-end gap-2">
                <button type="button" wire:click="cancel"
                    class="px-4 py-2 text-sm bg-gray-200 rounded-sm hover:bg-gray-300 cursor-pointer">Cancel</button>

                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-modal>
</div>