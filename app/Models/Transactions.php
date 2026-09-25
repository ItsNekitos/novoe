<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'amount',
    ];
    public function blances()
    {
        return $this->hasOne(Balance::class);
    }
    public function categories()
    {
        return $this->hasOne(Category::class);
    }
}
