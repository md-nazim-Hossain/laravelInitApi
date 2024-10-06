<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    public $table = 'post';
    public $keyType = 'string';

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'content',
        'user_id'
    ];




    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
            $model->post_id = $model->max('post_id') + 1;
        });
    }

    protected $hidden = [

    ];

    protected $casts = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'name','email']);
    }

}
