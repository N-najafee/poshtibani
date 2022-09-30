@extends('layouts.app')
@section('title',"create subject")

@section('content')
    <div class="col-10 mt-5">
        <div class="row ">
            <div class="col-12">
                <h1>ایجاد  موضوع   </h1>
            </div>
            <hr>
            <h2 class=" m-3">ایجاد موضوع :  </h2>
        </div>
        <form action="{{route('subject.store')}}" method="post" autocomplete="off" >
            @csrf
            @include('files.error')
            <div class="row ">
                <div class="form-group col-3">
                    <label> موضوع</label>
                    <input class="form-control @error('subject')  is-invalid @enderror" type="text" name="subject">
                </div>
                <div class="form-group col-3">
                    <label>وضعیت</label>
                    <select class="form-select"  name="is_active">
                        <option value="1" selected>فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                </div>
            </div >
            <input type="submit" class="btn btn-lg btn-outline-primary m-3" value="ایجاد">
        </form>
        <a href="{{route('admin.index')}}" class="btn btn-lg btn-outline-dark">بازگشت</a>
    </div>


@endsection
