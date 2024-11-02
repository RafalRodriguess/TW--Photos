<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'amount',
        'description',
    ];

    // Relacionamento inverso com o modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
