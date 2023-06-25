<?php

namespace App\Models\Entity;

use App\Models\SerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LifeEvent extends Model
{
    use HasFactory, SerializeDate;

    // guarded attributes
    protected $guarded = [
        'id',
    ];
}
