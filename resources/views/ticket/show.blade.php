@extends('layouts.app')
@section('title','show ticket')
@section('style')
    <style>
        .hid {
            display: none;
        }

        .show {
            display: block;
        }
    </style>
@endsection
@section('script')
    <script>

        let more_responses = document.getElementById('more');

        function show_response() {
            more_responses.classList.toggle('show');
            more_responses.classList.toggle('hid');
        }
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <!-- top list -->
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
            <!-- end top list -->

            <!-- main body -->

            @foreach($tickets as  $ticket)
                <div class="col-8 m-4">
                    <div class="card">
                        <div class="card-header">
                            <h4> موضوع : {{$ticket->parent->subject}} </h4>
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
                            @if(count($ticket->responses_methode)>0)
                                @foreach($ticket->responses_methode->chunk(2)->first() as $key=>$response)
                                    <h4 class="{{$loop->first ? "text-info" : ""}}"> {{$key+1}} _ پاسخ داده شده توسط
                                        : {{$response->user_response->name}}</h4>
                                    <h4 class="{{$loop->first ? "text-info" : ""}}"><i
                                            class="fa fa-clock {{$loop->first ? "text-info" : ""}}"></i> {{$response->created_at}}
                                    </h4>
                                    <h5 class="p-2 {{$loop->first ? "text-info" : ""}}">   {{$response->description}}</h5>
                                    <hr>
                                @endforeach
                                <button class="btn btn-outline-info  text-dark" onclick="show_response()"> مشاهده پاسخ
                                    های بیشتر
                                </button>
                            @endif
                            @if(count($ticket->responses_methode->slice(2))>0)
                                <div id="more" class="hid mt-3">
                                    @foreach($ticket->responses_methode->slice(2) as $key=>$response)
                                        <h4>{{$key+1}} _ پاسخ داده شده توسط : {{$response->user_response->name}}</h4>
                                        <h4><i class="fa fa-clock"></i> {{$response->created_at}}</h4>
                                        <h5 class="p-2 text-muted">  {{$response->description}}</h5>
                                        <hr>
                                    @endforeach
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-5 col-12">
                <div class="row justify-content-center p-5">
                    <div class="col-4">
                        {{$tickets->render()}}
                    </div>
                </div>
                <!-- end main body -->
            </div>
        </div>

@endsection
