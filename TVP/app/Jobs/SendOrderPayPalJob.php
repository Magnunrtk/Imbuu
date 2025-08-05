<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\SendOrderPayPal;
use App\Models\WebOrderHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendOrderPayPalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected array $details;
    public function __construct(
        private readonly WebOrderHistory $webOrderHistory
    ) {
    }

    public function handle(): void
    {
        $details = [
            'to' => $this->webOrderHistory->account->email,
            'order_item_id' => Carbon::parse($this->webOrderHistory->created_at)->format('Y-m') . '-P-' . $this->webOrderHistory->id,
            'service' => $this->webOrderHistory->coins . ' ' .config('server.serverName') . ' Coins',
            'price' => $this->webOrderHistory->price,
            'created_at' => $this->webOrderHistory->created_at,
        ];
        $email = new SendOrderPayPal($details);
        Mail::to($details['to'])->send($email);
    }
}