@extends('layouts.app')
@section('title','index')

@section('script')

@endsection
@section('content')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="row justify-content-between ">
                        <div class="col-6 text-end">
                            <h3>لیست تیکت ها    </h3>
                        </div>
                        <div class="col-6 text-start">
                            <a href="{{route('ticket.create')}}">  <h3 class="btn btn-outline-primary">ایجاد تیکت  <i class="fa fa-lg fa-plus"></i></h3></a>
                        </div>
                        <hr>
                    </div>
                    @foreach($tickets as  $ticket)
                        @if($ticket->check_user)
            <div class="col-8 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4> موضوع تیکت :  {{$ticket->subject}} </h4>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">  عنوان تیکت : {{$ticket->title}} </h4>
                        <span>توضیحات تیکت :</span>
                        <p class="card-text">{{$ticket->description}}</p>
                        <!-- Button trigger modal -->
                        <div>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$ticket->id}}">
                            مشاهده وضعیت
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal_{{$ticket->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header d-flex">
                                        <h5 class="modal-title" id="exampleModalLabel">{{$ticket->title}}</h5>
                                    </div>
                                    <div class="modal-body">
                                        <h5>تیکت در وضعیت <span class="text-info">{{$ticket->status}}</span> می باشد. </h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @if($ticket->attachment)
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Modal_{{$ticket->id}}">
                                    مشاهده فایل
                                </button>

                            <div class="modal fade" id="Modal_{{$ticket->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex">
                                            <h5 class="modal-title" id="exampleModalLabel">{{$ticket->attachment}}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-img">
                                                <div class="card-img-top">
                                                    <img style="width: 450px; height:250px" src=" {{(url(env('UPLOAD_FILE').$ticket->attachment))}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- end Modal -->

                        <!-- start colapse -->

                        <div class="mt-5 col-12">
                            <div class="row">
                            @foreach($ticket->responses_methode as $response )
                                    <div class="col-4">
                                        <p>
                                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample_{{$response->id}}" aria-expanded="false" aria-controls="collapseWidthExample">
                                               پاسخ داده شده توسط :   {{$response->user_response->name}}
                                            </button>
                                        </p>
                                        <div style="min-height:20px;">
                                            <div class="collapse collapse-horizontal" id="collapseWidthExample_{{$response->id}}">
                                                <div class="card card-body" style="width: 200px;">
                                                    {{$response->description}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                        </div>
                        <!-- end colapse -->
                    </div>
                </div>
            </div>
                        @else
                            <div class="alert alert-danger text-center mt-5 p-5">
                                <h4>این صفحه مربوط به کاربر عادی می باشد </h4>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                                    @csrf
                              @component("files.bottom",['class'=>"btn btn-outline-dark",'name'=>"بازگشت به صفحه ورود"])
                                   @endcomponent
                                </form>
                            </div>
                        @endif
                    @endforeach
                    <div class="row justify-content-center p-5">
                        <div class="col-4">
                            {{$tickets->render()}}
                        </div>
                    </div>
        </div>
    </div>
@endsection
