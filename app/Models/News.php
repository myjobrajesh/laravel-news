<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

    protected $table = 'news';

    public $timestamps = false;
 
    protected $dates = ['created_at'];
 
    /* mutuator, get first letter uppercase
     *  @param string $name 
     *  @return stting
    */
    public function getTitleAttribute($title) {
        return ucfirst($title);
    }
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
