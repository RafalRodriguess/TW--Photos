<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'type',
        'description',
        'amount',
        'proof'
    ];

    // Relacionamento com o cliente
    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }
}