<?php

namespace App\Http\Controllers\Site;

use App\Models\Site;
use App\Models\Job;
use App\Models\Room;
use App\Models\Service;
use App\Models\JobService;
use App\Models\Jobfinish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Job\AddJob;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Job\Service_record;
use Carbon\Carbon;
use Auth;
use Session;

class JobController extends Controller
{
    public $services;
    public $siteid;
    public $roomerror;
    public $sites;
    use AddJob;
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function showJobs(Request $request)
   {
       if(isset($_GET['alljobs']))
       {
           $request->session()->remove("siteid");
           if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3)
               $sites=Site::all();
           elseif(Auth::user()->accesslevel==4)
           {
               $sites=Site::where('supervisor','=',Auth::user()->id)->get();
           }
           elseif(Auth::user()->accesslevel==5)
               $sites=Site::where('site_owner','=',Auth::user()->id)->get();

           $this->sites=$sites;
           $jobs=array();
           $j=Job::all();
           foreach($j as $s)
              foreach($sites as $s1)
                  if($s->job_site->id==$s1->id)
                      array_push($jobs,$s);
           /*$jobs=$j->filter(function ($item, $key) {
               foreach($this->sites as $s)
                   if($item->job_site->id==$s->id)
                       return true;
               return false;
           });*/
           $services=Service::get();
           return view("job.jobs")
               ->with('jobs',$jobs)
               ->with('services',$services)
               ->with('sites',$sites);

       }
       elseif(isset($_GET['siteid']))
       {
           $jobs=Job::where('siteid','=',$_GET['siteid'])->get();
           $request->session()->put("siteid",$_GET['siteid']);
           $services=Service::get();
           return view("job.jobs")
               ->with('jobs',$jobs)
               ->with('services',$services)
               ->with('siteid',$_GET['siteid']);
       }
       elseif($request->session()->has("siteid"))
       {
           $jobs=Job::where('siteid','=',session('siteid'))->get();
           $services=Service::get();
           return view("job.jobs")
               ->with('jobs',$jobs)
               ->with('services',$services)
               ->with('siteid',session('siteid'));
       }
       else
       {
           $jobs=Job::get();
           $services=Service::get();
           return view("job.jobs")
               ->with('jobs',$jobs)
               ->with('services',$services);
        }

   }
    public function showAddJobForm()
    {
        if(isset($_GET['siteid']))
        {
            $site=Site::find($_GET['siteid']);
            $services=Service::get();
             return view("job.add")
                ->with('site',$site)
                 ->with('services',$services);
        }
    }
    public function showEditJobForm()
    {
        if(isset($_GET['jobid']))
        {
            $job=Job::find($_GET['jobid']);
             $services=Service::get();
            return view("job.edit")
                ->with('job',$job)
                ->with('services',$services);
        }
    }
    public function finishJob()
    {
        if (Auth::user()->accesslevel == 2 || Auth::user()->accesslevel == 3 || Auth::user()->accesslevel == 4) {
            if (isset($_GET['jobid'])) {
                $job = Job::find($_GET['jobid']);
                $services = Service::get();
                return view("job.finish")
                    ->with('job', $job);
            }
        }
        else
        {
            return redirect("/");
        }
    }
    public function addJob(Request $request)
    {
        $input=$request->all();
        $sgt="servicegtype_";
        $st="servicetype_";
        $room="room_";
        $rmst="rmst_";
        $rend1="rend_";
        $snote="snote_";
        $sid = 1;
        $totalnumberofjobs=0;
        $services=array();
        $roomerror=0;
        foreach ($input as $key => $val) {
            if (starts_with($key, "serviceid")) {
                $sid=explode("_", $key)[1];
                //$sid=$key.str_split("_")[1];
                $srec=new Service_record();
                $srec->id=$sid;
                $srec->gtype=$input[$sgt.$sid];
                $srec->type=$input[$st.$sid];
                $srec->note=$input[$snote.$sid];
                $srec->room=$input[$room.$sid];
                $srec->rmst=$input[$rmst.$sid];
                $srec->rend=$input[$rend1.$sid];
                if($this->validateService($srec,$input["siteid"])==1)
                {
                    array_push($services,$srec);
                    $sid=$sid+1;
                }
                else
                {
                    $this->roomerror=1;
                }
                //dd($srec);
            }
        }

        $this->siteid=$input["siteid"];
        $this->services=$services;
        $validator=$this->validator($input);
        $params = array('siteid' => $input['siteid']);
        $queryString = http_build_query($params);
        if($validator->fails())
        {
            return redirect('addjob?' . $queryString)
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $job=Job::create(
                [
                    "vac_date" => $input["vacdate"],
                    "jobnote" => $input["jobnote"],
                    "siteid" => $input["siteid"],
                    "totalnumofrooms" => 0,
                    "jc"=>Auth::user()->id,
                ]
            );
            if($job!=null)
            {

                foreach($this->services as $service)
                {
                    $r1=0;
                    $r4=0;
                     if($this->getRoomID($service->room,$this->siteid)!=0)
                         $r1=1;
                    $r2=$this->getRoomID($service->rmst,$this->siteid);
                    $r3=$this->getRoomID($service->rend,$this->siteid);
                    if($r2!=0 && $r3!=0)
                        $r4=abs($r2-$r3)+1;
                    $totalnumberofjobs=$totalnumberofjobs+abs($r1+$r4);
                     JobService::create(
                      [
                          "jobid" => $job->id,
                          "gtype" => $service->gtype,
                          "type" => $service->type,
                          "room" => $this->getRoomID($service->room,$this->siteid),
                          "rmst" => $r2,
                          "rend" => $r3,
                          "note" => $service->note,
                          "numofrooms" => abs($r1+($r4)),
                           $this->getRoomID($service->room,$this->siteid)
                      ]
                    );
                }
                $job->totalnumofrooms=$totalnumberofjobs;
                $job->update();
            }
            if($this->roomerror==1)
                $msg="Job Added, and not all services added.";
            else
                $msg="Job Added, and  all services added.";
            return redirect('addjob?' . $queryString)
                ->with("services",$this->services)
                ->with("notall",$this->roomerror)
                ->with("msg1",$msg)
                ->with("job",$job->id);
        }
    }
    public function editJob(Request $request)
    {
        $allrooms=Room::get();
/*       foreach($allrooms as $room)
        {
            $r=Room::find($room->id);
            $id=$r->type;
            $t=explode("_", $id);
            if(count($t)>1) {
               // dd($t);
                $r->type = $t[1];
                $r->save();
                //dd($r);
            }
            $t=explode("-", $id);
            if(count($t)>1) {
                //dd($t);
                $r->type = $t[1];
                $r->save();
                //dd($r);
            }

        }*/
        $input=$request->all();
        $job=Job::find($input['jobid']);
        $sgt="servicegtype_";
        $st="servicetype_";
        $room="room_";
        $rmst="rmst_";
        $rend1="rend_";
        $snote="snote_";
        $sid = 1;
        $totalnumberofjobs=0;
        $services=array();
        $roomerror=0;
        foreach ($input as $key => $val) {
            if (starts_with($key, "serviceid")) {
                $sid=explode("_", $key)[1];
                //$sid=$key.str_split("_")[1];
                $srec=new Service_record();
                $srec->id=$sid;
                $srec->gtype=$input[$sgt.$sid];
                $srec->type=$input[$st.$sid];
                $srec->note=$input[$snote.$sid];
                $srec->room=$input[$room.$sid];
                $srec->rmst=$input[$rmst.$sid];
                $srec->rend=$input[$rend1.$sid];
                if($this->validateService($srec,$job->job_site->id)==1)
                {
                    array_push($services,$srec);
                    $sid=$sid+1;
                }
                else
                {
                     //dd($srec);
                     $this->roomerror=1;
                }
            }
        }

        $this->siteid=$input["siteid"];
        $this->services=$services;
        $validator=$this->validator($input);
        $params = array('jobid' => $input['jobid']);
        $queryString = http_build_query($params);
        if($validator->fails())
        {
            return redirect('editjob?' . $queryString)
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $job=Job::find($input['jobid']);
            if($job!=null)
            {
                $job->vac_date=$input["vacdate"];
                $job->jobnote=$input["jobnote"];

                foreach($job->job_services as $s) {
                    $service_to_del=JobService::find($s->id);
                    $service_to_del->delete();
                 }
                foreach($this->services as $service)
                {
                    $r1=0;
                    $r4=0;
                    if($this->getRoomID($service->room,$this->siteid)!=0)
                        $r1=1;
                    $r2=$this->getRoomID($service->rmst,$this->siteid);
                    $r3=$this->getRoomID($service->rend,$this->siteid);
                    if($r2!=0 && $r3!=0)
                        $r4=abs($r2-$r3)+1;
                    $totalnumberofjobs=$totalnumberofjobs+abs($r1+$r4);
                    JobService::create(
                        [
                            "jobid" => $job->id,
                            "gtype" => $service->gtype,
                            "type" => $service->type,
                            "room" => $this->getRoomID($service->room,$this->siteid),
                            "rmst" => $r2,
                            "rend" => $r3,
                            "note" => $service->note,
                            "numofrooms" => abs($r1+($r4)),
                            $this->getRoomID($service->room,$this->siteid)
                        ]
                    );
                }
                $job->totalnumofrooms=$totalnumberofjobs;
                $job->status=2;
                $job->save();
            }
            if($this->roomerror==1)
                $msg="Job Updated, and not all services added.";
            else
                $msg="Job Updated, and  all services added.";
            return redirect('editjob?' . $queryString)
                ->with("services",$this->services)
                ->with("notall",$this->roomerror)
                ->with("msg1",$msg)
                ->with("job",$job->id);
        }
    }
    public function validator(array $data)
    {
        $rules=[
            'vacdate' => 'required|checkdate',
        ];
        $messages=[
            'vacdate.required' => 'Site State Required',
            'vacdate.checkdate' => 'Cleaning Job to be requested should be a day in advanced',
          ];
        Validator::extend('checkdate', function ($attribute, $value, $parameters) {
            if($this->getDaysDiffernce($value) < 0)
                return false;
            return true;
        });
        return Validator::make($data,$rules,$messages);
    }
    public function cancelJob(Request $request)
    {
        if(isset($_GET['jobid']))
        {
            $job=Job::find($_GET['jobid']);
            foreach($job->job_services as $s) {
                $service_to_del=JobService::find($s->id);
                $service_to_del->delete();
            }
            $job->delete();
            $jobs=Job::get();
            $sites=Site::get();
            $services=Service::get();
            return redirect('jobs')
                ->with('jobs',$jobs)
                ->with('services',$services)
                ->with('sites',$sites);

        }
    }
    public function confirmJob(Request $request)
    {
        if(isset($_GET['jobid']))
        {
            $job=Job::find($_GET['jobid']);
            $job->status=3;
            $job->save();
            $jobs=Job::get();
            $sites=Site::get();
            $services=Service::get();
            return redirect('jobs')
                ->with('jobs',$jobs)
                ->with('services',$services)
                ->with('sites',$sites);
        }
    }
    public function recordFinishJob(Request $request)
    {
        if (Auth::user()->accesslevel == 2 || Auth::user()->accesslevel == 3 || Auth::user()->accesslevel == 4) {
            $input = $request->all();
            Jobfinish::create(
                [
                    'jobid' => $input['jobid'],
                    'ocd' => $input['o'],
                    'oct' => $input['hours_o'],
                    'nch' => $input['hours_n'],
                    'nct' => $input['hours_n'] * $input['ncost'],
                    'ncp' => $input['ncost'],
                    'sch' => $input['hours_s'],
                    'sct' => $input['hours_s'] * $input['scost'],
                    'scp' => $input['scost'],
                    'ach' => $input['hours_a'],
                    'act' => $input['hours_a'] * $input['acost'],
                    'acp' => $input['acost'],
                ]
            );
            $job = Job::find($input['jobid']);
            $job->status = 5;
            $job->finished_at = $current_time = Carbon::now();
            if ($job->save()) {
                if (isset($input['siteid'])) {
                    $jobs = Job::where('siteid', '=', $input['siteid'])->get();
                } else {
                    $jobs = Job::get();
                }
                $sites = Site::get();
                $services = Service::get();
                return redirect('jobs')
                    ->with('jobs', $jobs)
                    ->with('services', $services)
                    ->with('sites', $sites);
            }
        } else
        {
            return redirect('/');
        }
    }
    public function editJobCost(Request $request)
    {
        if(isset($_GET['jobid']))
        {
            if(isset($_GET['edit']) && $_GET['edit']==1)
            {
                $job=Job::find($_GET['jobid']);
                return view("job.editcost")->with("job",$job);
            }
            else
            {
                $job=Job::find($_GET['jobid']);
                $job->status=6;
                $job->save();
                $jobs=Job::get();
                $sites=Site::get();
                $services=Service::get();
                return redirect('jobs')
                    ->with('jobs',$jobs)
                    ->with('services',$services)
                    ->with('sites',$sites);
            }
        }
    }
    public function editJobCost_post(Request $request)
    {
       $input=$request->all();
       $job=Job::find($input['jobid']);
       $job_cost_record=$job->job_cost_record;
       $job_cost_record['jobid']= $input['jobid'];
       $job_cost_record['ocd']=$input['o'];
       $job_cost_record['oct'] = $input['hours_o'] ;
       $job_cost_record['nch']= $input['hours_n'] ;
       $job_cost_record['nct'] = $input['hours_n'] * $input['ncost'];
       $job_cost_record['ncp'] = $input['ncost'];
       $job_cost_record['sch'] = $input['hours_s'];
       $job_cost_record['sct'] = $input['hours_s'] * $input['scost'];
       $job_cost_record['scp'] = $input['scost'];
       $job_cost_record['ach'] = $input['hours_a'];
       $job_cost_record['act'] = $input['hours_a'] * $input['acost'];
       $job_cost_record['acp'] = $input['acost'];
        if($job_cost_record->save())
        {
             $jobs=Job::get();
            $sites=Site::get();
            $services=Service::get();
            return redirect('jobs')
                ->with('jobs',$jobs)
                ->with('services',$services)
                ->with('sites',$sites);
        }
    }
}
