@extends('layouts.main')
@section('nav')
    <p></p>
@stop
@section('content')
    <h2>Manage Sites</h2>
    @if(session()->has("msg"))
        <span class="msg" style="display: block; margin-bottom: 10px;"> {{ session("msg")}}  </span>
    @endif
    @if (count($errors) > 0)
        <ul class="error" style="display: block; float: right">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    @if(session('view')==null)
    <table id="sites-table" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>City</th>
            <th>Supervisor</th>
            <th>Rate</th>
            <th> </th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    @else
    @if(session('view')=="add")
        <section class="form-content" id="add_new_site" style="display: block;">
            {{ Form::open(array('url' => 'addsite')) }}
            <div class="field-wrap">
                <button type="button" class="close">Close</button>
            </div>
            <div class="field-wrap">
                <label>
                    Name*
                </label>
                {!! Form::text('name',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Description
                </label>
                {!! Form::textarea('description',null,['class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Cost Per Hour*
                </label>
                {!! Form::text('clnCostPH','55.00',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    State*
                </label>
                <select name='state' class="input">
                    @if (session()->has("state")==false)
                        <option value='-1'>Site State</option>
                        @foreach($states as $state )
                            <option value={{$state->id}}>{{$state->name}}</option>
                        @endforeach
                    @else
                        @if (session("state")==-1 )
                            <option value='-1'>Site State</option>
                        @endif
                        @foreach($states as $state )
                            @if (session()->has("state") && session("state")==$state->id )
                                <option selected="selected" value={{ $state->id }}>{{ $state->name }}</option>
                            @else
                                <option value={{$state->id}}>{{$state->name}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="field-wrap">
                <label>
                    City*
                </label>
                {!! Form::text('city','Sydney',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Suburb*
                </label>
                {!! Form::text('suburb','Sydney',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Address*
                </label>
                {!! Form::text('address','Sydney',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Mobile*
                </label>
                {!! Form::tel('mobile','0412345678',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Phone
                </label>
                {!! Form::tel('phone',null,['class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Fax
                </label>
                {!! Form::tel('fax',null,['class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Supervisor*
                </label>
                <select name='sup' class="input">
                    @if (session()->has("sup")==false)
                        <option value='-1'>Site Supervisor</option>
                        @foreach($sup as $s )
                            <option value={{$s->id}}>{{$s->fullname}}</option>
                        @endforeach
                    @else
                        @if (session("sup")==-1 )
                            <option value='-1'>Site Supervisor</option>
                        @endif
                        @foreach($sup as $s )
                            @if (session()->has("sup") && session("sup")==$s->id )
                                <option selected="selected" value={{$s->id}}>{{$s->fullname}}</option>
                            @else
                                <option value={{$s->id}}>{{$s->fullname}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="field-wrap">
                <label>
                    Site Owner*
                </label>
                <select name='owner' class="input">
                    @if (session()->has("owner")==false)
                        <option value='-1'>Site Owner</option>
                        @foreach($sit_owner as $o )
                            <option value={{$o->id}}>{{$o->fullname}}</option>
                        @endforeach
                    @else
                        @foreach($sit_owner as $o )
                            <option value='-1'>Site Owner</option>
                            @if (session()->has("owner") && session("owner")==$o->id )
                                <option selected="selected" value={{$o->id}}>{{$o->fullname}}</option>
                            @else
                                <option value={{$o->id}}>{{$o->fullname}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="field-wrap">
                <label>
                </label>
                {!! Form::submit('Submit',['id' => 'submit','class' => 'input submit']) !!}
            </div>
            {{ Form::close() }}
        </section>
    @endif
    @if(session('view')=="update")
        <section class="form-content" id="update_site" style="display: block;">
            {{ Form::open(array('url' => 'updateSite')) }}
            {!! Form::hidden('id',null,['id' => 'id']) !!}
            <div class="field-wrap">
                <button type="button" class="close">Close</button>
            </div>
            <div class="field-wrap">
                <label>
                    Name*
                </label>
                {!! Form::text('name',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Description
                </label>
                {!! Form::textarea('description',null,['class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Cost Per Hour*
                </label>
                {!! Form::text('clnCostPH','55.00',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    State*
                </label>
                <select name='state' class="input">
                    @foreach($states as $state )
                        @if (session()->has("state") && session("state")==$state->id )
                            <option selected="selected" value={{ $state->id }}>{{ $state->name }}</option>
                        @else
                            <option value={{$state->id}}>{{$state->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="field-wrap">
                <label>
                    City*
                </label>
                {!! Form::text('city','Sydney',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Suburb*
                </label>
                {!! Form::text('suburb','Sydney',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Address*
                </label>
                {!! Form::text('address','Sydney',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Mobile*
                </label>
                {!! Form::tel('mobile','0412345678',['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Phone
                </label>
                {!! Form::tel('phone',null,['class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Fax
                </label>
                {!! Form::tel('fax',null,['class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Supervisor*
                </label>
                <select name='sup' class="input">
                    @foreach($sup as $s )
                        @if (session("sup")==-1 )
                            <option value='-1'>Site Supervisor</option>
                        @endif
                        @if (session()->has("sup") && session("sup")==$s->id )
                            <option selected="selected" value={{$s->id}}>{{$s->fullname}}</option>
                        @else
                            <option value={{$s->id}}>{{$s->fullname}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="field-wrap">
                <label>
                    Site Owner*
                </label>
                <select name='owner' class="input">
                    @foreach($sit_owner as $o )
                        <option value='-1'>Site Owner</option>
                        @if (session("sit_owner")==-1 )
                            <option value='-1'>Site Owner</option>
                        @endif
                        @if (session()->has("sit_owner") && session("sit_owner")==$o->id )
                            <option selected="selected" value={{$o->id}}>{{$o->fullname}}</option>
                        @else
                            <option value={{$o->id}}>{{$o->fullname}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="field-wrap">
                <label>
                </label>
                {!! Form::submit('Submit',['id' => 'submit','class' => 'input submit']) !!}
            </div>
            {{ Form::close() }}
        </section>
    @endif
    @if(session('view')=="addroom")
        <section class="form-content" id="add_room" style="display: block;">
            {{ Form::open(array('url' => 'addRoom')) }}
            {!! Form::hidden('siteid',null,['id' => 'siteid']) !!}
            <div class="field-wrap">
                <button id="close-model" type="button" class="close">Close</button>
            </div>
            <div class="field-wrap">
                <label>
                    Room ID
                </label>
                {!! Form::text('identifierFD',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Room Type
                </label>
                {!! Form::text('roomType',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                </label>
                {!! Form::submit('Submit',['id' => 'submit','class' => 'input submit']) !!}
            </div>
            {{ Form::close() }}
        </section>
    @endif
    @endif
    <section class="form-content" id="add_new_site" style="display: none;">
        {{ Form::open(array('url' => 'addsite')) }}
        <div class="field-wrap">
            <button type="button" class="close">Close</button>
        </div>
        <div class="field-wrap">
            <label>
                Name*
            </label>
            {!! Form::text('name',null,['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Description
            </label>
            {!! Form::textarea('description',null,['class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Cost Per Hour*
            </label>
            {!! Form::text('clnCostPH','55.00',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                State*
            </label>
            <select name='state' class="input">
                @if (session()->has("state")==false)
                    <option value='-1'>Site State</option>
                    @foreach($states as $state )
                        <option value={{$state->id}}>{{$state->name}}</option>
                    @endforeach
                @else
                    @if (session("state")==-1 )
                        <option value='-1'>Site State</option>
                    @endif
                    @foreach($states as $state )
                        @if (session()->has("state") && session("state")==$state->id )
                            <option selected="selected" value={{ $state->id }}>{{ $state->name }}</option>
                        @else
                            <option value={{$state->id}}>{{$state->name}}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
        <div class="field-wrap">
            <label>
                City*
            </label>
            {!! Form::text('city','Sydney',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Suburb*
            </label>
            {!! Form::text('suburb','Sydney',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Address*
            </label>
            {!! Form::text('address','Sydney',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Mobile*
            </label>
            {!! Form::tel('mobile','0412345678',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Phone
            </label>
            {!! Form::tel('phone',null,['class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Fax
            </label>
            {!! Form::tel('fax',null,['class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Supervisor*
            </label>
            <select name='sup' class="input">
                @if (session()->has("sup")==false)
                    <option value='-1'>Site Supervisor</option>
                    @foreach($sup as $s )
                        <option value={{$s->id}}>{{$s->fullname}}</option>
                    @endforeach
                @else
                    @if (session("sup")==-1 )
                        <option value='-1'>Site Supervisor</option>
                    @endif
                    @foreach($sup as $s )
                        @if (session()->has("sup") && session("sup")==$s->id )
                            <option selected="selected" value={{$s->id}}>{{$s->fullname}}</option>
                        @else
                            <option value={{$s->id}}>{{$s->fullname}}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
        <div class="field-wrap">
            <label>
                Site Owner*
            </label>
            <select name='owner' class="input">
                    @if (session()->has("owner")==false)
                        <option value='-1'>Site Owner</option>
                        @foreach($sit_owner as $o )
                            <option value={{$o->id}}>{{$o->fullname}}</option>
                        @endforeach
                    @else
                    @foreach($sit_owner as $o )
                        <option value='-1'>Site Owner</option>
                    @if (session()->has("sit_owner") && session("sit_owner")==$o->id )
                        <option selected="selected" value={{$o->id}}>{{$o->fullname}}</option>
                    @else
                        <option value={{$o->id}}>{{$o->fullname}}</option>
                    @endif
                    @endforeach
                    @endif
            </select>
        </div>
        <div class="field-wrap">
            <label>
            </label>
            {!! Form::submit('Submit',['id' => 'submit','class' => 'input submit']) !!}
        </div>
        {{ Form::close() }}
    </section>
    <section class="form-content" id="add_room" style="display: none;">
        {{ Form::open(array('url' => 'addRoom')) }}
        {!! Form::hidden('siteid',null,['id' => 'siteid']) !!}
        <div class="field-wrap">
            <button type="button" class="close">Close</button>
        </div>
        <div class="field-wrap">
            <label>
                Room ID
            </label>
            {!! Form::text('identifierFD',null,['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Room Type
            </label>
            {!! Form::text('roomType',null,['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
            </label>
            {!! Form::submit('Submit',['id' => 'submit','class' => 'input submit']) !!}
        </div>
        {{ Form::close() }}
    </section>
    <section class="form-content" id="update_site" style="display: none;">
        {{ Form::open(array('url' => 'updateSite')) }}
        {!! Form::hidden('id',null,['id' => 'id']) !!}
        <div class="field-wrap">
            <button type="button" class="close">Close</button>
        </div>
        <div class="field-wrap">
            <label>
                Name*
            </label>
            {!! Form::text('name',null,['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Description
            </label>
            {!! Form::textarea('description',null,['class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Cost Per Hour*
            </label>
            {!! Form::text('clnCostPH','55.00',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                State*
            </label>
            <select name='state' class="input">
                    @foreach($states as $state )
                        @if (session()->has("state") && session("state")==$state->id )
                            <option selected="selected" value={{ $state->id }}>{{ $state->name }}</option>
                        @else
                            <option value={{$state->id}}>{{$state->name}}</option>
                        @endif
                    @endforeach
            </select>
        </div>
        <div class="field-wrap">
            <label>
                City*
            </label>
            {!! Form::text('city','Sydney',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Suburb*
            </label>
            {!! Form::text('suburb','Sydney',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Address*
            </label>
            {!! Form::text('address','Sydney',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Mobile*
            </label>
            {!! Form::tel('mobile','0412345678',['required' => 'true','class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Phone
            </label>
            {!! Form::tel('phone',null,['class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Fax
            </label>
            {!! Form::tel('fax',null,['class' => 'input']) !!}
        </div>
        <div class="field-wrap">
            <label>
                Supervisor*
            </label>
            <select name='sup' class="input">
                @foreach($sup as $s )
                    @if (session("sup")==-1 )
                        <option value='-1'>Site Supervisor</option>
                    @endif
                    @if (session()->has("sup") && session("sup")==$s->id )
                        <option selected="selected" value={{$s->id}}>{{$s->fullname}}</option>
                    @else
                        <option value={{$s->id}}>{{$s->fullname}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="field-wrap">
            <label>
                Site Owner*
            </label>
        <select name='owner' class="input">
                @foreach($sit_owner as $o )
                      @if (session("sit_owner")==-1 )
                        <option value='-1'>Site Owner</option>
                      @endif
                      @if (session()->has("sit_owner") && session("sit_owner")==$o->id )
                        <option selected="selected" value={{$o->id}}>{{$o->fullname}}</option>
                      @else
                        <option value={{$o->id}}>{{$o->fullname}}</option>
                      @endif
                @endforeach
        </select>
        </div>
        <div class="field-wrap">
            <label>
            </label>
            {!! Form::submit('Submit',['id' => 'submit','class' => 'input submit']) !!}
        </div>
        {{ Form::close() }}
    </section>

@stop
