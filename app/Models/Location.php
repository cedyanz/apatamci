<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $primaryKey = 'location_id';

    protected $fillable = [
        'city', 
        'state', 
        'country', 
        'latitude', 
        'longitude',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'location_id');
    }
}
