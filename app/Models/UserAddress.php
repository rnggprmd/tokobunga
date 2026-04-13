<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'label', 'recipient_name', 'phone_number', 'complete_address', 'is_default'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
