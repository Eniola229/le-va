<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
 
class Resource extends Model
{
    use HasUuid;
 
    protected $keyType    = 'string';
    public    $incrementing = false;
 
    protected $fillable = [
        'id','lesson_id','course_id',
        'title','file_url','file_public_id','file_type','file_size',
    ];
 
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
 
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}