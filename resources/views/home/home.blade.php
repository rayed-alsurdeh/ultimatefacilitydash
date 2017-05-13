@extends('layouts.main')
@section('nav')
    <p></p>
@stop
@section('content')
    <h2>Sites</h2>
    <section id="data-viewer">
        <?php $count=0 ?>
        @for($count=0;$count<count($sites);$count++)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a id={{'data-row'.$count}} href="#" style="display: inline-block;">{{$sites[$count]->name}} </a>
                    <div class="btn-group" style="height: 100%; float: right;">
                        <button type="button" class="btn btn-primary">Site Actions</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="addsite">Manage Site</a>
                            <a class="dropdown-item" href="{{'/addjob?siteid='.$sites[$count]->id}}"> New Job</a>
                            @if(count($sites[$count]->site_jobs->where('status','==','6')) > 0)
                                <a class="dropdown-item" href="/genrateInvoice?siteid={{$sites[$count]->id}}">Generate Invoice</a>
                            @endif
                            <a class="dropdown-item" href="#">Job Reports</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="data-header"> Location </span>
                           <span class="data-content">
                                {{$sites[$count]->site_state->name .', '.$sites[$count]->city .', ' .$sites[$count]->suburb}}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> Address </span>
                            <span class="data-content"> {{$sites[$count]->address}} </span>
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> Supervisor </span>
                           <span class="data-content">
                           <a href="#" id={{'site_sup_'.$sites[$count]->site_sup->id}}>
                               {{$sites[$count]->site_sup->fullname}} </a>
                            </span>
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> Cost </span>
                           <span class="data-content">
                           <?php
                               setlocale(LC_MONETARY, 'en_US');
                               echo "AUD$ ".number_format($sites[$count]->clnCostPH, 2);
                               ?>
                             </span>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="data-header"> Number of Rooms </span>
                       <span class="data-content">
                         {{count($sites[$count]->site_rooms)}}
                        </span>
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> Number of Jobs </span>
                       <span class="data-content">
                       @if(count($sites[$count]->site_jobs) > 0)
                               <a style="font-weight: bold;" href="jobs?siteid={{$sites[$count]->id}}"> {{count($sites[$count]->site_jobs)}} </a>
                           @else
                               {{count($sites[$count]->site_jobs)}}
                           @endif
                       </span>
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> Active Jobs </span>
                       <span class="data-content">
                        {{count($sites[$count]->site_jobs->where('status','!=','6'))}}
                       </span>
                        </li>
                        <li class="list-group-item">
                            <span class="data-header"> Total Revenue </span>
                       <span class="data-content">  AUD$
                           <?php $totalrev=0; ?>
                           @foreach($sites[$count]->site_jobs as $job )
                               @if($job->job_cost_record!=null)
                                   <?php $totalrev=$totalrev+$job->job_cost_record->nct+$job->job_cost_record->act+
                                           $job->job_cost_record->sct+$job->job_cost_record->oct; ?>
                               @endif
                           @endforeach
                           {{$totalrev}}
                       </span>
                        </li>
                    </ul>
                </div>
            </div>
        @endfor
    </section>

@stop
