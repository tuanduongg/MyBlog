<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function getFormatCreatedAtAttribute()
    {
        // return $this->attributes['admin'] === 'yes';
        return date_format($this->created_at, "d/m/Y");
    }
    public function getFormatFullHouseCreatedAtAttribute()
    {
        // return $this->attributes['admin'] === 'yes';
        return date_format($this->created_at, "H:i d/m/Y");
    }
    // "Amsterdam,Washington,Sydney,Beijing,Cairo"
    public function getFormatTagsAttribute()
    {
        // $str = "Amsterdam,Washington,Sydney,Beijing,Cairo";
        return explode(',', $this->tags);
    }
    public function getFormatTittleAttribute()
    {
        
        $str = wordwrap($this->tittle, 30);
        $str = explode("\n", $str);
        $str = $str[0] . '...';
        return $str;
    }
}
