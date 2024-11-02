<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'contributor'
    ];

    // Relacionamento com as transações de entrada
    public function entries()
    {
        return $this->hasMany(Transaction::class, 'cliente_id')->where('type', 'entrada');
    }
}
