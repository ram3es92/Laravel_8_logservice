<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NewsHiddenListener
{
    /**
     * Create the event listener.
     */
    public function __construct($event)
    {
        Log::info('News' . $event->news->id . 'hidden');
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Log::info('News' . $event->news->id . 'hidden');
    }
}
