<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'status',
        'doctor_id',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function doctors()
    {
        return $this->users()->whereHas("roles", function($q){ $q->where("name", "doctor"); })->get();
    }

}
