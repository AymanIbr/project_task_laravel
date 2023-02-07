<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['status'];
    //Append attribute
    // public function get_____Attribute(){}
    public function getStatusAttribute()
    {
        return $this->active ? 'Active' : 'Disabled';
    }
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function notes()
    {
        // category_id foreign_id in the Sub table
        // sub_category_id foregin_id in the note table
        return $this->hasManyThrough(Note::class, SubCategory::class, 'category_id', 'sub_category_id');
    }
}
