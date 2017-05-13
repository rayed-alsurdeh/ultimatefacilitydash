<?php

namespace App\Http\Controllers\AjaxHelper;

use App\Models\Site;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Accesslevel;

class AjaxHelper extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function delUser(Request $request)
    {
        $input =$request->all();
        $user=User::find($input['userid']);
        if($user->delete())
            return "y";
        return "n";

    }
    public function blockUser(Request $request)
    {
        $input =$request->all();
        $user=User::find($input['userid']);
        $user->status=0;
        if($user->update())
            return "y";
        return "n";

    }
    public function unBlockUser(Request $request)
    {
        $input =$request->all();
        $user=User::find($input['userid']);
        $user->status=1;
        if($user->update())
            return "y";
        return "n";
    }

    public function getUserInfo(Request $request)
    {
        $input =$request->all();
        return User::find($input['userid']);
    }
    public function getAllUsers(Request $request)
    {
        $input =$request->all();
        $users=array();
        $allusers=User::get();
        foreach ($allusers as $user)
        {
            array_push($users,[$user,$user->role]);
        }
        return json_encode($users);
    }
    public function getAllSites(Request $request)
    {
        $input =$request->all();
        $sites=array();
        $allsites=Site::get();
        foreach ($allsites as $site)
        {
            array_push($sites,[$site,$site->site_sup]);
        }
        return json_encode($sites);
    }
   public function getRooms(Request $request)
   {
       $input =$request->all();
       $rooms=Room::where([['site','=',$input['siteid']],['identifierFD','LIKE',"".$input['roompre']."%"]])->get();
       return $rooms;
   }

}
