<?php

namespace App\Models;

use App\Models\User;
use App\Models\Presence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class, 'registrant_id', 'id');
    }
}
