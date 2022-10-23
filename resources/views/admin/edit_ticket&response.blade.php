@extends('layouts.app')
@section('title','edit ticket')
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
        @include('files.error')
        <!-- top list -->
            <div class="row justify-content-between">
                <div class="col-6 text-end">
                    <h3>تیکت {{ $ticket->title }} </h3>
                </div>
                <hr>
            </div>
            <!-- end top list -->
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
                        <a href="{{route('admin.index')}}" class="btn btn-outline-dark">بازگشت</a>
                        @if($ticket->attachment)
                            <button type="button" class="btn btn-outline-primary m-2 ms-5"
                                    data-bs-toggle="modal"
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
                                                         src="{{(url(env('UPLOAD_FILE').$ticket->attachment))}}"
                                                         alt="img">
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
                        <form action="{{route('ticket.destroy',['ticket'=>$ticket->id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger col-3 mt-3">حذف</button>
                        </form>
                    </div>
                </div>
                <div class="card bg-light p-2 list-inline">
                    <h3 class="card-title"> پاسخ ها: </h3>
                    @if(count($ticket->responses)>0)
                        @foreach($ticket->responses->chunk(2)->first() as $key=>$response)
                            <form action="{{route('ticket.update',['ticket'=>$ticket->id])}}" method="post">
                                @csrf
                                @method('PUT')
                                <h4 class="{{$loop->first ? 'text-info' : ''}}"> {{$key+1}} _ پاسخ داده شده توسط
                                    {{$response->user->role}}: {{$response->user->name}}</h4>
                                <h4 class="{{$loop->first ? 'text-info' : ''}}"><i
                                        class="fa fa-clock {{$loop->first ? 'text-info' : ''}}"></i> {{$response->created_at}}
                                </h4>
                                <label></label>
                                <textarea class="p-2 form-control {{$loop->first ? 'text-info' : ''}}"
                                          name="response[{{$response->id}}]"> {{$response->description}} </textarea>
                                <button class="btn btn-outline-primary mt-3">ویرایش</button>
                            </form>
                            <hr>
                        @endforeach
                        <button class="btn btn-outline-info  text-dark" onclick="show_response()"> مشاهده پاسخ های
                            بیشتر
                        </button>
                    @endif
                    @if(count($ticket->responses->slice(2))>0)
                        <div id="more" class="hid mt-3">
                            @foreach($ticket->responses->slice(2) as $key=>$response)
                                <form action="{{route('ticket.update',['ticket'=>$ticket->id])}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <h4>{{$key+1}} _ پاسخ داده شده توسط
                                        {{$response->user->role}}: {{$response->user->name}}</h4>
                                    <h4><i class="fa fa-clock"></i> {{$response->created_at}}</h4>
                                    <label></label>
                                    <textarea class="p-2 form-control text-muted"
                                              name="response[{{$response->id}}]">  {{$response->description}} </textarea>
                                    <button class="btn btn-outline-primary mt-3">ویرایش</button>
                                </form>
                                <hr>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
