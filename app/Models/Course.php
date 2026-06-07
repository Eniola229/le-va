<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
 
class Course extends Model
{
    use HasUuid;
 
    protected $keyType    = 'string';
    public    $incrementing = false;
 
    protected $fillable = [
        'id','title','slug','description','what_you_will_learn',
        'cover_image','duration','lesson_count','status','order','created_by',
    ];
 
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
 
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
 
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
 
    // Scope: published only
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}