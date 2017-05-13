@extends('layouts.main')
@section('nav')
    <p></p>
@stop
@section('content')
    <h2><span>Edit Job Cost </span></h2>
    <section id="data-viewer">
        <?php $count=0 ?>
        <div class="panel panel-default" >
            <div class='panel-heading'>
                <a id={{'data-row'}} href="#" style="display: inline-block;" >
                    <?php
                    $date=date_create($job->vac_date);
                    $date=date_format($date,"d F Y")
                    ?>
                    {{'# '.$date.' ('.$job->job_site->name.')'}}
                </a>
            </div>
            <div class="panel-body" style="display: block;">
                <ul class="list-group" style="float: left; width: 50%;">
                    <li class="list-group-item">
                        <?php
                        $date=date_create($job->updated_at);
                        $date=date_format($date,"d F Y")
                        ?>
                        <span class="data-header"> Last Update</span>
                            <span class="data-content">
                                {{$date}}
                            </span>
                    </li>
                </ul>
                <ul class="list-group" style="float: left; width: 50%;">

                    <li class="list-group-item">
                        <span class="data-header"> Cost Per Hour </span>
                        <span class="data-content"> {{'$'.$job->job_cost_record->ncp}} </span>
                        <input type="hidden" id="ncost" value="{{$job->job_site->clnCostPH}}"/>
                        <input type="hidden" id="scost" value="40"/>
                        <input type="hidden" id="acost" value="60"/>
                    </li>
                </ul>
                <ul class="list-group" style="float: left; width: 100%;">
                    @foreach($job->job_services as $js)
                        <li class="list-group-item" style="width: 100%;">
                                <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right">
                                 @if($js->room!=0)
                                        {{$js->room_id->type}}
                                    @else
                                        {{$js->rmst_id->type}}
                                    @endif
                                    {{' ( '.$js->numofrooms.' Rooms )'}}
                                </span>
                                    @if($js->room!=0)
                                        {{'Room '.$js->room_id->identifierFD}}
                                    @else
                                        {{'Room '.$js->rmst_id->identifierFD.' to '.$js->rend_id->identifierFD[2].$js->rend_id->identifierFD[3]}}
                                    @endif
                               </span>
                        </li>
                    @endforeach
                    <li class="list-group-item" style="width: 100%;background-color: #4cae4c;color:white">
                        {{ Form::open(array('url' => 'editJobCost')) }}
                        <input type="hidden" name="jobid" value="{{$job->id}}">
                        <input type="hidden" name="ncost" value="{{$job->job_cost_record->ncp}}"/>
                        <input type="hidden" name="scost" value="40"/>
                        <input type="hidden" name="acost" value="60"/>
                                  <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('hours_n',$job->job_cost_record->nch,['placeholder' => 'number of hours','style'=>'height: 30px;','required' => 'true','class' => 'input']) !!}
                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;"> Normal Clean {{'($'.$job->job_site->clnCostPH.')'}} </span>
                               </span>
                                <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('hours_n_t',$job->job_cost_record->nct,['placeholder' => 'number of hours','disabled' => 'disabled','style'=>'height: 30px;','required' => 'true','class' => 'input']) !!}

                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;"> Cost </span>
                               </span>
                                <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('hours_s',$job->job_cost_record->sch,['placeholder' => 'number of hours','style'=>'height: 30px;','required' => 'true','class' => 'input']) !!}
                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;"> Steam Clean {{'($40.00)'}} </span>
                               </span>
                                <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('hours_s_t',$job->job_cost_record->sct,['disabled' => 'disabled','style'=>'height: 30px;','required' => 'true','class' => 'input']) !!}
                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;">   </span>
                               </span>
                                <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('hours_a',$job->job_cost_record->ach,['placeholder'=> 'number of hours','style'=>'height: 30px;','required' => 'true','class' => 'input']) !!}
                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;"> Acid Wash {{'($60.00)'}} </span>
                               </span>
                                <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('hours_a_t',$job->job_cost_record->act,['disabled' => 'disabled','style'=>'height: 30px;','required' => 'true','class' => 'input']) !!}
                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;">   </span>
                               </span>
                         <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('o',$job->job_cost_record->ocd,['placeholder' => 'describe service','style'=>'height: 30px;','class' => 'input']) !!}
                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;"> Other Services </span>
                               </span>
                         <span class="data-header" style="width: 50%;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('hours_o',$job->job_cost_record->oct,['style'=>'height: 30px;','required' => 'true','class' => 'input']) !!}
                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;"> Cost  </span>
                               </span>
                     
                         <span class="data-header" style="width: 50%; float: right;">
                                <span class="data-content" style="float: right;">
                                 <div class="field-wrap">
                                     {!! Form::text('hours_total',$job->job_cost_record->act+$job->job_cost_record->nct+$job->job_cost_record->sct+$job->job_cost_record->oct,['disabled'=>'disabled','style'=>'height: 30px;','required' => 'true','class' => 'input']) !!}
                                 </div>
                                </span>
                                      <span style="color: white;line-height: 40px;"> Total Cost </span>
                               </span>
                    </li>
                </ul>
            </div>
            <div class="field-wrap">
                {!! Form::submit('Save Job Cost',['style' => 'width:100%;background-color:#a4aaae;','id' => 'add_service','class' => 'input submit']) !!}
                {{ Form::close() }}
            </div>
        </div>
    </section>
@stop

