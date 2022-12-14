@extends('layouts.app')
@section('title','index')
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
                    <h3>تیکت {{ $ticket->title }} </h3>
                </div>
                <hr>
            </div>
            <!-- end top list -->
        @include('files.error')
        <!-- main body -->
            <div class="col-8 m-4">
                <div class="card">
                    <div class="card-header">
                        <h4> موضوع : {{$ticket->subject->name}} </h4>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"> عنوان تیکت : {{$ticket->title}} </h4>
                        <span>توضیحات تیکت :</span>
                        <p class="card-text">{{$ticket->description}}</p>
                        <h5>تیکت در وضعیت <span class="text-info">{{$ticket->status}}</span> می باشد. </h5>
                        <a href="{{route('response.index')}}" class="btn btn-outline-dark">بازگشت</a>
                    @if($ticket->attachment)
                                    <button type="button" class="btn btn-outline-primary m-2 ms-5"
                                            data-bs-toggle="modal"
                                            data-bs-target="#Modal_{{$ticket->id}}">
                                        مشاهده فایل
                                    </button>
                                    <div class="modal fade" id="Modal_{{$ticket->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        بستن
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                        @if($ticket->getraworiginal('status') !== \App\Http\Consts\Ticketconsts::CLOSE)
                                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                                        پاسخ به سوال
                                    </button>
                                    <div class="collapse collapse-horizontal" id="collapseWidthExample">
                                        <form action="{{route('response.store',['ticket'=>$ticket->id])}}" method="post">
                                            @csrf
                                            <textarea class="card card-body mt-3" name="text" cols="105"
                                                      rows="5">{{old('text')}}</textarea>
                                            <button class="btn btn-outline-primary mt-2">ارسال</button>
                                        </form>
                                    </div>
                        @endif
                                </div>
                            </div>
                            <div class="card bg-light p-2 list-inline">
                                <h3 class="card-title "> پاسخ ها: </h3>
                                @if(count($ticket->responses)>0)
                                    @foreach($ticket->responses->chunk(2)->first() as $key=>$response)
                                        <h4 class="{{$loop->first ? 'text-info' : ''}}"> {{$key+1}} _ پاسخ داده شده توسط
                                            {{$response->user_response->role}} : {{$response->user_response->name}}</h4>
                                        <h4 class="{{$loop->first ? 'text-info' : ''}}"><i
                                                class="fa fa-clock {{$loop->first ? 'text-info' : ''}}"></i> {{$response->created_at}}
                                        </h4>
                                        <h5 class="p-2 {{$loop->first ? 'text-info' : ''}}">   {{$response->description}}</h5>
                                        <hr>
                                    @endforeach
                                    <button class="btn btn-outline-info  text-dark" onclick="show_response()"> مشاهده
                                        پاسخ های بیشتر
                                    </button>
                                @endif
                                @if(count($ticket->responses->slice(2))>0)
                                    <div id="more" class="hid mt-3">
                                        @foreach($ticket->responses->slice(2) as $key=>$response)

                                            <h4>{{$key+1}} _ پاسخ داده شده توسط
                                                {{$response->user_response->role}} : {{$response->user_response->name}}</h4>
                                            <h4><i class="fa fa-clock"></i> {{$response->created_at}}</h4>
                                            <h5 class="p-2 text-muted">  {{$response->description}}</h5>
                                            <hr>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
@endsection
