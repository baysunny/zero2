<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'phone2',
        'province',
        'city',
        'detailAddress',
        'coordinate',
        'service_id'
    ];
}
