@extends('layouts.app')
@section('title',"index")

@section('content')
    <div class="container-fluid">
            <main role="main" class="col-12 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">داشبورد</h1>
                </div>
                <h4>لیست موضوعات</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered  text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>موضوعات</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($subjects)>0)
                        @foreach($subjects as $key=>$subject)
                        <tr>
                            <td>{{$subjects->firstitem()+$key}}</td>
                            <td>{{$subject->subject}}</td>
                            <td>
                                <a href="" class="btn btn-outline-primary ms-1">ایجاد</a>
                                <a href="" class="btn btn-outline-primary ms-1">ویرایش</a>
                                <a href="" class="btn btn-outline-primary ms-1">حذف</a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <div class="alert alert-danger" role="alert">
                           موضوع برای نمایش وجود ندارد
                        </div>
                        @endif
                        </tbody>
                    </table>
                </div>
                <h4>لیست کاربران</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered  text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کاربر</th>
                            <th>نقش</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($users)>0)
                            @foreach($users as $key=>$user)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>{{$user->is_active}}</td>
                                    <td>
                                        <a href="" class="btn btn-outline-primary ms-1">ویرایش</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <div class="alert alert-danger" role="alert">
                               کاربری وجود ندارد
                            </div>
                        @endif
                        </tbody>
                    </table>
                </div>
                <h4>لیست تیکت ها</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered  text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>موضوع</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($tickets)>0)
                            @foreach($tickets as $key=>$ticket)
                                <tr>
                                    <td>{{$tickets->firstitem()+$key}}</td>
                                    <td>{{$ticket->title}}</td>
                                    <td>{{$ticket->subject}}</td>
                                    <td>{{$ticket->status}}</td>
                                    <td>
                                        <a href="" class="btn btn-outline-primary ms-1">نمایش</a>
                                        <a href="" class="btn btn-outline-primary ms-1">ویرایش</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <div class="alert alert-danger" role="alert">
                                کاربری وجود ندارد
                            </div>
                        @endif
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
@endsection
