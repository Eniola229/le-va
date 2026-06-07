<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
 
class LessonCompletion extends Model
{
    use HasUuid;
 
    protected $keyType    = 'string';
    public    $incrementing = false;
 
    protected $fillable = ['id','user_id','lesson_id'];
 
    public function user()   { return $this->belongsTo(User::class); }
    public function lesson() { return $this->belongsTo(Lesson::class); }
}