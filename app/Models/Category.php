<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function getFormatFullHouseCreatedAtAttribute()
    {
        // return $this->attributes['admin'] === 'yes';
        return date_format($this->created_at, "H:i d/m/Y");
    }
}
