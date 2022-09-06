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
                تقرير المركز
                <h4 class="card-title"> {{$state->name}} </h4>
                من {{$from}}  الي   {{$to}}
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
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: center">{{$data['sum_price_private_transport']}}</td>
                        <td style="text-align: center">{{$data['sum_price_taxi_motorbike']}}</td>
                        <td style="text-align: center">{{$data['sum_price_private_without_exam']}}</td>
                        <td style="text-align: center">{{$data['sum_price_permissions_data']}}</td>
                        <td style="text-align: center">{{$data['sum_price_driving']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div>
                <h5 style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
                    الاجمالي {{$data['total']}}
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

