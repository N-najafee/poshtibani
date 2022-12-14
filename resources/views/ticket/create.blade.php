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
        <form action="{{route('ticket.store')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @include('files.error')

            <div class="row ">
                <div class="form-group col-3">
                    <label>عنوان</label>
                    <input class="form-control @error('title')  is-invalid @enderror " type="text" name="title" value="{{old('title')}}">
                </div>
                <div class="form-group col-3">
                    <label>موضوع</label>
                    <select class="form-select" type="text" name="subject">
                        @foreach($subjects as $subject)
                        <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="form-group col-3">
                    <label>انتخاب فایل</label>
                    <input class="form-control"  type="file" name="attachment">
                </div>
            </div >
            <div class="col-12 mt-3">
                <label>توضیحات</label>
                <textarea class="form-control @error('description')  is-invalid @enderror" name="description" rows="5">{{old('description')}}</textarea>
            </div>
          @component('files.bottom',['class'=>'btn  btn-outline-primary m-3', 'name'=>'ایجاد'])
               @endcomponent
            <a href="{{route('ticket.index')}}" class="btn btn-lg btn-outline-dark">بازگشت</a>

        </form>
    </div>



@endsection
