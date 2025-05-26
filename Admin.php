<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'senha', 'restaurante_id'];

    protected $hidden = ['senha'];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}
// This model represents an Admin in the system, which is associated with a Restaurante.