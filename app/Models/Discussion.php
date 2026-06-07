<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Discussion extends Model
{
    use HasUuid;

    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = [
        'id','course_id','user_id','title','body','is_pinned','replies_count',
    ];

    protected $casts = ['is_pinned' => 'boolean'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(DiscussionReply::class)->with('user')->latest();
    }
}

