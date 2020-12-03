@extends('layouts.layout')

@section('title','Send SMS')

@section('content')

    <div class="row mt-5">
        <div class="col-10">
            <div class="card">
                <div class="card-header rtl">
                    ارسال پیام کوتاه
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

                    <form action="{{route('notification.send.sms')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="rtl" for="user">@lang('notification.users')</label>
                            <select class="form-control" name="user" id="user">
                                @foreach($users as $user)
                                    <option
                                        {{old('user')== $user->id ? 'selected' : ''}} value="{{$user->id}}">{{$user->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="text">@lang('notification.sms_text')</label>
                            <textarea name="text" id="text" cols="" rows="3"
                                      class="form-control">{{old('text')}}</textarea>
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

