<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'balance',
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
