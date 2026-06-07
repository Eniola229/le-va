<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class DiscussionReply extends Model
{
    use HasUuid;

    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = [
        'id','discussion_id','user_id','body','is_tutor_reply',
    ];

    protected $casts = ['is_tutor_reply' => 'boolean'];

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}