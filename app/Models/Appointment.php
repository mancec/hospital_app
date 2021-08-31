<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'reason_for_visit',
        'timestamp',
        'doctor_id',
        'patient_id',
        'time_slot_id'
    ];

    public function timeSlots()
    {
        return $this->belongsTo(TimeSlot::class, 'time_slot_id', 'id');
    }

    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

}
