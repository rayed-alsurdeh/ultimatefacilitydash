<?php
/**
 * Created by PhpStorm.
 * User: 90930034
 * Date: 6/04/2017
 * Time: 7:41 AM
 */
namespace App\Helpers\Job;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
trait AddJob
{
    public $srec;
    public function validateService($srec,$siteid)
    {

        $this->srec=$srec;
        if($srec->gtype === '1' || $srec->gtype ==='true')
            $srec->gtype= true;
        else
            $srec->gtype= false;

         if(($srec->gtype==true)) {
            $st = Room::where([['identifierFD', '=', strtoupper($this->srec->rmst)], ['site', '=', $siteid]])->first();
            $end = Room::where([['identifierFD', '=', strtoupper($this->srec->rend)], ['site', '=', $siteid]])->first();
            if ($st==null || $end==null) {
                return 0;
            }
        }else {
            if (($srec->gtype == false)) {
                $room = Room::where([['identifierFD', '=', strtoupper($this->srec->room)], ['site', '=', $siteid]])->first();
                if ($room == null)
                    return 0;
            }
        }
        return 1;

    }
    public function getDaysDiffernce($vacdate)
    {
        $now = Carbon::now();
        $today = Carbon::create($now->year, $now->month, $now->day, 0, 0, 0, null);
        $vacdate=new Carbon(Carbon::parse($vacdate)->format('Y-m-d'));
        $vacdate->hour=0;
        $vacdate->minute=0;
        $vacdate->second=0;
        $days=$vacdate->diffInDays();
        if($vacdate < $today )
            $days=$days*-1;
        return $days;
    }
    public function isRoom($roomid,$site)
    {
        if ($roomid == 1)
            $room = Room::where([['identifierFD', '=', strtoupper($this->srec->room)], ['site', '=', $site]])->get();

        if ($roomid == 2)
            $room = Room::where([['identifierFD', '=', strtoupper($this->srec->rmst)], ['site', '=', $site]])->get();

        if ($roomid == 3)
            $room = Room::where([['identifierFD', '=', strtoupper($this->srec->rend)], ['site', '=', $site]])->get();

        if (count($room) > 0)
            return $room[0]->id;
        else {
            return -1;
        }

    }
    public function getRoomID($roomid,$site)
    {
        $room = Room::where([['identifierFD', '=', strtoupper($roomid)], ['site', '=', $site]])->first();
        if($room!=null)
            return $room->id;
        return 0;

    }
    public static function getRoomUID($roomid)
    {
        $room = Room::find($roomid)>first();
        dd($room);
        if($room!=null)
            return $room->identifierFD;
        return 0;

    }
}