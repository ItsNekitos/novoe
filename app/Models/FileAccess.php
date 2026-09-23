<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_id',
        'user_id'
    ];
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
