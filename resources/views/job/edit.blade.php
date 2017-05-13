@extends('layouts.main')
@section('content')
    <h2>{{'Edit Job'}}</h2>
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
        {{ Form::open(array('url' => 'editjob')) }}
        <section style="width: 45%; float: left; margin-right: 5%">
            <div class="field-wrap">
                <label>
                    Day of Vacate*
                </label>
                {!! Form::date('vacdate',$job->vac_date,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Note
                </label>
                {!! Form::textarea('jobnote',$job->jobnote,['class' => 'input']) !!}
            </div>
            <div class="field-wrap" id="selected-rooms">
                <?php $serviceid=1 ?>
                @foreach($job->job_services as $js)
                     <div style="border-radius: 10px; border: grey 1px solid;" class="service-container">
                        <div class="panel panel-default" style="float:right; width:100%;">
                            <input name="serviceid_{{$serviceid}}" type="hidden" value={{$serviceid}} />
                            <input name="servicegtype_{{$serviceid}}" type="hidden" value={{$js->gtype}}>
                            <input name="servicetype_{{$serviceid}}" type="hidden" value={{$js->type}}>
                            @if($js->room!=0)
                            <input name="room_{{$serviceid}}" type="hidden" value={{$js->room_id->identifierFD}}>
                            @else
                            <input name="room_{{$serviceid}}" type="hidden" value="0">
                            @endif
                            @if($js->rmst!=0)
                            <input name="rmst_{{$serviceid}}" type="hidden" value={{$js->rmst_id->identifierFD}}>
                            @else
                            <input name="rmst_{{$serviceid}}" type="hidden" value="0">
                            @endif
                            @if($js->rend!=0)
                                <input name="rend_{{$serviceid}}" type="hidden" value={{$js->rend_id->identifierFD}}>
                            @else
                                <input name="rend_{{$serviceid}}" type="hidden" value="0">
                            @endif
                            <input name="snote_{{$serviceid}}" type="hidden" value={{$js->note}}>
                            <div class="panel-heading">
                       <span style=" display:block; width: 100%; color:white;"> Rooms
                        @if($js->room!=0)
                            {{$js->room_id->identifierFD.' ('.$js->room_id->type.')'}}
                        @else
                            {{$js->rmst_id->identifierFD.':'.$js->rend_id->identifierFD.' ('.$js->rmst_id->type.')'}}
                        @endif
                       </span>
                            </div>
                            <div class="panel-body" style="display: block; font-size: 1.4em; color:white; padding:10px;">
                                <span style="display:block; width: 100%; color:white;"> {{$js->service_name->service}} </span>
                                <span style="display:block; width: 100%; color:darkred; margin-top: 5px;">   {{ $js->note}} </span>
                            </div>
                        </div>
                        <div class="field-wrap">
                            <div>
                                <label style="font-weight: bold; color:#2b2b2b">
                                    Delete Service
                                </label>
                                <a href="#" class="delservice" name="delservice_"  ><img src='img/del.jpg' alt="Logo"> </a>
                            </div>
                        </div>
                    </div>
                        <?php $serviceid=$serviceid+1 ?>
                @endforeach
            </div>
            <div class="field-wrap" style="width:100%;margin-top: 0px;">
                {!! Form::submit('Submit',['style' => 'width:100%;','id' => 'submit','class' => 'input submit']) !!}
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
                        {!! Form::text('room1',null,['autocomplete' => 'on', 'id' => 'room1','placeholder'=> 'Select Room','class' => 'input']) !!}
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
                    {!! Form::hidden('jobid',$job->id,['id' => 'jobid']) !!}
                    {!! Form::hidden('siteid',$job->job_site->id,['id' => 'siteid']) !!}
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
