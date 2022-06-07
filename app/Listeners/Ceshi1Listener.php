<?php

namespace App\Listeners;

use App\Events\Ceshi;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Ceshi1Listener implements ShouldQueue
{
    public $driver;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->driver = 'Mysql';
    }

    /**
     * Handle the event.
     *
     * @param  Ceshi  $event
     * @return void
     */
    public function handle(Ceshi $event)
    {
        //
        dump($event->data,$this->driver);
    }
}
