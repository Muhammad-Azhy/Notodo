<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'type',
        'content',
        'problem_id',
    ];

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }
}
