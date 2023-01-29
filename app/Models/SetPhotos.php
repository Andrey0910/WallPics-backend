<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetPhotos extends Model
{
    use HasFactory;

    public function photos(){
        return $this->belongsTo(Photos::class);
    }
}
