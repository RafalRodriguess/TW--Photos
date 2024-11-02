<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagensSelecionadas extends Model
{
    use HasFactory;

    protected $fillable = ['trabalho_id', 'trabalho_imagem_id'];

    public function trabalho()
    {
        return $this->belongsTo(Trabalho::class);
    }

    public function imagem()
    {
        return $this->belongsTo(TrabalhoImagem::class, 'trabalho_imagem_id');
    }
}
