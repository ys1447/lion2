<?php

use Livewire\Component;
use App\Models\JobMixing;
use Livewire\Attributes\On;
use App\Traits\HasNotification;
use Livewire\WithPagination;

new class extends Component {
    use HasNotification, WithPagination;
    protected $listeners = ['job-added', 'job-mixing-updated', 'job-mixing-deleted' => '$refresh'];
    
    public $search = '';
    public $isActiveFilter = '';
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedIsActiveFilter()
    {
        // Setiap kali ganti filter, balikkan ke halaman 1
        $this->resetPage();
    }

    public function render()
    {
        return $this->view([
            // 5. Ubah JobMixing::all() menjadi query dengan search scope
            'jobMixings' => JobMixing::query()
                ->with('variant') // Eager load agar tidak N+1 query
                ->search($this->search) 
                ->withIsActive($this->isActiveFilter)
                ->latest()
                ->paginate(10), // Gunakan paginate agar lebih ringan
        ]);
    }

    public function edit($id){
        $this->dispatch('edit-job-mixing', id: $id);
    }

    public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'job-mixing', // beda tiap component
        );
    }

    #[On('delete-job-mixing')]
    public function delete($id)
    {
        $jobs = JobMixing::findOrFail($id);
        $jobName = $jobs->name;
        $jobs->delete();
        $this->sendNotification(
            action: 'DELETE', 
            target: 'Job: ' . $jobName,
            details: "Job Mixing '{$jobName}' **has been deleted**"
        );
        $this->dispatch('alert-success', message: 'Data berhasil dihapus');
    }

    
};
?>

<div>
    {{-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci --}}
    <div class="gap-2 flex">

        <x-search model='search' />
        <x-filter model="isActiveFilter">
            <option value="">All Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </x-filter>
    </div>
    <x-data-table title="Job Mixing List">
        <x-slot:head>
            <th class="px-5 py-3 font-semibold w-16 text-center">No</th>
            <th class="px-5 py-3 font-semibold">Name</th>
            <th class="px-5 py-3 font-semibold">Variant</th>
            <th class="px-5 py-3 font-semibold">Code</th>
            <th class="px-5 py-3 font-semibold">Capacity</th>
            <th class="px-5 py-3 font-semibold">Type</th>
            <th class="px-5 py-3 font-semibold">No Document</th>
            <th class="px-5 py-3 font-semibold">No FTD</th>
            <th class="px-5 py-3 font-semibold">Revisi</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 font-semibold">Created</th>
            <th class="px-5 py-3 font-semibold text-right">Action</th>
        </x-slot:head>

        @foreach ($jobMixings as $i => $job)
            <tr wire:key="job-{{ $job->id }}" class="hover:bg-slate-50 transition-colors align-middle">

                <td class="px-5 py-3 text-center text-slate-500 font-medium">
                    {{ $i + 1 }}
                </td>

                <td class="px-5 py-3">
                    <span class="font-medium text-slate-700">{{ $job->name }}</span>
                </td>
                
                <td class="px-5 py-3">
                    <span class="text-xs px-2 py-1 rounded-sm bg-amber-100 text-amber-800">{{ $job->variant->name }}</span>
                </td>

                <td class="px-5 py-3 text-slate-600">
                    {{ $job->code_job_mixing }}
                </td>

                <td class="px-5 py-3 text-slate-600">
                    {{ $job->capacity }}
                </td>

                <td class="px-5 py-3">
                    <span
                        class="text-xs px-2 py-1 rounded-sm 
                    {{ $job->type ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $job->type ? 'Trial' : 'Terkendali' }}
                    </span>
                </td>

                <td class="px-5 py-3 text-slate-600">
                    {{ $job->no_document }}
                </td>

                <td class="px-5 py-3 text-slate-600">
                    {{ $job->no_ftd }}
                </td>

                <td class="px-5 py-3 text-slate-600">
                    {{ $job->no_revisi }}
                </td>

                <td class="px-5 py-3">
                    <span
                        class="text-xs px-2 py-1 rounded-sm 
                    {{ $job->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $job->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <td class="px-5 py-3 text-slate-500">
                    {{ $job->created_at->diffForHumans() }}
                </td>

                <td class="px-5 py-3 text-right flex items-center justify-end gap-2">
                    <span wire:click="edit({{ $job->id }})"
                        class="text-indigo-600 hover:text-indigo-900 cursor-pointer">
                        <x-edit-svg />
                    </span>

                    <span wire:click="confirm_delete({{ $job->id }})"
                        class="text-red-600 hover:text-red-900 cursor-pointer">
                        <x-delete-svg />
                    </span>
                </td>

            </tr>
        @endforeach
    </x-data-table>
    {{-- Tambahkan ini untuk navigasi halaman --}}
    <div class="mt-4">
        {{ $jobMixings->links() }}
    </div>

    <x-loading wire:target="edit, delete, search, isActiveFilter" />

</div>
