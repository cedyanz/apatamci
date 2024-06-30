<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $primaryKey = 'property_id';

    protected $fillable = [
        'name', 
        'description', 
        'location_id', 
        'type', 'price_per_night', 
        'amenities', 'owner_id',
    ];


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'property_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'property_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'property_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
