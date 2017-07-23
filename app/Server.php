<?php

namespace App;

use Laravel\Scout\Searchable;
use \Conner\Likeable\LikeableTrait;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use LikeableTrait;
    use Searchable;

    protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
      'last_wipe'
    ];

    public function scopeOfPlatform($query, $platform)
    {
      return $query->where('platform', $platform);
    }

    public function comments()
    {
      return $this->hasMany(Comment::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

}
