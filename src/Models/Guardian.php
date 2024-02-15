<?php

namespace RehanKanak\Guardian\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'resource_uuid',
        'is_valid',
        'type',
        'options',
        'right_option',
        'response',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_valid' => 'boolean',
        'options' => 'array',
    ];
}
