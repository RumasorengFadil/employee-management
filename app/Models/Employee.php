<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nik',
        'full_name',
        'email',
        'gender',
        'position',
        'division',
        'joined_at',
        'telp_number',
        'birth_day',
        'address',
        'status',
        'salary',
    ];


}
