<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Report</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }

    </style>
</head>
<body>
<div class="card">
    <div class="card-body">
        <div class="card-body">

            <div style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
                تقرير
                من {{$from}} الي {{$to}}
            </div>
            {{-- branch_irregularities--}}
            <br>
            <br>
            <div>
                <table
                    style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;width:100%">
                    <thead>
                    <tr>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            المركز
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            تقديم رخصة
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            ملاكي - نقل
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            اجره - دراجه ناريه
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            ملاكي بدون فحص
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            تصاريح + بيانات
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            قياده
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            المصروفات
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            الاجمالي
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total_private_transport = 0;
                        $total_license = 0;
                        $total_taxi_motorbike = 0;
                        $total_private_without_exam = 0;
                        $total_permissions_data = 0;
                        $total_expenses = 0;
                        $total_driving = 0;
                        $first_date = '';
                        $total_date = 0;
                    @endphp
                    @foreach($data['all_rows'] as $row)
                        @if($first_date != '')
                            @if($first_date != $row->transaction_date)
                                <tr>
                                    <td style="text-align: center" colspan="8">الاجمالي : {{$total_date}} </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center" colspan="8"> </td>
                                </tr>
                                @php
                                    $total_date = 0 ;
                                @endphp
                            @endif
                        @endif
                        @if($first_date == '' || $first_date != $row->transaction_date)
                            @php
                                $first_date = $row->transaction_date ;
                            @endphp
                            <tr>
                                <td style="text-align: center" colspan="8">{{$row->transaction_date}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="text-align: center">{{$row->State->name}}</td>
                            @php
                                $license = $row->num_license * $row->price_license ;
                                $total_license +=   $license ;
                            @endphp
                            <td style="text-align: center">{{$row->num_license}}
                                * {{$row->price_license}} = {{ $license }}</td>
                            @php
                                $private_transport = $row->num_private_transport * $row->price_private_transport ;
                                $total_private_transport +=   $private_transport ;
                            @endphp
                            <td style="text-align: center">{{$row->num_private_transport}}
                                * {{$row->price_private_transport}} = {{ $private_transport }}</td>
                            @php
                                $taxi_motorbike = $row->num_taxi_motorbike * $row->price_taxi_motorbike ;
                                $total_taxi_motorbike +=   $taxi_motorbike ;
                            @endphp
                            <td style="text-align: center">{{$row->num_taxi_motorbike}} * {{$row->price_taxi_motorbike}}
                                = {{ $taxi_motorbike }}</td>
                            @php
                                $private_without_exam = $row->num_private_without_exam * $row->price_private_without_exam ;
                                $total_private_without_exam +=   $private_without_exam ;
                            @endphp
                            <td style="text-align: center">{{$row->num_private_without_exam}}
                                * {{$row->price_private_without_exam}} = {{ $private_without_exam }}</td>
                            @php
                                $permissions_data = $row->num_permissions_data * $row->price_permissions_data ;
                                $total_permissions_data +=   $permissions_data ;
                            @endphp
                            <td style="text-align: center">{{$row->num_permissions_data}}
                                * {{$row->price_permissions_data}} = {{ $permissions_data }}</td>
                            @php
                                $driving = $row->num_driving * $row->price_driving ;
                                $total_driving +=   $driving ;
                            @endphp
                            <td style="text-align: center">{{$row->num_driving}} * {{$row->price_driving}}
                                = {{ $driving }}</td>

                            @php

                                $total_expenses +=   $row->expenses ;
                            @endphp
                            <td style="text-align: center">{{$row->expenses }}</td>
                            @php
                                $total_row = $license + $private_transport + $taxi_motorbike + $private_without_exam + $permissions_data + $driving - $row->expenses  ;
                                $total_date += $total_row ;
                            @endphp
                            <td style="text-align: center">{{ $total_row}}</td>
                        </tr>


                    @endforeach
                    @if($first_date != '')
                            <tr>
                                <td style="text-align: center" colspan="8">الاجمالي : {{$total_date}} </td>
                            </tr>
                            @php
                                $total_date = 0 ;
                            @endphp
                    @endif
                    </tbody>
                </table>
            </div>
            <br>
            <div>
                <table
                    style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;width:100%">
                    <thead>
                    <tr>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            اجمالي تقديم رخصة
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            اجمالي ملاكي - نقل
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            اجمالي اجره - دراجه ناريه
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            اجمالي ملاكي بدون فحص
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            اجمالي تصاريح + بيانات
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            اجمالي قياده
                        </th>
                        <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">
                            اجمالي المصروفات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: center">{{ $total_license }}</td>
                        <td style="text-align: center">{{ $total_private_transport }}</td>
                        <td style="text-align: center">{{ $total_taxi_motorbike }}</td>
                        <td style="text-align: center">{{ $total_private_without_exam }}</td>
                        <td style="text-align: center">{{ $total_permissions_data }}</td>
                        <td style="text-align: center">{{ $total_driving }}</td>
                        <td style="text-align: center">{{ $total_expenses }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div>
                <h5 style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
                    الاجمالي
                    : {{  $total_private_transport + $total_taxi_motorbike + $total_private_without_exam + $total_permissions_data + $total_driving + $total_license - $total_expenses }}
                </h5>
            </div>

        </div>
    </div>

</div>
<style>
    #footer {
        position: absolute;
        bottom: 0;
        height: 2.5rem; /* Footer height */
    }
</style>

<footer id="footer" class=" "
        style="font-family:DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;padding-left: 175px">
    <br>
    <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright   2021 <a
                href="#" target="_blank"
                class="text-bold-800 grey darken-2">Uram IT </a>, All rights reserved. </span><span
            class="float-md-right d-xs-block d-md-inline-block"> </span></p>
</footer>
</body>
</html>

