<?php

namespace App\Models;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function registrant()
    {
        return $this->belongsTo(Registration::class, 'registrant_id', 'id');
    }
}
