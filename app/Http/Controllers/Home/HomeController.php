<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site;
use Auth;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function home()
    {
        if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3)
            $sites=Site::all();
        elseif(Auth::user()->accesslevel==4)
        {
            $sites=Site::where('supervisor','=',Auth::user()->id)->get();
        }
        elseif(Auth::user()->accesslevel==5)
            $sites=Site::where('site_owner','=',Auth::user()->id)->get();

        return view('site.sites')->with('sites',$sites);
    }
}
