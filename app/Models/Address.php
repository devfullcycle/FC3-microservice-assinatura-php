<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['street', 'number', 'zip_code', 'city', 'state', 'country'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
