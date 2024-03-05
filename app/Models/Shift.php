<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function employee(){
        $this->hasMany(Employee::class, 'shift_id', 'id');
    }

    public function absen(){
        $this->hasMany(Absen::class, 'shift_id', 'id');
    }
}
