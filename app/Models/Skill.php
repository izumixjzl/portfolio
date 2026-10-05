<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public const CATEGORIES = [
        'Backend' => 'Backend',
        'Frontend' => 'Frontend',
        'Desktop' => 'Desktop',
        'Database' => 'Database',
        'Tools' => 'Tools & DevOps',
    ];

    protected $fillable = ['name', 'category', 'sort_order'];
}
