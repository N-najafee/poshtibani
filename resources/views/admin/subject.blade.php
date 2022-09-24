@extends('layouts.app')
@section('title',"create ticket")

@section('content')
    <div class="col-10 mt-5">
        <div class="row ">
            <div class="col-12">
                <h1>ایجاد و ویرایش موضوع   </h1>
            </div>
            <hr>
            <h2 class=" m-3">ایجاد موضوع :  </h2>
        </div>
        <form action="{{route('admin.store',['user'=>$user->id])}}" method="post" autocomplete="off" >
            @csrf
            @include('files.error')
            <div class="row ">
                <div class="form-group col-3">
                    <label> نام موضوع</label>
                    <input class="form-control @error('name_subject')  is-invalid @enderror" type="text" name="name_subject">
                </div>
                <div class="form-group col-3">
                    <label>توضیحات</label>
                    <textarea class="form-select" cols="5" rows="1" name="description"></textarea>
                </div>
            </div >
            <input type="submit" class="btn btn-lg btn-outline-primary m-3" value="ایجاد">
        </form>
        <hr>
        <div class="col-12">
            <h2>ویرایش موضوع : </h2>
        </div>
        <form action="{{route('admin.update.subject',['subject'=>$subject->id,'user'=>$user->id])}}" method="post" autocomplete="off" >
            @csrf
            @method('PUT')
            <div class="row ">
                <div class="form-group col-3">
                    <label> نام موضوع</label>
                    <input class="form-control @error('subject')  is-invalid @enderror" type="text"  name="subject" value="{{($subject->subject)}}">
                </div>

                <div class="form-group col-3">
                    <label>توضیحات</label>
                    <textarea class="form-select" cols="5" rows="1" name="description">{{($subject->description)}}</textarea>
                </div>
            </div >
            <input type="submit" class="btn btn-lg btn-outline-primary m-3" value="ویرایش">
        </form>
        <hr>
        <a href="{{route('admin.index')}}" class="btn btn-lg btn-outline-dark">بازگشت</a>
    </div>


@endsection
