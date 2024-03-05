<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'user_id',
        'employee_group_id',
        'name',
        'date_of_birth',
        'place_of_birth',
        'address',
        'qr_code_path',
        'shift_id',
        'status'
    ];

    public static $code_prefix = "EMP";

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->code = self::getNextCode();
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public static function getNextCode()
    {
        $last_number = self::withTrashed()->max('code');
        $next_number = empty($last_number) ? 1 : ((int) explode('-', $last_number)[1] + 1);

        return self::makeCode($next_number);
    }

    public static function makeCode($next_number)
    {
        return (string) self::$code_prefix . '-' . str_pad($next_number, 5, 0, STR_PAD_LEFT);
    }

    public function employeeGroup(){
        return $this->belongsTo(EmployeeGroup::class, 'employee_group_id');
    }

    public function absens(){
        return $this->hasMany(Absen::class, 'employee_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shift(){
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function cuti(){
        return $this->hasMany(Cuti::class, 'employee_id', 'id');
    }
}
