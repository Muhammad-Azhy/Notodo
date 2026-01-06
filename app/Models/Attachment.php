<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
    'path',
    'type',
    'reference_id', 
];

public function reference()
{
    return $this->belongsTo(Reference::class);
}
}
