<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
 
class Announcement extends Model
{
    use HasUuid;
 
    protected $keyType    = 'string';
    public    $incrementing = false;
 
    protected $fillable = [
        'id','title','body','audience','sent_by','sent_at',
    ];
 
    protected $casts = ['sent_at' => 'datetime'];
 
    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}