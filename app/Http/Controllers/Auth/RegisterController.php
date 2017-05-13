<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use Auth;
class RegisterController extends Controller
{

    use RegistersUsers;
    protected $redirectTo = '/users';
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function validator(array $data)
    {
        $rules=[
            'title' => 'numeric|min:1',
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'accesslevel' => 'numeric|min:1',
            'address' => 'required',
            'mobile' => 'required',
            ];
        $messages=[
            'title.min' => 'User Title Required',
            'fullname.required' => 'Full Name Required',
            'email.email' => 'Not a Valid Email',
            'email.unique' => 'Email address already existed',
            'accesslevel.min' => 'User type (Access Level) is Required',
            'address' => 'Address Required',
            'mobile' => 'Mobile Required',
        ];
        return Validator::make($data,$rules,$messages);    }
    protected function update_validator(array $data)
    {
        $rules = [
            'title' => 'numeric|min:1',
            'fullname' => 'required',
            'accesslevel' => 'numeric|min:1',
            'address' => 'required',
            'mobile' => 'required',
        ];
        $messages = [
            'title.min' => 'User Title Required',
            'fullname.required' => 'Full Name Required',
            'accesslevel.min' => 'User type (Access Level) is Required',
            'address' => 'Address Required',
            'mobile' => 'Mobile Required',
        ];
        return Validator::make($data, $rules, $messages);
    }
    protected function create(array $data)
    {
        User::create([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'address' => $data['address'],
            'mobile' => $data['mobile'],
            'phone' => $data['phone'],
            'fax' => $data['fax'],
            'title' => $data['title'],
            'accesslevel' => $data['accesslevel'],
            'status' => 1,
            'password' => bcrypt($this->GeneratePassword())]);
    }
    protected function update(array $data)
    {
        $user = User::find($data['id']);
        $user->title=$data['title'];
        $user->update();
        return $user;
    }
    protected function GeneratePassword()
    {
        return 'admin@123';
        /*
        $id_format = Carbon::now()->toDateTimeString();
        return 'FC_' . $id_format[3] . $id_format[14] . $id_format[15] . $id_format[17] . $id_format[18];*/
    }
    protected function logout()
    {
        Auth::logout();
        return redirect('/');

    }
}
