<?php

namespace App\Models\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    // guarded attributes
    protected $guarded = ['id'];

    public function lifeEvents()
    {
        return $this->hasMany(LifeEvent::class);
    }
}
