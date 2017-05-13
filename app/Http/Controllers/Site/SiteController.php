<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Auth;
class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function sites()
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
    protected function genrateInvoice(Request $request)
    {
        if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3) {
            if (isset($_GET['siteid'])) {
                $site = site::find($_GET['siteid']);
                return view("site.invoice")
                    ->with('site', $site);
            }
        }
        return redirect("/");
    }
}
