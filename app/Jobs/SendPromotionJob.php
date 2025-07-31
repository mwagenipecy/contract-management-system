<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Promotion;

class SendPromotionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $promotion;

    public function __construct(Promotion $promotion)
    {
        $this->promotion = $promotion;
    }

    public function handle(): void
    {
        $this->promotion->send();
    }

    public function failed(\Throwable $exception): void
    {
        // Handle failed job
        \Log::error("Failed to send promotion {$this->promotion->id}: {$exception->getMessage()}");
        
        $this->promotion->update([
            'status' => 'failed',
            'failure_reason' => $exception->getMessage(),
        ]);
    }
}