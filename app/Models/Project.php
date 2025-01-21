<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'created_by'];

    // Definisikan relasi dengan Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
