<?php

use Livewire\Component;
use App\Models\ReagentLog;
use App\Models\StockReagent;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification;
    public $show = false;
    public $amountId;
    public $amount;

    protected $listeners = ['edit' => 'loadAmount'];
    public function loadAmount($id)
    {
        $this->show = true;
        $this->amountId = $id;
        $logs = ReagentLog::findOrFail($id);

        $this->amount = $logs->amount;
    }

    public function cancel()
    {
        $this->show = false;
    }

    public function update()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $log = ReagentLog::with('reagent')->findOrFail($this->amountId);
        $reagent = $log->reagent;

        $oldAmount = $log->amount;
        $newAmount = $this->amount;
        $diff = $newAmount - $oldAmount;

        // --- LOGIC PENCEGAHAN MINUS ---
        // Hitung simulasi: stok saat ini ditambah/dikurang selisih perubahan
        $simulasiStokBaru = 0;

        if ($log->type === 'incoming') {
            // Jika stok masuk diedit (dikurangi), cek apakah sisa stok cukup
            $simulasiStokBaru = $reagent->current_stock + $diff;
        } else {
            // Jika pemakaian diedit (ditambah), cek apakah stok tersedia cukup
            $simulasiStokBaru = $reagent->current_stock - $diff;
        }

        if ($simulasiStokBaru < 0) {
            $this->addError('amount', 'Perubahan ditolak! Stok akan menjadi minus (' . $simulasiStokBaru . ' ml). Silakan cek kembali pemakaian.');
            return;
        }
        // ------------------------------

        // Jika lolos simulasi, baru update database
        $log->update(['amount' => $newAmount]);

        if ($log->type === 'incoming') {
            $reagent->increment('total_incoming', $diff);
        } else {
            $reagent->increment('total_usage', $diff);
        }

        $reagent->refresh();
        $reagent->current_stock = $reagent->initial_stock + $reagent->total_incoming - $reagent->total_usage;
        $reagent->save();

        // 1. Siapkan data untuk notifikasi
        $reagentName = $reagent->name;
        $logType = $log->type; // 'incoming' atau 'usage'
        $formattedOld = number_format($oldAmount);
        $formattedNew = number_format($newAmount);

        // 2. Kirim Notifikasi
        $this->sendNotification(
            action: 'EDIT', 
            target: 'Log Reagent: ' . $reagentName,
            details: "Updated {$logType} amount from {$formattedOld}ml to {$formattedNew}ml for reagent '{$reagentName}'"
        );

        $this->dispatch('alert-success', message: 'Data berhasil diperbarui.');
        $this->dispatch('data-added');
        $this->show = false;
    }
};
?>

<div>
    <x-loading wire:target='loadAmount, cancel, save, update' />
    <x-modal :show="$show">

        <form wire:submit.prevent="update">
            <x-form-input wire:model="amount" label="Amount" forId='amount' />
            <div class="flex justify-end gap-2">
                <button type="button" wire:click="cancel"
                    class="px-4 py-2 text-sm bg-gray-200 rounded-sm hover:bg-gray-300 cursor-pointer">Cancel</button>

                <x-button type="submit">Update</x-button>
            </div>

        </form>
    </x-modal>
</div>
