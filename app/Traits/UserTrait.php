<?php
namespace App\Traits;

use App\Models\User;
use App\Models\UserEmailVerify;

trait UserTrait {


   /**
	*
	* to test password strength
	*
	* @param string $password
	*
	* @return int
	*
	*/
   public static function checkPasswordStrenth($password)
   {
	   $length = strlen($password);
	   if ( $length == 0 ) {
		   return 0;
	   }
	   $strength = 0;
   
	   /*** 1. check if password is not all lower case ***/
	   if(strtolower($password) != $password) {
		   $strength += 20;
	   } else {
		   return 0;
	   }
   
	   /*** 2.check if password is not all upper case ***/
	   if(strtoupper($password) != $password){
		   $strength += 20;
	   } else {
		   return 0;
	   }
   
	   /*** 3.check string length is 8 -25 chars ***/
	   if($length >= 8 && $length <= 25){
		   $strength += 20;
	   }
   
	   /*** 4.get the numbers in the password ***/
	   preg_match_all('/[0-9]/', $password, $numbers);
	   if(count($numbers[0])) {
		   $strength += 20;
	   } else {
		   return 0;
	   }
   
	   /*** 5.check for special chars ***/
	   preg_match_all('/[ "\'<>`{}\[\]()|!@#$%&*\/=?,;.:\-_+~^\\\]/', $password, $specialchars);
	   if(sizeof($specialchars[0])) {
		   $strength += 20;
	   } else {
		   return 0;
	   }
   
	   return $strength;
   }
   
   /* get user verify object by verification link
    * @param string $verificationCode
    * @return object collection
    */
   public function getEmailVerifyByCode($verificationCode) {
        return UserEmailVerify::where('verification_code', $verificationCode)->first();
   }
}