@extends('layouts.app')
@section('title',"edit subject")

@section('content')
    <div class="col-10 mt-5">
        <div class="row ">
            @include('files.error')
            <div class="col-12">
                <h1>ایجاد و ویرایش موضوع   </h1>
            </div>
            <hr>

        <div class="col-12">
            <h2>ویرایش موضوع : </h2>
        </div>
        <form action="{{route('subject.update',['subject'=>$subject->id])}}" method="post" autocomplete="off" >
            @csrf
            @method('PUT')
            <div class="row ">
                <div class="form-group col-3">
                    <label> موضوع</label>
                    <input class="form-control @error('subject')  is-invalid @enderror" type="text"  name="subject" value="{{($subject->name)}}">
                </div>

                <div class="form-group col-3">
                    <label>وضعیت</label>
                    <select class="form-select"  name="is_active">
                        <option value="1"  {{$subject->getraworiginal('is_active') ?'selected' : '' }}>فعال</option>
                        <option value="0"  {{$subject->getraworiginal('is_active') ? '' : 'selected' }}>غیرفعال</option>
                    </select>
                </div>
            </div >
            <input type="submit" class="btn btn-lg btn-outline-primary m-3" value="ویرایش">
        </form>
    </div>
        <a href="{{route('admin.index')}}" class="btn btn-lg btn-outline-dark">بازگشت</a>
    </div>

@endsection
