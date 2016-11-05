<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /* mutuator, get first letter uppercase
     *  @param string $name 
     *  @return stting
    */
    public function getNameAttribute($name) {
        return ucfirst($name);
    }
    
    public function userEmailVerify() {
        return $this->hasOne('App\Models\UserEmailVerify', 'user_id', 'id');
    }
    
    
    /* update last login field
     * @param object $obj
     * @return object
     */
    public static function updateLastLogin($obj) {
        $obj->last_login = date("Y-m-d H:i:s");
        $obj->save();
        return $obj;
    }
    
    
    
}
