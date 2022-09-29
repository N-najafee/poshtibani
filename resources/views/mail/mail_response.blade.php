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
        <table class="col-6">
            <thead>
            <tr>
                <td>
                    <h2>سلام کاربر گرامی!</h2>
                    <h3> یک پاسخ با مشخصات زیر برای تیکت شما ارسال شده است.</h3>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>
                    <div class="card">
                        <div class="card-header">
                            <h4> عنوان تیکت : {{$response->ticket->title}} </h4>
                            <h4> تاریخ ایجاد : <i class="fa fa-clock"></i> {{$response->created_at}}</h4>
                            <h4>  تیکت : {{$response->ticket->description}} </h4>
                        </div>
                        <div class="card-body">
                            <span>پاسخ تیکت :</span>
                            <p class="card-text">{{$response->description}}</p>
                        </div>
                    </div>
                    <h4 class="mt-4">
                        <a href="{{url('login')}}">جهت مشاهده </a>
                    </h4>
                </th>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
