<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relación muchos a muchos
    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function getNombreAttribute()
    {
        return ucfirst(__($this->name));
    }

    public function sizes() {
        return $this->belongsToMany(Size::class);
    }
}
