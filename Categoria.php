<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'restaurante_id'];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
