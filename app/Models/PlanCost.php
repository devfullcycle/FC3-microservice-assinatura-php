<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanCost extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'price',
        'recurrence_period',
    ];
}
