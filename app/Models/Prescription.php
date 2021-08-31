<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'patient_id',
        'description',
        'use_case',
        'notes',
        'date',
        'status'
    ];

    protected $with = ['drugs'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function drugs()
    {
        return $this->belongsToMany(Drug::class, 'prescription_drug')->withPivot('amount')->withTimestamps();
    }

    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id' , 'id');
    }
}
