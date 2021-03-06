<?php

namespace App;

use Laravel\Scout\Searchable;
use \Conner\Likeable\LikeableTrait;
use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use LikeableTrait;
    use Searchable;
    use Rateable;

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

    public function scopeOfMap($query, $map)
    {
      return $query->where('map', $map);
    }

    public function scopeRented($query, $rented)
    {
      return $query->where('rented', $rented);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

}
