@extends('layouts.main')
@section('content')
    <h2>{{$site->name.' Site Jobs'}}</h2>
    <section class="form-content" id="addjob" style="display: block; width: 100%">
        @if(session()->has("msg"))
            <span class="msg" style="display: block;"> {{ session("msg")}}
                <a style="color: yellow;" href={{"editjob?jobid=".session("job")}}>Click to update the job</a>
            </span>
        @endif
            @if(session()->has("msg1"))
                <span class="msg" style="display: block;">
                    {{ session("msg1")}}
                    <a style="color: yellow;" href={{"editjob?jobid=".session("job")}}>Click to update the job</a>
                </span>
            @endif
        @if (count($errors) > 0)
            <ul class="error" style="display: block; float: right">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        {{ Form::open(array('url' => 'addnewjob')) }}
            <section style="width: 45%; float: left; margin-right: 5%">
                <div class="field-wrap">
                    <label>
                        Day of Vacate*
                    </label>
                    {!! Form::date('vacdate',null,['required' => 'true','class' => 'input']) !!}
                </div>
                <div class="field-wrap">
                    <label>
                        Note
                    </label>
                    {!! Form::textarea('jobnote',null,['class' => 'input']) !!}
                </div>
                <div class="field-wrap" id="selected-rooms">
                </div>
                <div class="field-wrap" style="margin-top: 0px;">
                    {!! Form::submit('Submit',['style'=> 'width:100%;','id' => 'submit','class' => 'input submit']) !!}
                </div>
            </section>
            <section style="width: 45%; float: left; margin-right: 5%">
                <div class="field-wrap" id="selected-rooms">
                    <label style="font-weight: bold; color:#00AA00">
                    </label>
                    <div>
                        <label style="font-weight: bold; color:#2b2b2b">
                            Add  Service
                        </label>
                        <a href="#" id="add_service_link"><img src={{asset('img/add_service.png')}} alt="Logo"> </a>
                    </div>
                </div>
            <section id="add_service_form" style="width: 100%; float: left;">
                    <div class="field-wrap" id="room_services" style="width: 100%;">
                             <label></label>
                            <label class="input" style="background-color: #00AA00; opacity: 0.5; color:white;">
                                <span style="width:75%; float: left;">Group of Rooms</span>
                                <input id="servicegtype" type="checkbox" value="" style="width:15%; float: left;">
                            </label>
                    </div>
                <label id="service_add_error" style="background-color:red; opacity: 0.5; color:white; width: 75%; border-radius: 50px; padding: 10px; float: right; text-align: center;display: none;">

                </label>
                    <div class="field-wrap">
                        <label>

                        </label>
                        <div class="field-wrap" id="sel_room" style="display: block">
                            <label>
                            </label>
                            {!! Form::text('room1',null,['id' => 'room1','placeholder'=> 'Select Room','class' => 'input']) !!}
                        </div>
                        <div class="field-wrap" id="sel_room1" style="display: none">
                            <label>
                            </label>
                            {!! Form::text('room_s',null,['id' => 'room_s','placeholder'=> 'Select Start Room Range','class' => 'input']) !!}
                        </div>
                        <div class="field-wrap" id="sel_room2" style="display: none">
                            <label>
                            </label>
                            {!! Form::text('room_e',null,['id' => 'room_e','placeholder'=> 'Select End Room Range','class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field-wrap">
                        <label>
                        </label>
                        {!! Form::hidden('siteid',$site->id,['id' => 'siteid']) !!}
                        <select id="rooms" class="input">
                             @foreach($services as $service)
                                @if($service->id==1)
                                <option value="{{$service->id}}"> {{$service->service}}</option>
                                @else
                                <option value="{{$service->id}}"> {{$service->service}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="field-wrap">
                        <label>

                        </label>
                        {!! Form::textarea('note',null,['id' => 'service_note','class' => 'input']) !!}
                    </div>
                    <div class="field-wrap">
                        <label>
                        </label>
                        {!! Form::button('Add Room',['style' => 'background-color:#a4aaae;','id' => 'add_service','class' => 'input submit']) !!}
                    </div>
            </section>
            </section>
        {{ Form::close() }}
    </section>
@stop
