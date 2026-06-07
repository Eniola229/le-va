<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
 
class Lesson extends Model
{
    use HasUuid;
 
    protected $keyType    = 'string';
    public    $incrementing = false;
 
    protected $fillable = [
        'id','course_id','title','description',
        'video_url','video_public_id',
        'duration_minutes','order','is_preview',
    ];
 
    protected $casts = ['is_preview' => 'boolean'];
 
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
 
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
 
    public function completions()
    {
        return $this->hasMany(LessonCompletion::class);
    }
}