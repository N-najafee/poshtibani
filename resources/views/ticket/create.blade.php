@extends('layouts.app')
@section('title',"create ticket")
@section('script')
@endsection

@section('content')
    <div class="col-10 mt-5">
        <div class="row ">
            <div class="col-12">
                <h4>ایجاد تیکت  </h4>
            </div>
            <hr>
        </div>
        <form action="{{route('ticket.store',['user'=>$user->id])}}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @include('files.error')

            <div class="row ">
                <div class="form-group col-3">
                    <label>عنوان</label>
                    <input class="form-control @error('title')  is-invalid @enderror" type="text" name="title">
                </div>
                <div class="form-group col-3">
                    <label>موضوع</label>
                    <input class="form-control @error('subject')  is-invalid @enderror" type="text" name="subject">
                </div>
                <div class="form-group col-3">
                    <label>انتخاب فایل</label>
                    <input class="form-control"  type="file" name="attachment">
                </div>
            </div >
            <div class="col-12 mt-3">
                <label>توضیحات</label>
                <textarea class="form-control" name="description" rows="5"></textarea>
            </div>
          @component('files.bottom',['class'=>'btn  btn-outline-primary m-3', 'name'=>'ایجاد'])
               @endcomponent
            <a href="{{route('ticket.index')}}" class="btn btn-lg btn-outline-dark">بازگشت</a>

        </form>
    </div>



@endsection
