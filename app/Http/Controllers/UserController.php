<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;

use Auth;

use App\Models\News;

class UserController extends Controller
{
   
    /* show use dashboard with list of their news
     * @return view
     */
    public function showDashboard() {
        
        //get all my news 
        $myNews    =   News::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);

        return View("layouts.dashboard", compact('myNews'));
    }
    
    
}
