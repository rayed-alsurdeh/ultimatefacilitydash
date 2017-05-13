<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Site\AddSite;
use App\Models\Site;
use Illuminate\Support\Facades\Validator;

class AddSiteController extends Controller
{
    use AddSite;
    protected $redirectTo = 'addsite';
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function create(array $data)
    {
        Site::create([
            'name' => $data['name'],
            'state' => $data['state'],
            'city' => $data['city'],
            'suburb' => $data['suburb'],
            'address' => $data['address'],
            'mobile' => $data['mobile'],
            'phone' => $data['phone'],
            'phone' => $data['phone'],
            'clnCostPH' => $data['clnCostPH'],
            'supervisor' => $data['sup'],
            'site_owner' => $data['owner'],
            'fax' => $data['fax']]);
    }
    protected function update(array $data)
    {
        $site = Site::find($data["id"]);
        $site->name= $data['name'];
        $site->state= $data['state'];
        $site->city= $data['city'];
        $site->suburb= $data['suburb'];
        $site->address= $data['address'];
        $site->mobile= $data['mobile'];
        $site->phone= $data['phone'];
        $site->clnCostPH= $data['clnCostPH'];
        $site->fax= $data['fax'];
        $site->supervisor= $data['sup'];
        $site->site_owner= $data['owner'];
        $site->update();
     }
    protected function validator(array $data)
    {
        $rules=[
            'name' => 'required',
            'state' => 'numeric|min:1',
            'city' => 'required',
            'suburb' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'clnCostPH' => 'required|numeric|min:1',
            'sup' => 'numeric|min:1',
            'owner' => 'numeric|min:1',
        ];
        $messages=[
            'state.min' => 'Site State Required',
            'name.required' => 'Name Required',
            'city.required' => 'City Required',
            'suburb.required' => 'Suburb Required',
            'address.required' => 'Address Required',
            'mobile.required' => 'Mobile Required',
            'clnCostPH.required' => 'Cost Required',
            'clnCostPH.numeric' => 'Cost is a Number',
            'clnCostPH.min' => 'Cost is Greater than zero',
            'sup.min' => 'Site Supervisor Required',
            'owner.min' => 'Site Owner Required',
        ];
        return Validator::make($data,$rules,$messages);
    }
}
