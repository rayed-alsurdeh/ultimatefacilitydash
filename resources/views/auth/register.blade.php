@extends('layouts.main')
@section('content')
    <h2>Users Management</h2>
    <table id="users-table" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Access level</th>
            <th>Sites</th>
            <th> </th>
         </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <span class="msg" style="display: none;"> {{ session("msg")}}  </span>
    @if(session()->has("msg"))
        <span class="msg" style="display: block;"> {{ session("msg")}}  </span>
    @endif
    @if (count($errors) > 0)
        <ul class="error" style="display: block; float: left">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
        <section class="form-content" id="add_new_user">
            {{ Form::open(array('url' => 'register')) }}
            <div class="field-wrap">
                <label>
                    Title*
                </label>
                <select name='title' class="input">
                    @if (session()->has("title")==false)
                        <option value='-1'>User Title</option>
                        @foreach($titles as $title )
                            <option value={{$title->id}}>{{$title->title}}</option>
                        @endforeach
                    @else
                        @if (session("title")==-1 )
                            <option selected="selected" value='-1'>User Title</option>
                        @endif
                        @foreach($titles as $title )
                            @if (session()->has("title") && session("title")==$title->id )
                                <option selected="selected" value={{ $title->id }}>{{ $title->title }}</option>
                            @else
                                <option value={{$title->id}}>{{$title->title}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="field-wrap">
                <label>
                    Full Name*
                </label>
                {!! Form::text('fullname',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Email*
                </label>
                {!! Form::email('email',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Access Level*
                </label>
                <select name="accesslevel" class="input">
                    @if (session()->has("accesslevel")==false)
                        <option value='-1'>User Access Level</option>
                        @foreach($accesslevel as $level )
                            <option value={{$level->id}}>{{$level->accesslevel}}</option>
                        @endforeach
                    @else
                        @if (session("accesslevel")==-1 )
                            <option selected="selected" value='-1'>User Access Level</option>
                        @endif
                        @foreach($accesslevel as $level )
                            @if (session()->has("accesslevel") && session("accesslevel")==$level->id )
                                <option selected="selected" value={{$level->id}}>{{$level->accesslevel}}</option>
                            @else
                                <option value={{$level->id}}>{{$level->accesslevel}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="field-wrap">
                <label>
                    Address*
                </label>
                {!! Form::text('address',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Mobile*
                </label>
                {!! Form::tel('mobile',null,['required' => 'true','class' => 'input']) !!}
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

                </label>
                {!! Form::submit('Add User',['id' => 'submit','class' => 'input submit']) !!}
            </div>
            {{ Form::close() }}
        </section>

        <section class="form-content" id="update_user" style="display: none;">
            {{ Form::open(array('url' => 'update_user')) }}
            <div class="field-wrap">
                <label>
                    Title*
                </label>
                <select name='title' class="input" disabled="disabled">
                    @if (session()->has("title")==false)
                        @foreach($titles as $title )
                            <option value={{$title->id}}>{{$title->title}}</option>
                        @endforeach
                    @else
                        @if (session("title")==-1 )
                            <option selected="selected" value='-1'>User Title</option>
                        @endif
                        @foreach($titles as $title )
                            @if (session()->has("title") && session("title")==$title->id )
                                <option selected="selected" value={{ $title->id }}>{{ $title->title }}</option>
                            @else
                                <option value={{$title->id}}>{{$title->title}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="field-wrap">
                <label>
                    Full Name*
                </label>
                {!! Form::hidden('id',null,['id' => 'id']) !!}
                {!! Form::text('fullname',null,['disabled' => 'disabled','required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Email*
                </label>
                {!! Form::email('email',null,['disabled' => "disabled",'class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Access Level*
                </label>
                <select name="accesslevel" class="input">
                    @if (session()->has("accesslevel")==false)
                        @foreach($accesslevel as $level )
                            <option value={{$level->id}}>{{$level->accesslevel}}</option>
                        @endforeach
                    @else
                        @foreach($accesslevel as $level )
                            @if (session()->has("accesslevel") && session("accesslevel")==$level->id )
                                <option selected="selected" value={{$level->id}}>{{$level->accesslevel}}</option>
                            @else
                                <option value={{$level->id}}>{{$level->accesslevel}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="field-wrap">
                <label>
                    Address*
                </label>
                {!! Form::text('address',null,['required' => 'true','class' => 'input']) !!}
            </div>
            <div class="field-wrap">
                <label>
                    Mobile*
                </label>
                {!! Form::tel('mobile',null,['required' => 'true','class' => 'input']) !!}
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

                </label>
                {!! Form::submit('Submit',['id' => 'submit','class' => 'input submit']) !!}
            </div>
            {{ Form::close() }}
        </section>
@stop
