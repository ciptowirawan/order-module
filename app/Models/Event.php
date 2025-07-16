<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRegistrationStartAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getRegistrationEndAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function setEventNameAttribute($value)
    {
        $this->attributes['event_name'] = strtoupper($value);
    }

    public function getEventStartAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getEventEndAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
