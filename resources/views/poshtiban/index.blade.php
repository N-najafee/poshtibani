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
                    <th>توضیحات</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                @foreach($tickets as $key=>$ticket)
                    <tr>
                        <td>{{$tickets->firstitem()+$key}}</td>
                        <td>{{$ticket->title}}</td>
                        <td>{{$ticket->subject}}</td>
                        <td>{{$ticket->description}}</td>
                        <td class="">{{$ticket->status}}</td>
                           <td class="d-flex justify-content-center ">
                               @if($ticket->status === "باز")
                               <a href="{{route('poshtiban.create',['ticket'=>$ticket->id])}}" class="btn btn-outline-primary ms-1">   پاسخ</a>
                               @elseif($ticket->status === "پاسخ داده شده")
                                   <a href="{{route('poshtiban.create',['ticket'=>$ticket->id])}}" class="btn btn-outline-primary ms-1">   پاسخ</a>
                               @else
                                   <a href="" class="btn btn-outline-primary ms-1"> نمایش پاسخ</a>
                               @endif
                               <div class="dropdown">
                                   <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      تغییر وضعیت
                                   </button>
                                   <ul class="dropdown-menu">
                                       <li><a class="dropdown-item" href="#">باز</a></li>
                                       <li><a class="dropdown-item" href="#">بسته</a></li>
                                       <li><a class="dropdown-item" href="#">پاسخ داده شده</a></li>
                                   </ul>
                               </div>
                           </td>
                    </tr>
                @endforeach
            </table>
        </div>

    </div>

@endsection
