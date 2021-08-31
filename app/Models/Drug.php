<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    public function prescription()
    {
        return $this->belongsToMany(Prescription::class, 'prescription_drug');
    }
}
