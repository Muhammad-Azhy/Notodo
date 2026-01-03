<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'path',
        'type',
        'problem_id',
    ];

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }
}
