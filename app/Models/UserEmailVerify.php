<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEmailVerify extends Model {

    protected $table = 'user_email_verify';

    public $timestamps = false;
 
    protected $primaryKey = 'user_id';
    
    /* save data
     * @param array $data
     * @return $obj;
     */
    public static function saveData ($data) {
        $data ['created_at'] = date("Y-m-d H:i:s");
        static::insert($data);
    }
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
