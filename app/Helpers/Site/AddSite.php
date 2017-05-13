<?php

namespace App\Helpers\Site;
use App\Models\Site;
use App\Models\State;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait AddSite
{
    protected function showAddSite()
    {
        $state=State::get(['id','name']);
        $sup=User::where('accesslevel','=','4')->get(['id','fullname']);
        $owner=User::where('accesslevel','=','5')->get(['id','fullname']);
        $sites=null;
        if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3)
            $sites=Site::all();

        return view('site.add')->with('states',$state)
            ->with('sites',$sites)->with('sup',$sup)->with('sit_owner',$owner);
    }
    public function AddSite(Request $request)
    {
        $input=$request->all();
         $validator=$this->validator($request->all());
        if($validator->fails()){
            return redirect('addsite')
                ->withErrors($validator)
                ->withInput()
                ->with("state",$input['state'])
                ->with("sup",$input['sup'])
                ->with("owner",$input['owner'])
                ->with("view","add");
         }
        else
        {
            $this->create($request->all());
            $msg="Site has been successfully created!";
            return redirect($this->redirectPath())->with("msg", $msg);
        }
    }
    public function updateSite(Request $request)
    {
        $input=$request->all();
        $validator=$this->validator($request->all());
        if($validator->fails()){
            return redirect('addsite')
                ->withErrors($validator)
                ->withInput()
                ->with("state",$input['state'])
                ->with("sup",$input['sup'])
                ->with("owner",$input['owner'])
                ->with("view","update");
        }
        else
        {
            $this->update($request->all());
            $msg="Site has been successfully updated!";
            return redirect($this->redirectPath())->with("msg", $msg);
        }
    }
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }
    public function AddRoom(Request $request)
    {
        $input = $request->all();
        $rules = [
            'identifierFD' => 'required|unique:room',
            'roomType' => 'required',
        ];
        $messages = [
            'identifierFD.required' => 'Room ID Required',
            'identifierFD.unique' => 'Room ID Already Existed',
            'roomType.required' => 'Room Type Required',
        ];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return redirect('addsite')
                ->withErrors($validator)
                ->withInput()
                ->with('room','room')
                ->with('view','addroom');
        } else {
            $room = new Room();
            $room->site = $input['siteid'];
            $room->identifierFD = $input['identifierFD'];
            $room->type = $input['roomType'];
            if($room->save())
            {
                $msg="Site Room has been successfully created!";
                return redirect($this->redirectPath())->with("msg", $msg);
            }
        }
    }
    public function getSiteInfo(Request $request)
    {
        $input = $request->all();
        $siteid=$input["siteid"];
        $sites=null;
        $site=null;
        if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3)
            $site=Site::find($siteid);

        return $site;
    }
    public function checkRoomID($roomID)
    {
        return Room::where('identifierFD','=',$roomID)->count();
    }
}
