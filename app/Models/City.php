<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'created_at' => 'datetime:H:ia',
        'updated_at' => 'datetime:Y-m-d',
        'active' => 'boolean'
    ];




    protected $guarded = [];
    protected $appends = ['status'];
    //Append attribute
    // public function get_____Attribute(){}
    public function getStatusAttribute()
    {
        return $this->active ? 'Active' : 'Disabled';
    }

    public function users()
    {
        return $this->hasMany(User::class, 'city_id', 'id');
    }
}
