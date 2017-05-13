@extends('layouts.main')
@section('nav')
    <p></p>
@stop
@section('content')
    <h2><span>Cleaning Jobs</span>
        <ul style="margin-left: 10px;">
            <li style="margin-right:10px;"> All Jobs <input type="radio" value="All" name="jobtype"/></li>
            <li style="margin-right:10px;"> Submitted <input type="radio" value="Submitted" name="jobtype"/></li>
            <li style="margin-right:10px;"> Confirmed <input type="radio" value="Confirmed" name="jobtype"/></li>
            <li style="margin-right:10px;"> Edited <input type="radio" value="Edited" name="jobtype"/></li>
            <li style="margin-right:10px;"> Finished <input type="radio" value="Finished" name="jobtype"/></li>
            <li style="margin-right:10px;"> Reported <input type="radio" value="Reported" name="jobtype"/></li>
        </ul>
    </h2>
    <section id="data-viewer">
        @for($count=0;$count<count($jobs);$count++)
            <div class="panel panel-default">
                <div id={{$jobs[$count]->job_status->status.'_class'.$jobs[$count]->id}} class={{'panel-heading '.$jobs[$count]->job_status->status}}>
                    <a id={{'data-row'}} href="#" style="display: inline-block;">
                        <?php
                        $date = date_create($jobs[$count]->vac_date);
                        $date = date_format($date, "d F Y")
                        ?>
                        {{'# '.$date.' ('.$jobs[$count]->job_site->name.')'}}
                    </a>
                    @if($jobs[$count]->status!=6)
                        <div class="btn-group" style="height: 100%; float: right;">
                            <button type="button" class="btn btn-primary">Job Actions</button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" style="min-width: 100%;">
                                @if($jobs[$count]->status==1 || $jobs[$count]->status==2)
                                    @if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3 || Auth::user()->accesslevel==4 )
                                        <a class="dropdown-item"
                                           href={{'confirmjob?jobid='.$jobs[$count]->id}}>Confirm</a>
                                        <a class="dropdown-item"
                                           href={{'canceljob?jobid='.$jobs[$count]->id}}>Cancel</a>
                                    @endif
                                    <a class="dropdown-item" href={{'editjob?jobid='.$jobs[$count]->id}}>Edit</a>
                                @elseif($jobs[$count]->status==3)
                                    @if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3 || Auth::user()->accesslevel==4 )
                                        <a class="dropdown-item" href={{'editjob?jobid='.$jobs[$count]->id}}>Edit</a>
                                        <a class="dropdown-item"
                                           href={{'canceljob?jobid='.$jobs[$count]->id}}>Cancel</a>
                                        <a class="dropdown-item"
                                           href={{'finishJob?jobid='.$jobs[$count]->id}}>Finish</a>
                                    @endif
                                @elseif($jobs[$count]->status==5)
                                    @if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3 || Auth::user()->accesslevel==4 )
                                        <a class="dropdown-item" href={{'editJobCost?edit=1&jobid='.$jobs[$count]->id}}>Edit
                                            Job Cost</a>
                                    @endif
                                    @if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3)
                                        <a class="dropdown-item" href={{'editJobCost?edit=0&jobid='.$jobs[$count]->id}}>Confirm
                                            Job Cost</a>
                                    @endif
                                @elseif($jobs[$count]->status==6)
                                    @if(Auth::user()->accesslevel==2 || Auth::user()->accesslevel==3)
                                        <a class="dropdown-item"
                                           href={{'generateinvoice?edit=1&jobid='.$jobs[$count]->id}}>Generate
                                            Invoice</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="panel-body">
                    <ul class="list-group" style="float: left; width: 50%;">
                        <li class="list-group-item">
                            <?php
                            $date = date_create($jobs[$count]->created_at);
                            $date = date_format($date, "d F Y")
                            ?>
                            <span class="data-header"> Created in </span>
                            <span class="data-content">
                                {{$date}}
                            </span>
                        </li>
                        <li class="list-group-item">
                            @if($jobs[$count]->finished_at!=NULL)
                                <?php
                                $date = date_create($jobs[$count]->finished_at);
                                $date = date_format($date, "d F Y")
                                ?>
                                <span class="data-header"> Finished in</span>
                                <span class="data-content">
                                {{$date}}
                            </span>
                            @else
                                <?php
                                $date = date_create($jobs[$count]->updated_at);
                                $date = date_format($date, "d F Y")
                                ?>
                                <span class="data-header"> Updated in</span>
                                <span class="data-content">
                                {{$date}}
                            </span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> Created By </span>
                            <span>
                            <a href="#" id={{'site_sup_'.$jobs[$count]->job_c->id}}>
                                {{$jobs[$count]->job_c->fullname}} </a>
                                </span>
                        </li>

                    </ul>
                    <ul class="list-group" style="float: left; width: 50%;">
                        <li class="list-group-item">
                            <span class="data-header"> Status </span>
                            <span class="data-content">
                            {{$jobs[$count]->job_status->status}}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> Notes </span>
                            <span class="data-content"> {{$jobs[$count]->jobnote}} </span>
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> # Rooms  </span>
                            <span class="data-content"> {{$jobs[$count]->totalnumofrooms}} </span>
                        </li>
                    </ul>

                    <ul class="list-group" style="width:100%;">
                        <li class="list-group-item">
                            <span style=" opacity: 0.6; text-align: center; width: 100%;color:white; background-color: #5cb85c; line-height: 30px;">
                            Room Services Details
                            </span>
                            <table style="width: 100%; font-size:1em;">
                                <tbody>
                                @foreach($jobs[$count]->job_services as $js)
                                    <tr style="width:100%;margin-top: 10px;display: flex;">
                                        <td style="width: 20%">
                                            @if($js->room!=0)
                                                {{'Room '.$js->room_id->identifierFD}}
                                            @else
                                                <?php  ?>
                                                {{'Room '.$js->rmst_id->identifierFD.' to '.$js->rend_id->identifierFD[2].$js->rend_id->identifierFD[3]}}
                                            @endif
                                        </td>
                                        <td style="width: 20%">
                                            @if($js->room!=0)
                                                {{$js->room_id->type}}
                                            @else
                                                {{$js->rmst_id->type}}
                                            @endif
                                        </td>
                                        <td style="width: 15%">
                                            {{$js->service_name->service}}
                                        </td>
                                        <td style="width: 15%">
                                            {{$js->numofrooms}}
                                        </td>
                                        <td style="width: 30%">
                                            {{$js->note}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </li>

                    </ul>
                    @if($jobs[$count]->status==6)
                        <ul class="list-group" style="width:100%;">
                            <li class="list-group-item">
                            <span style=" opacity: 0.6; margin-bottom: 10px; text-align: center; width: 100%;color:white; background-color: #5cb85c; line-height: 30px;">
                            Cleaning Services Cost Details
                            </span>
                                <table style="width: 100%; font-size:1em;">
                                    <tbody>
                                    <tr style="line-height: 40px;">
                                        <td style="width: 40%;"> Normal Cleaning Service</td>
                                        <td> {{'$'.$jobs[$count]->job_cost_record->ncp.' Per hour'}} </td>
                                        <td> {{'$'.$jobs[$count]->job_cost_record->nct}} </td>

                                    </tr>
                                    <tr style="line-height: 40px;">
                                        <td style="width: 40%;"> Steam Cleaning Service</td>
                                        <td> {{'$'.$jobs[$count]->job_cost_record->scp.' Per hour'}} </td>
                                        <td> {{'$'.$jobs[$count]->job_cost_record->sct}} </td>

                                    </tr>
                                    <tr style="line-height: 40px;">
                                        <td style="width: 40%;"> Acid Washing Service</td>
                                        <td> {{'$'.$jobs[$count]->job_cost_record->acp.' Per hour'}} </td>
                                        <td> {{'$'.$jobs[$count]->job_cost_record->act}} </td>

                                    </tr>
                                    <tr style="line-height: 40px;">
                                        <td style="width: 40%;"> Other Services</td>
                                        <td> {{$jobs[$count]->job_cost_record->ocd}} </td>
                                        <td> {{'$'.$jobs[$count]->job_cost_record->oct}} </td>
                                    </tr>
                                    <tr style="line-height: 40px; color: red;">
                                        <td style="width: 40%;"> Total</td>
                                        <td></td>
                                        <td> {{'$'.($jobs[$count]->job_cost_record->act+$jobs[$count]->job_cost_record->nct+$jobs[$count]->job_cost_record->sct)}} </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </li>

                        </ul>
                    @endif
                </div>
            </div>
        @endfor
    </section>
@stop

