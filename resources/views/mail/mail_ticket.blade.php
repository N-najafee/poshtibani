<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="container col-8 mt-5">
    <div class="row justify-content-center">
        <table class="col-8">
            <thead>
            <tr>
                <td>
                    <h2>سلام پشتیبان گرامی!</h2>
                    <h3> یک تیکت با مشخصات زیر برای شما جهت بررسی و پاسخ ارسال شده است.</h3>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>
                    <div class="card">
                        <div class="card-header">
                            <h4> موضوع : {{$ticket->subject->name}} </h4>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"> عنوان تیکت : {{$ticket->title}} </h4>
                            <h4> تاریخ ایجاد : <i class="fa fa-clock"></i> {{$ticket->created_at}}</h4>
                            <span>توضیحات تیکت :</span>
                            <p class="card-text">{{$ticket->description}}</p>
                        </div>
                    </div>
                    <h4 class="mt-4">
                        <a href="{{url('login')}}">جهت پاسخ </a>
                    </h4>
                </th>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
