<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Student extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        // 'name',
        'full_name',
        'contact',
        'region',
        'section',
        'status',
        'course_id',

    ];

    // protected $softDelete = true;

    public function courses()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
}
