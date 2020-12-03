@extends('layouts.layout')

@section('title','Send Email')

@section('content')

    <div class="row mt-5">
        <div class="col-10">
            <div class="card">
                <div class="card-header rtl">
                    ارسال ایمیل
                </div>
                <div class="card-body rtl">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    @if (session('failed'))
                        <div class="alert alert-danger">
                            {{session('failed')}}
                        </div>
                    @endif

                    <form action="{{route('notification.send.email')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="rtl" for="user">@lang('notification.users')</label>
                            <select class="form-control" name="user" id="user">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">@lang('notification.emails')</label>
                            <select class="form-control" name="email_type" id="email">
                                @foreach($emailTypes as  $key => $type)
                                    <option value="{{$key}}">{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->any())
                            @foreach($errors->all() as $error)
                                <ul class="small mb-2">
                                    <li class="text-danger">{{$error}}</li>
                                </ul>
                            @endforeach
                        @endif


                        <button type="submit" class="btn btn-success" value=""> @lang('notification.send') </button>


                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection

