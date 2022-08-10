<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'hex',
        'rgb',
        'active'
    ];



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active'=>'boolean'
    ];


    #scope com usuarios ativos
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    # Relacionamento com N para N com Users
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
