<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WorkEntry extends Model
{
    protected $table = 'workentry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'deleted_at',
        'start_date',
        'end_date',
    ];

    public $timestamps = true;

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
