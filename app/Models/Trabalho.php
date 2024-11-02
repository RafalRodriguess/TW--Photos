<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabalho extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'nome', 'descricao', 'token'];


    // Relacionamento com o cliente
    public function cliente()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Relacionamento com as imagens do trabalho
    public function imagens()
    {
        return $this->hasMany(TrabalhoImagem::class, 'trabalho_id'); // Corrigido para TrabalhoImagem
    }
}
