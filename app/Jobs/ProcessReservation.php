<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Models\TimeSlot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessReservation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TimeSlot
     */
    private $timeSlot;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TimeSlot $timeSlot)
    {
        $this->timeSlot = $timeSlot;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $timeSlot = TimeSlot::findOrFail($this->timeSlot->id);
        if ($timeSlot->status == config('enums.time_slot_status.PENDING'))
        {
            $rez = $timeSlot->delete();
        }
    }
}
