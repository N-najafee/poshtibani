@extends('layouts.app')
@section('title',"index")

@section('content')
    <div class="container-fluid">
            <main role="main" class="col-12 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>مدیریت کاربران و تیکت ها</h1>
                </div>
                <h4>لیست موضوعات</h4>
                <a href="{{route('admin.create.subject')}}" class="btn btn-outline-primary ms-1 mt-3 mb-3"><i class="fa fa-lg fa-plus"></i> ایجاد موضوع  </a>
                <div class="table-responsive">
                    <table class="table table-bordered  text-center">
                        <thead >
                        <tr>
                            <th>ردیف</th>
                            <th>موضوعات</th>
                            <th>توضیحات</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($subjects)>0)
                        @foreach($subjects as $key=>$subject)
                        <tr class="{{$subject->trashed() ? "text-danger" : ""}}">
                            <td>{{$key + 1}}</td>
                            <td>{{$subject->subject}}</td>
                            <td>{{$subject->description}}</td>
                            <td class="d-flex justify-content-center">
                                <a href="{{route('admin.edit.subject',['ticket'=>$subject->id])}}" class="btn btn-outline-primary ms-1">ویرایش</a>
                                <form action="{{route('admin.destroy.subject',['subject'=>$subject->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger ms-1">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <h4>لیست کاربران</h4>
                <div class="table-responsive">
                    <a href="{{route('admin.create.user')}}" class="btn btn-outline-primary ms-1 mt-3 mb-3"><i class="fa fa-lg fa-plus"></i> ایجاد</a>
                    <table class="table table-striped table-bordered  text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کاربر</th>
                            <th>ایمیل</th>
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
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role}}</td>
                                    <td><span class="{{$user->getraworiginal('is_active') ? "text-success" : "text-danger"}}">{{$user->is_active}}</span></td>
                                    <td>
                                        <a href="{{route('admin.edit.user',['user'=>$user])}}" class="btn btn-outline-primary ms-1">ویرایش</a>
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
                    <table class="table  table-bordered  text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>موضوع</th>
                            <th>تعداد پاسخ ها</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($tickets)>0)
                            @foreach($tickets as $key=>$ticket)
                                <tr class="{{$ticket->trashed() ? "text-danger" : ""}}">
                                    <td>{{$key + 1}}</td>
                                    <td>{{$ticket->title}}</td>
                                    <td>{{$ticket->trashed() ? "" : $ticket->parent->subject}}</td>
                                    <td>{{count($ticket->responses_methode)}}</td>
                                    <td>{{$ticket->status}}</td>
                                    <td>
                                        <a href="{{route('admin.ticket.show',['ticket'=>$ticket->id])}}" class="btn btn-outline-primary ms-1 {{$ticket->deleted_at ? 'disabled btn-outline-danger' : ''}}">نمایش</a>
                                        <a href="{{route('admin.ticket.edit',['ticket'=>$ticket->id])}}" class="btn btn-outline-primary ms-1  {{$ticket->deleted_at ? 'disabled btn-outline-danger' : ''}}">مدیریت تیکت ها</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <div class="alert alert-danger" role="alert">
                                تیکتی  وجود ندارد
                            </div>
                        @endif
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
@endsection
