<!DOCTYPE html>
<html lang="en">
<head>

{{--    <meta charset="utf-8">--}}
{{--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>--}}

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Report</title>


    <link rel="shortcut icon" type="image/png" href="{{url('public/app-assets/images/ico/ico.jpg')}}">
    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"--}}
    {{--          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{url('public/app-assets/css/bootstrap.css')}}"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/bootstrap.css')}}">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/colors.css')}}">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="{{url('public/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{url('public/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/core/colors/palette-gradient.css')}}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('public/assets/css/style.css')}}">
    <style>
        table, th, td {
            border: 1px solid black;
        }

    </style>
</head>

<body>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div>

                <h4 class="card-title"
                    style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;"> كشف حساب للفرع {{$branch->name}} </h4>

                <h5  style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
                    اجمالى المدين {{$debit}}

                </h5>
                <h5  style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
                    اجمالى دائن {{$creditor}}


                </h5>
                <h5  style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
                      رصيد مدين {{$total_debit}}


                </h5>
                <h5  style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
                      رصيد دئن {{$total_creditor}}


                </h5>
            </div>

        </div>
    </div>


    <div class="card-body">


        <div style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
            <h4 class="card-title"> المخالفات المحررة </h4>
        </div>

        {{-- branch_irregularities--}}
        <div>
            <table
                style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;width:100%">
                <thead>
                <tr>

                    <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center"> الوصف

                    </th>
                    <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center"> نسبة
                        المخالفه
                    </th>
                    <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center"> قيمه
                        المخالفه
                    </th>
                    <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center"> اسم
                        المخالفه
                    </th>
                    <th style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align:center">#</th>


                </tr>
                </thead>
                <tbody>
                @php
                    $id = 1;
                @endphp

                @foreach($branch_irregularities as $temp)
                    <tr>
                         <td>{{$temp->desc}}</td>
                        <td>{{$temp->percentage}}</td>
                        <td>{{$temp->value}}</td>
                        <td>{{$temp->name}}</td>
                        <th scope="row">{{$id}}</th>


                    </tr>
                    @php
                        $id++;
                    @endphp

                @endforeach

                </tbody>

            </table>

        </div>


        <div style="padding-top: 25px"></div>


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

