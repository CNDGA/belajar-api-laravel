<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    protected $fillable = [
        'employee_id',
        'office_id',
        'lat_from_employee',
        'long_from_employee',
        'lat_from_office',
        'long_from_office',
        'attedance_in',
        'attedance_out',
        'status',
        'description',
    ];

    protected $appends = ['status_label'];

    public function getStatuslabelAttribute()
    {
        switch ($this->gender) {
            case '1':
                $label = "Attendance In And Out";
                break;

            case '0':
                $label = "Attendance In";
                break;

            default:
                $label = "Absent";
                break;
        }
        return $label;
    }



    //INI RELASI MENGAMBIL fillabel id dari EMPLOYEES untuk Attendance employee_id
    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id', 'id');
    }

    public function office()
    {
        return $this->belongsTo(Offices::class, 'office_id', 'id');
    }
}
