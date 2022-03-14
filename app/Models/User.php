<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'name',
        'email',
        'deleted_at',
    ];

    public $timestamps = true;

    /**
     * @return HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(WorkEntry::class);
    }

}
