<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'term_date',
        'description',
        'purpose',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
