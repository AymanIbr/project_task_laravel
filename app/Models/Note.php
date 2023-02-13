<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','info','done'
    ];
    // protected $fillable = ['*'];
    // protected $guarded = [];

    public function getDoneStatusAttribute()
    {
        return $this->done ? 'Done' : 'Waiting';
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class , 'sub_category_id','id');
    }
}
