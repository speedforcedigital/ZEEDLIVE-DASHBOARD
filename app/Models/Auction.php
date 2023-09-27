<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\MyCollection;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $table = 'auction';
    public $timestamps = true;
    protected $dates = ['end_time', 'start_time'];
    protected $fillable = [
        'start_time',
        'end_time',
        'buy_now',
        'buy_now_price',
        'auction_status',
        'type',
        'user_id',
        'collection_id',
        'auction_start_price',
        'counter_status',
    ];

    protected $appends = [
        'createdTimeAgo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function collection()
    {
        return $this->belongsTo(MyCollection::class, "collection_id");
    }

    public function lot()
    {
        return $this->hasOne(Lot::class, 'auction_id', 'id');
    }

    public function getCreatedTimeAgoAttribute()
    {
        if ($this->type === 'Auction') {
            $date = Carbon::parse($this->auction_status === 'Open' ? $this->start_time : $this->end_time);
            $elapsed = $date->diff(Carbon::now());
            $daysElapsed = $elapsed->format('%a');
            $monthsElapsed = $date->diffInMonths(Carbon::now());

            if ($this->auction_status === 'Open' || $this->auction_status === 'Closed' || $this->auction_status === 'New') {
                $timeLeft = $daysElapsed > '30' ? $monthsElapsed . ' month' : $daysElapsed . ' days';
                $status = match ($this->auction_status) {
                    'Open' => 'Bid Now: ',
                    'Closed' => 'Expired: ',
                    'New' => 'Pending: ',
                };
                return $status . $timeLeft . ($daysElapsed > '30' ? ' left' : ' ago');
            }

            if ($this->admin_status === 'Rejected') {
                $rejectedDate = $this->updated_at;
                $diff = abs(Carbon::now()->getTimestamp() - $rejectedDate->getTimestamp());
                $days = floor($diff / (60 * 60 * 24));
                $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
                $minutes = floor(($diff % (60 * 60)) / 60);
                return 'Rejected from: ' . $days . "d: " . $hours . "h: " . $minutes . "m";
            }
        }

        if ($this->type === 'Buy Now') {
            return $this->created_at->diffForHumans();
        }
    }
}
