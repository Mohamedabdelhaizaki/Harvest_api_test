<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'harvest_posts';
    protected $guarded = ['id'];

    function getCreatedAtAttribute($value)
    {
        return date('d-m-Y g:iA', strtotime($value));
    }

    function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y g:iA', strtotime($value));
    }

    ####### Relations #######
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
