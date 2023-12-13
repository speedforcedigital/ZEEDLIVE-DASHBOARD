<?php

namespace App\Http\Livewire;

use App\Models\RefundRequest;
use App\Models\Wallet;
use App\Traits\MailTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RefundRequests extends Component
{
    use MailTrait;

    public $search = '';
    public $reason = '';

    protected $rules = [
        'reason' => 'required',
    ];

    public function render()
    {
        $perPage = 10;

        $allRequests = RefundRequest::where('status', 'pending')->orderBy('id', 'desc');
        if (!empty($this->search)) {
            $allReports = $allRequests->where(function ($q) {
                $q->where('account_holder_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
            });
        }

        $requests = $allRequests->paginate($perPage);
        return view('livewire.refund-requests', compact('requests'));
    }

    public function accept($id)
    {
        $refundRequest = RefundRequest::find($id);
        $refundRequest->admin_status = 'Accepted';
        $refundRequest->save();

        $wallet = Wallet::where('user_id', $refundRequest->user_id)->first();
        //update wallet
        $wallet->balance = $wallet->balance - $refundRequest->amount;
        $wallet->save();

        $payLoad =
            [
                "name" => "Refund",
                "user_id" => $refundRequest->user_id,
                "amount" => $refundRequest->amount,
                "type" => "deduction",
                "wallet_id" => $wallet->id,
            ];
        $this->storeTransaction($payLoad);


        $buyerParams = array(
            'to' => $refundRequest->user->email,
            'from' => env("MAIL_FROM_ADDRESS"),
            'fromname' => "Zeedlive",
            'subject' => "Refund Request Accepted",
            'text' => "Your refund request has been accepted. You will receive your refund within 7 working days.",
        );

        $this->sendMail($buyerParams);

        $refundRequest->save();

        $message = "Refund request accepted successfully";
        session()->flash('message', $message);
        $this->emit('alert_remove');

    }

    public function reject($id)
    {
        $this->validate();
        $refundRequest = RefundRequest::find($id);
        $refundRequest->admin_status = 'Rejected';

        $buyerParams = array(
            'to' => $refundRequest->user->email,
            'from' => env("MAIL_FROM_ADDRESS"),
            'fromname' => "Zeedlive",
            'subject' => "Refund Request Rejected",
            'text' => "Your refund request has been rejected due to the following reason: " . $this->reason,
        );

        $this->sendMail($buyerParams);

        $refundRequest->save();

        $message = "Refund request Rejected successfully";
        session()->flash('message', $message);
        $this->emit('alert_remove');

    }

    public function storeTransaction($data)
    {
        $created_at = Carbon::now()->setTimezone('Asia/Kuwait');
        $updated_at = Carbon::now()->setTimezone('Asia/Kuwait');
        $data['created_at'] = $created_at;
        $data['updated_at'] = $updated_at;
        $transaction = DB::table('wallet_transactions')->insert($data);
    }
}
