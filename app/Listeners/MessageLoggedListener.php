<?php

namespace App\Listeners;

use Illuminate\Log\Events\MessageLogged;
use Symfony\Component\Console\Output\ConsoleOutput;

class MessageLoggedListener
{
    /**
     * Create the event listener.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param MessageLogged $event
     *
     * @return void
     */
    public function handle(MessageLogged $event)
    {
        if (app()->runningInConsole()) {
            $output = new ConsoleOutput();
            $output->writeln("<{$event->level}>{$event->message}</{$event->level}>");
        }
    }
}
