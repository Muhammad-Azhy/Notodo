<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'completed',
        'problem_id',
        'user_id',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }
}
