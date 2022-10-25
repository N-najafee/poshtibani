@extends('layouts.app')
@section('title',"admin_index")

@section('content')
    <div class="container-fluid">
        <main role="main" class="col-12 px-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1>لیست تیکت ها</h1>
                <div class="col-6 text-start">
                    <a href="{{route('ticket.create')}}"><h3 class="btn btn-outline-primary">ایجاد تیکت <i
                                class="fa fa-lg fa-plus"></i></h3></a>
                </div>
            </div>

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
                            <tr class="{{$ticket->deleted_at ? 'text-danger' : ''}}">
                                <td>{{$key + 1}}</td>
                                <td>{{$ticket->title}}</td>
                                <td>{{$ticket->subject->name}}</td>
                                <td>{{($ticket->responses_count)}}</td>
                                <td>{{$ticket->status}}</td>
                                <td>
                                    <a href="{{route('ticket.show',['ticket'=>$ticket->id])}}"
                                       class="btn btn-outline-primary ms-1 {{$ticket->deleted_at ? 'disabled btn-outline-danger' : ''}}">نمایش</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <div class="alert alert-danger" role="alert">
                            تیکتی وجود ندارد
                        </div>
                    @endif
                    </tbody>
                </table>
            </div>
        </main>
        <div class="mt-5 col-12">
            <div class="row justify-content-center p-5">
                <div class="col-4">
                    {{$tickets->render()}}
                </div>
            </div>
        </div>
    </div>
@endsection
