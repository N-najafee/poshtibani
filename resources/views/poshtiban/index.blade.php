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
            <table class="table table-bordered table-striped text-center">
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
                    <tr>
                        <td>{{$tickets->firstitem()+$key}}</td>
                        <td>{{$ticket->title}}</td>
                        <td>{{$ticket->parent->subject}}</td>
                        <td><a href="{{url(env('UPLOAD_FILE').$ticket->attachment)}}" target="_blank">{{$ticket->attachment}}</a></td>
                        <td class="">{{count($ticket->responses_methode)}}</td>
                        <td class="">{{$ticket->status}}</td>
                        <td class="d-flex justify-content-center btn-group btn-group-justified">
                            @if($ticket->getraworiginal('status') === \App\Models\Ticket::CLOSE)
                                <a href="{{route('poshtiban.create.response',['ticket'=>$ticket->id])}}" class="btn btn-outline-primary ms-5 me-5">  نمایش پاسخ</a>
                            @else
                                <a href="{{route('poshtiban.create.response',['ticket'=>$ticket->id])}}" class="btn btn-outline-primary ms-5 me-5"> پاسخ</a>
                            @endif
                            <div class="dropdown ">
                                <button class="btn btn-outline-primary dropdown-toggle ms-5" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    تغییر وضعیت تیکت ها
                                </button>
                                <ul class="dropdown-menu">
                                    <form action="{{route('poshtiban.change.status',['ticket'=>$ticket->id])}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="submit" class="dropdown-item fw-bold {{$ticket->getraworiginal('status') === \App\Models\Ticket::OPEN ? 'disabled' : ""}}" name="status[{{\App\Models\Ticket::OPEN}}]" value="باز">
                                        <input type="submit" class="dropdown-item fw-bold {{$ticket->getraworiginal('status') === \App\Models\Ticket::COMPLETED ? 'disabled' : ""}}" name="status[{{\App\Models\Ticket::COMPLETED}}]" value="پاسخ داده شده">
                                        <input type="submit" class="dropdown-item fw-bold {{$ticket->getraworiginal('status') === \App\Models\Ticket::CLOSE ? 'disabled' : ""}}" name="status[{{\App\Models\Ticket::CLOSE}}]" value="بسته">
                                    </form>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

    </div>

@endsection
