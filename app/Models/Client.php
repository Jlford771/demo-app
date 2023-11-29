<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($client) {
            $client->agents()->delete(); 
        });
    }
}
