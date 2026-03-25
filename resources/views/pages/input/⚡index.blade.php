<?php

use Livewire\Component;
use App\Models\Variant;

new class extends Component {
    
    public $variant;
    public $slug;
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->variant = Variant::where('slug', $slug)->firstOrFail();
    }
}
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Input Data - {{ $variant->name }} - {{ $variant->category->name }}</h1>
        <p class="text-slate-500 text-sm">
             Input quality control data for this variant. Ensure all parameters are recorded accurately.
        </p>
    </div>

    <div class="space-y-8">
        <livewire:pages::input.create :slug="$slug"/>
        <livewire:pages::input.table :variantId="$variant->id"/>
        <livewire:pages::input.edit />
    </div>

</div>
