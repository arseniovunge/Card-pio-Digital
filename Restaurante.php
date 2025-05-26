<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'endereco', 'telefone', 'email'];

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function mesas()
    {
        return $this->hasMany(Mesa::class);
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
