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
    <link rel="stylesheet" href="{{ asset('/css/invoice.css') }}">
</head>
<body>
<section id="wrapper">
    <h2> ULTIMATE FACILITY SERVICES</h2>
    <section id="company-info">
        <img src={{asset('img/invoice-logo.jpg')}} alt="Logo">
        <section id="info">
         <h3> Tax Invoice </h3>
        <span class="invoice-info highlight"> ABN:20 840 784 791 </span>
        <span class="invoice-info"> Unit 1- 79 Gladstone st, Fyshwick, 2609  </span>
        <span class="invoice-info"> GPO Box 778 - CANBERRA ACT 2600 </span>
        <span class="invoice-info highlight"> P: 1300 322 222 </span>
        <span class="invoice-info highlight"> M: 0404 105 105 </span>
        <span class="invoice-info"> E-mail: <a href="#"> wally@ultimatefacility.com.au </a> </span>
        <span class="invoice-info"> Web Site: <a href="#"> www.ultimatefacility.com.au </a> </span>
        </section>
    </section>
    <section style="width: 100%;clear: both; overflow: auto;">
        <section style="width: 100%; float: left; clear: both;">
            <span class="invoice-info left highlight"> Invoice #  </span>
            <span class="invoice-info left">
                 <?php
                $date= Carbon\Carbon::now();
                $date=date_format($date,"l jS \\of F Y")
                ?>
                <b>Date</b>:	{{$date}}  </span>
        </section>
    </section>
    <section style="width: 100%;clear: both; overflow: auto;">
        <section style="width: 100%; float: left; clear: both;">
            <span class="invoice-info left highlight"> BILL TO:   </span>
            <span class="invoice-info left"> {{$site->name}}  </span>
            <span class="invoice-info left"> {{$site->address}}  </span>
        </section>
    </section>
    <section style="width: 100%;clear: both; margin-top: 20px; overflow: auto;">
        <table id="data-table" width="100%" border="1">
            <thead>
            <tr>
                <th> JOB DESCRIPTION </th>
                <th> Amount </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <span style="display: block; width: 100%;"> Charge due to the room cleaning: </span>
                @foreach($site->site_jobs as $job)
                    @if($job->status==6)
                            <?php
                            $date=date_create($job->finished_at);
                            $date=date_format($date ,"d-F-Y")
                            ?>
                        <span style="display: block; width: 100%; line-height: 30px;"> {{$date}} </span>
                    @endif
                @endforeach
                </td>
                <td>
                    <span style="display: block; width: 100%;">  </span>
                    <?php $total=0 ?>
                    @foreach($site->site_jobs as $job)
                        @if($job->status==6)
                            <span style="display: block; width: 100%; line-height: 30px;">
                            {{'$'.($job->job_cost_record->act+$job->job_cost_record->nct+$job->job_cost_record->sct)}}
                                <?php $total=$total+($job->job_cost_record->act+$job->job_cost_record->nct+$job->job_cost_record->sct); ?>
                            </span>
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    <b> Total </b>
                </td>
                <td>
                    <?php echo '<b>$'.$total.'</b>' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    <b> G.S.T. </b>
                </td>
                <td>
                    <?php echo '<b>$'.($total*0.1).'</b>' ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    <b> Total incl G.S.T. </b>
                </td>
                <td>
                    <?php echo '<b>$'.($total+($total*0.1)).'</b>' ?>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
    <section id="account-info">
            <h6> Payment Direct Deposit  </h6>
             <span class="invoice-info left small"> <b>Bank</b>: ANZ</span>
             <span class="invoice-info left small"><b>A/C Name </b>: Ultimate Facility Services pty ltd </span>
             <span class="invoice-info left small"> <b>BSB </b>: 012 950  </span>
             <span class="invoice-info left small"> <b>A/C Number</b>: 182 380 808  </span>
    </section>
    <h4 style="text-align: center; margin-top: 30px; font-weight: bold;">THANK YOU FOR YOUR BUSINESS!</h4>
</section>

</body>