<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    // Define a tabela associada ao modelo
    protected $table = 'agendamentos'; 
    // Define os campos que podem ser preenchidos
    protected $fillable = [
        'client_id',
        'data',
        'observacao',
    ];

    // Defina a relação com o modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class); // Assume que um agendamento pertence a um cliente
    }
}
