<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// IMPORT MODELS
use App\Models\Reference;

class Attachment extends Model
{
    use HasFactory;

    public function reference() {
        return $this->belongsTo(Reference::class);
    }
}
?>