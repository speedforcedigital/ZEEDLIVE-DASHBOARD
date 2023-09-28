<?php

namespace App\Http\Livewire;

use App\Models\Wallet;
use Livewire\Component;

class Wallets extends Component
{
    public $wallet;
    public $showModal = false;
    public $wallet_balance;

    public function render()
    {
        $wallets = Wallet::with('user')->paginate(10);
        $totalWallets = $wallets->total();
        return view('livewire.wallets', compact('totalWallets', 'wallets'));
    }

    public function balanceModal($id)
    {
        $this->wallet = Wallet::find($id);  // Assuming you have a Report model
        $this->showModal = true;
    }

    public function addBalance()
    {
        // Perform validation if needed
        $this->validate([
            'wallet_balance' => 'required|numeric|min:1',
        ]);
        $this->wallet->balance =  $this->wallet->balance  + $this->wallet_balance;
        $this->wallet->save();
        $message = 'Wallet Balance Added Sucessfully.';
        session()->flash('message', $message);
        $this->wallet_balance = "";
        return redirect()->route('wallet.index');
    }
}
