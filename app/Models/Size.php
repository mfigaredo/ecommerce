<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'products_id'];

    // Relación uno a muchos inversa
    public function product() {
        return $this->belongsTo(Product::class);
    }

    // Relación muchos a muchos
    public function colors() {
        return $this->belongsToMany(Color::class)->withPivot('quantity', 'id');
    }


}
