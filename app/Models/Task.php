<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'titre', 'description', 'statut', 'priorite', 'echeance'
    ];

    protected $casts = [
        'echeance' => 'date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
