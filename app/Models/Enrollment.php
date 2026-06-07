<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
 
class Enrollment extends Model
{
    use HasUuid;
 
    protected $keyType    = 'string';
    public    $incrementing = false;
 
    protected $fillable = [
        'id','user_id','course_id','progress','enrolled_at',
    ];
 
    protected $casts = ['enrolled_at' => 'datetime'];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}