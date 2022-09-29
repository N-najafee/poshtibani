@extends('layouts.app')
@section('title',"edit user")

@section('content')
    <div class="col-10 mt-5">
        <div class="row ">
            <div class="col-12">
                <h1>ویرایش کاربر   </h1>
            </div>
            <hr>
        </div>
        <form action="{{route('user.update',['user'=>$user->id])}}" method="post" autocomplete="off" >
            @csrf
            @method('PUT')
            @include('files.error')
            <div class="row ">
                <div class="form-group col-3">
                    <label> نام کاربر</label>
                    <input class="form-control @error('name')  is-invalid @enderror" type="text" value="{{$user->name}}" name="name">
                </div>
                <div class="form-group col-3">
                    <label> ایمیل</label>
                    <input class="form-control @error('email')  is-invalid @enderror" type="text" value="{{$user->email}}" name="email">
                </div>
                <div class="form-group col-3">
                    <label>نقش کاربر</label>
                    <select class="form-select" name="role">
                            <option value="{{\App\Http\Consts\Userconsts::USER}}"   {{$user->getraworiginal('role') === \App\Http\Consts\Userconsts::USER ? "selected" : ""}}>کاربر عادی</option>
                            <option value="{{\App\Http\Consts\Userconsts::ADMIN}}"   {{$user->getraworiginal('role') === \App\Http\Consts\Userconsts::ADMIN ? "selected" : ""}}> مدیر</option>
                            <option value="{{\App\Http\Consts\Userconsts::POSHTIBAN}}"   {{$user->getraworiginal('role') === \App\Http\Consts\Userconsts::POSHTIBAN ? "selected" : ""}}>پشتیبان</option>
                    </select>
                </div>
                <div class="form-group col-3">
                    <label>وضعیت</label>
                    <select class="form-control" name="is_active">
                        <option value="1" {{$user->getraworiginal('is_active') ? "selected" : " "}}>فعال</option>
                        <option value="0" {{$user->getraworiginal('is_active') ? " " :"selected"}}>غیر فعال</option>
                    </select>
                </div>
            </div >
            <input type="submit" class="btn btn-lg btn-outline-primary m-3" value="ویرایش">
        </form>

        <a href="{{route('admin.index')}}" class="btn btn-lg btn-outline-dark">بازگشت</a>
    </div>


@endsection
