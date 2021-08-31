<?php

namespace App\Jobs;

use App\Models\Prescription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPrescription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Prescription
     */
    private $prescription;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Prescription $prescription)
    {
        $this->prescription = $prescription;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $prescription = Prescription::findOrFail($this->prescription->id);
        if ($prescription)
        {
            dd($prescription->update([
                'status' => config('enums.prescription_status.CONFIRMED')
            ]));
        }
    }
}
