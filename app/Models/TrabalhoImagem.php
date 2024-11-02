<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabalhoImagem extends Model
{
    use HasFactory;

    protected $fillable = ['trabalho_id', 'imagem'];

    // Defina o nome da tabela, caso não esteja padrão
    protected $table = 'trabalho_imagens'; // Certifique-se de que este nome está correto
}