<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" lang="en-US">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html lang="en-US"><!--<![endif]-->
<head>
{{--
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
--}}
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
    <link rel="stylesheet" href="{{ asset('/datatables/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/datatables/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">

    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="https://npmcdn.com/bootstrap@4.0.0-alpha.5/dist/js/bootstrap.min.js"></script>
     <script src="{{ asset('/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/js/handlebars.js') }}"></script>
    <script src="{{ asset('/datatables/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    @include('partials.handlebars-template')
</head>
<body>
<div class="container-fluid">
    <section id="header" class="row">
        <input type="hidden" id="f">
            <section id="logo" class="col-6">
                <a href="#">
                    <img src={{asset('img/ultimatefacilityservicesLogo1.png')}} alt="Logo">
                    <span style="display: inline-block"> ULTIMATE FACILITY SERVICES </span>
                </a>
            </section>
            @if (Auth::check())
                <section class="col-4">
                    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                         <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="sites">Sites</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="jobs?alljobs=all">Jobs</a>
                                </li>
                                @if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3)
                                    <li class="nav-item">
                                        <a class="nav-link" href="users" onclick='loadUsersData();'>Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="sites">Reports</a>
                                    </li>
                                @endif
                                    <li class="nav-item">
                                        <a class="nav-link" href="sites">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" href="logout">Logout</a>
                                    </li>
                            </ul>
                         </div>
                    </nav>
                </section>
            <span style="display: block; float: right; line-height: 50px; color: yellow">
              Welcome {{substr(Auth::user()->fullname,0,10)}} </span>
            @else
            @endif
        </section>
</div>

<section id="content">
    @if (Auth::check())
    @yield("content")
    @else
    <section class="form-content" style="display: block;">
        @if(session()->has("msg"))
            <span class="msg" style="display: block;"> {{ session("msg")}}  </span>
        @endif
        @if (count($errors) > 0)
            <ul class="error" style="display: block; float: right;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
            {{ Form::open(array('url' => 'login')) }}
            <div class="field-wrap">
                <label>
                    Email*
                </label>
                {!! Form::email('email',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Password*
                </label>
                {!! Form::password('password',['required' => 'true','class' => 'input']) !!}
            </div>
           <div class="field-wrap">
            <label>
            </label>
            <span style="float: left; margin-left: 25%; color:green;"> Remember Me!
                {!! Form::checkbox('remember','remember','true') !!} </span>
        </div>
            <div class="field-wrap">
                <label>
                </label>
                {!! Form::submit('Submit',['id' => 'submit','class' => 'input submit']) !!}
            </div>
            {{ Form::close() }}
        </section>
    @endif
</section>
</div>
</body>