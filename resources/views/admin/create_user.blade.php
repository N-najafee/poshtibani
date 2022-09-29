@extends('layouts.app')
@section('title',"create user")

@section('content')
    <div class="col-10 mt-5">
        <div class="row ">
            <div class="col-12">
                <h1>ایجاد کاربر   </h1>
            </div>
            <hr>
        </div>
        <form action="{{route('user.store')}}" method="post" autocomplete="off" >
            @csrf
            @include('files.error')
            <div class="row ">
                <div class="form-group col-3">
                    <label> نام کاربر</label>
                    <input class="form-control @error('name')  is-invalid @enderror" type="text"  name="name" value="{{old('name')}}">
                </div>
                <div class="form-group col-3">
                    <label> رمز عبور</label>
                    <input class="form-control @error('password')  is-invalid @enderror" type="text" name="password">
                </div>
                <div class="form-group col-3">
                    <label> تکرار رمز عبور</label>
                    <input class="form-control @error('confirm_password')  is-invalid @enderror" type="text" name="confirm_password">
                </div>
                <div class="form-group col-3">
                    <label> ایمیل</label>
                    <input class="form-control @error('email')  is-invalid @enderror" type="text"  name="email" value="{{old('email')}}">
                </div>
                <div class="form-group col-3">
                    <label>نقش کاربر</label>
                    <select class="form-select" name="role">
                            <option value="{{\App\Http\Consts\Userconsts::USER}}" selected >کاربر عادی</option>
                            <option value="{{\App\Http\Consts\Userconsts::ADMIN}}"> مدیر</option>
                            <option value="{{\App\Http\Consts\Userconsts::POSHTIBAN}}" >پشتیبان</option>
                    </select>
                </div>
                <div class="form-group col-3">
                    <label>وضعیت</label>
                    <select class="form-control" name="is_active">
                        <option value="1" selected >فعال</option>
                        <option value="0" >غیر فعال</option>
                    </select>
                </div>
            </div >
            <input type="submit" class="btn btn-lg btn-outline-primary m-3" value="ایجاد">
        </form>

        <a href="{{route('admin.index')}}" class="btn btn-lg btn-outline-dark">بازگشت</a>
    </div>


@endsection
