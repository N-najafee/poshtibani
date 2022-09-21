@extends('layouts.app')
@section('title','index')

@section('script')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
                    <div class="row justify-content-between ">
                        <div class="col-6 text-end">
                            <h3> پاسخ به تیکت :  {{ $ticket->title }}   </h3>
                        </div>
                        <hr>
                    </div>
@include('files.error')
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
                        <a href="{{route('poshtiban.index')}}"  class="btn btn-outline-primary" >
                            بازگشت
                        </a>
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
                    </div>
                </div>

            <div class="col-8 mt-3" id="response">
                <p>
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                                پاسخ
                    </button>
                </p>
                <form action="{{route('poshtiban.store',['ticket'=>$ticket->id])}}" method="post">
                    @csrf
                <div class="collapse collapse-horizontal" id="collapseWidthExample">
                    <textarea class="card card-body " cols="110" rows="5" name="text" ></textarea>
                    <input class="btn btn-outline-primary  mt-3" type="submit" value="ارسال">
                </div>
                </form>
            </div>
            <div class="col-8 mt-3" id="response">
                <div class="row ">
                    @foreach($ticket->responses_methode as $response)
                        <div class="col-3 mt-3" id="response">
                            <p>
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample_{{$response->id}}" aria-expanded="false" aria-controls="collapseWidthExample">
                                    نمایش پاسخ : {{$response->user_response->name}}
                                </button>
                            </p>
                            <div class="collapse collapse-horizontal" id="collapseWidthExample_{{$response->id}}">
                                <textarea class="card card-body " cols="110" rows="5" name="text" >{{$response->description}}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

@endsection



