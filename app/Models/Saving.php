<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $fillable = [
        'name',
        'save_amount',
        'save_date',
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
