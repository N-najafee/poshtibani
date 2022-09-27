@extends('layouts.app')
@section('title',"index")

@section('content')
    <div class="col-12 mt-5">
        <div class="row ">
            <div class="col-6">
                <h4>لیست تیکت ها </h4>
            </div>
            <hr>
        </div>
        <div class="col-12">
            <table class="table table-bordered  text-center">
                <tr>
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>موضوع</th>
                    <th>پیوست</th>
                    <th>تعداد پاسخ</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                @foreach($tickets as $key=>$ticket)
                    <tr class="{{$ticket->deleted_at ? 'text-danger' : ''}}">
                        <td>{{$tickets->firstitem()+$key}}</td>
                        <td>{{$ticket->title}}</td>
                        <td><span {{$ticket->trashed() ? 'text-danger' : ''}}>{{$ticket->parent->subject}}</span></td>
                        <td><a href="{{url(env('UPLOAD_FILE').$ticket->attachment)}}" target="_blank">{{$ticket->attachment}}</a></td>
                        <td>{{count($ticket->responses_methode)}}</td>
                        <td>{{$ticket->status}}</td>
                        <td class="d-flex justify-content-center btn-group btn-group-justified">
                            @if($ticket->getraworiginal('status') === \App\Http\Consts\Ticketconsts::CLOSE)
                                <a href="{{route('poshtiban.response.create',['ticket'=>$ticket->id])}}" class="btn btn-outline-primary ms-5 me-5  {{$ticket->deleted_at ? 'disabled btn-outline-danger' : ''}}">  نمایش پاسخ</a>
                            @else
                                <a href="{{route('poshtiban.response.create',['ticket'=>$ticket->id])}}" class="btn btn-outline-primary ms-5 me-5  {{$ticket->deleted_at ? 'disabled btn-outline-danger' : ''}}"> پاسخ</a>
                            @endif
                            <div class="dropdown ">
                                <button class="btn btn-outline-primary dropdown-toggle ms-5  {{$ticket->deleted_at ? 'disabled btn-outline-danger' : ''}}" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    تغییر وضعیت تیکت ها
                                </button>
                                <ul class="dropdown-menu">
                                    <form action="{{route('poshtiban.response.update',['ticket'=>$ticket->id])}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="submit" class="dropdown-item fw-bold {{$ticket->getraworiginal('status') === \App\Http\Consts\Ticketconsts::OPEN ? 'disabled' : " "}}" name="status[{{\App\Http\Consts\Ticketconsts::OPEN}}]" value="باز">
                                        <input type="submit" class="dropdown-item fw-bold {{$ticket->getraworiginal('status') === \App\Http\Consts\Ticketconsts::COMPLETED ? 'disabled' : " "}}" name="status[{{\App\Http\Consts\Ticketconsts::COMPLETED}}]" value="پاسخ داده شده">
                                        <input type="submit" class="dropdown-item fw-bold {{$ticket->getraworiginal('status') === \App\Http\Consts\Ticketconsts::CLOSE ? 'disabled' : " "}}" name="status[{{\App\Http\Consts\Ticketconsts::CLOSE}}]" value="بسته">
                                    </form>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="mt-5 col-12">
            <div class="row justify-content-center p-5">
                <div class="col-4">
                    {{$tickets->render()}}
                </div>
            </div>
        </div>

    </div>

@endsection
