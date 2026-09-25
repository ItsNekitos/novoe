<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    protected $fillable = [
        'max_summ',
        'rashod_limit_date',
    ];
    public function categories()
    {
        return $this->hasOne(Category::class);
    }
    public function blances()
    {
        return $this->belongsTo(Balance::class);
    }
}
