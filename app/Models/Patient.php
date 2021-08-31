<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'personal_code',
        'date_of_birth',
    ];

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function prescriptionsById($id)
    {
        return $this->hasMany(Prescription::class)->where('id',$id);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
