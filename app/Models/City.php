<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['status'];
    //Append attribute
    // public function get_____Attribute(){}
    public function getStatusAttribute(){
        return $this->active ? 'Active':'Disabled';
    }
}
