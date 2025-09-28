<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    function dashboard () {
        return view('dashborad');
     }

     function stock() {
        return view('page.stock');
     }

     function reports(){
        return view('page.report');
     }
     

     function categories(){
        return view('page.categories');
     }
     function users () {   
            return view('page.user');
     }
     function settings() {
            return view('page.settings');
     }

}
