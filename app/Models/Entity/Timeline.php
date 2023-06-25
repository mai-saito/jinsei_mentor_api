<?php

namespace App\Models\Entity;

use App\Models\SerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory, SerializeDate;

    // guarded attributes
    protected $guarded = ['id'];

    public function lifeEvents()
    {
        return $this->hasMany(LifeEvent::class);
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
