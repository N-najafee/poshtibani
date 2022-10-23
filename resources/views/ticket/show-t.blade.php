@extends('layouts.app')
@section('title','show ticket')

@section('script')
    <script>
        $(`.test`).click(function () {
            let ticketId = $(`.test`).val();
        $.get(`{{url('get_ticket/${ticketId}')}}`,function (response){
            console.log(response);
        });
        });
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row justify-content-between ">
                <div class="col-6 text-end">
                    <h3>لیست تیکت ها </h3>
                </div>
                <div class="col-6 text-start">
                    <a href="{{route('ticket.create')}}"><h3 class="btn btn-outline-primary">ایجاد تیکت <i
                                class="fa fa-lg fa-plus"></i></h3></a>
                </div>
                <hr>
            </div>
             <div class="col-8 m-4">
                    <div class="card">
                        <div class="card-header">
                            <h4> موضوع : {{$ticket->subject->name}} </h4>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"> عنوان تیکت : {{$ticket->title}} </h4>
                            <h4> تاریخ ایجاد : <i class="fa fa-clock"></i> {{$ticket->created_at}}</h4>
                            @if($ticket->deleted_at)
                            <h4 class="text-danger"> تاریخ حذف  :<i class="fa fa-clock text-danger"></i> {{$ticket->deleted_at}}</h4>
                            @endif
                            <span>توضیحات تیکت :</span>
                            <p class="card-text">{{$ticket->description}}</p>
                        @if($ticket->attachment)
                                <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal"
                                        data-bs-target="#Modal_{{$ticket->id}}">
                                    مشاهده فایل
                                </button>
                                <div class="modal fade" id="Modal_{{$ticket->id}}" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex">
                                                <h5 class="modal-title"
                                                    id="exampleModalLabel">{{$ticket->attachment}}</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-img">
                                                    <div class="card-img-top">
                                                        <img style="width: 450px; height:250px"
                                                             src=" {{(url(env('UPLOAD_FILE').$ticket->attachment))}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    بستن
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <h5>تیکت در وضعیت <span class="text-info">{{$ticket->status}}</span> می باشد. </h5>
                        </div>
                        <!-- end Modal -->
                        <div class="card bg-light p-2 list-inline">
                            <h3 class="card-title "> پاسخ ها: </h3>
                            @if(count($ticket->responses)>0)
                                @foreach($ticketFirstResponse as $key=>$response)
                                    <h4 class="{{$loop->first ? "text-info" : ""}}"> _ پاسخ داده شده توسط
                                        : {{$response->user->name}}</h4>
                                    <h4 class="{{$loop->first ? "text-info" : ""}}"><i
                                            class="fa fa-clock {{$loop->first ? "text-info" : ""}}"></i> {{$response->created_at}}
                                    </h4>
                                    <h5 class="p-2 {{$loop->first ? "text-info" : ""}}">   {{$response->description}}</h5>
                                    <hr>
                                @endforeach
                            @endif
                            @if($ticket->HasMoreResponse())
                                <button class="btn btn-outline-info  text-dark test" value="{{$ticket->id}}"> مشاهده
                                    پاسخ
                                    های بیشتر
                                </button>
                                @foreach($ticketLastResponse as $key=>$response)
                                <h4>{{$key+1}} _ پاسخ داده شده توسط : {{$response->user->name}}</h4>
                                <h4><i class="fa fa-clock"></i> {{$response->created_at}}</h4>
                                <h5 class="p-2 text-muted">  {{$response->description}}</h5>
                                <hr>
                                @endforeach
                            @endif
                        </div>
                    </div>
                 <a class="btn btn-outline-dark mt-3" href="{{route('home')}}" >بازگشت</a>
             </div>
        </div>

@endsection
