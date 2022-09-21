@extends('files.master')
@section('title',"create ticket")
@section('content')
    <div class="col-10 mt-5">
        <div class="row ">
            <div class="col-12">
                <h4>ایجاد تیکت  </h4>
            </div>
            <hr>
        </div>
        <form action="{{route('ticket.store')}}" method="post" autocomplete="off">
            @csrf
            @include('files.error')

            <div class="row ">
                <div class="form-group col-3">
                    <label>نام</label>
                    <input class="form-control @error('name')  is-invalid @enderror" type="text" name="name">
                </div>
                <div class="form-group col-3">
                    <label>نوع</label>
                    <select class="form-control" type="text" name="type">
                        <option value="0">بخش اول</option>
                        <option value="1">بخش دوم</option>
                        <option value="2">بخش سوم</option>
                    </select>
                </div>
            </div >
          @component('files.bottom',['class'=>'btn  btn-outline-primary m-3', 'name'=>'ایجاد'])
               @endcomponent
            <a href="{{route('ticket.index')}}" class="btn btn-lg btn-outline-dark">بازگشت</a>

        </form>
    </div>



@endsection
