<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Reference;
use App\Models\Task;

class Problem extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function references() {
        return $this->hasMany(Reference::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
?>