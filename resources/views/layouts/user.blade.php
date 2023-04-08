@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection

@section('contents')
    <div class="hero user-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-ct">
                        <h1>@yield('user_name')’s profile</h1>
                        <ul class="breadcumb">

                            @yield('link')

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-single">
        <div class="container">
            <div class="row ipad-width2">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="user-information">
                        <div class="user-img">
                            @yield('user_img')<br>
                            <form id="frmImg" enctype="multipart/form-data" action="{{route('change_img',Session::get('userId'))}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input accept="image/png, image/jpeg" type="file" id="avatar" name="avatar" style="display: none">
                            </form>
                            @if (Session::has('failed'))
                                <span style="color: red">{{Session::get('failed')}}</span>
                                <br>
                                <br>
                            @elseif (Session::has('image_loaded'))
                                <span style="color: rgb(0, 255, 0)">{{Session::get('image_loaded')}}</span>
                                <br>
                                <br>
                            @endif
                            <a style="cursor: pointer" id="change_img" class="redbtn">Change avatar</a>
                        </div>
                        <div class="user-fav">
                            <p>Account Details</p>
                            <ul>
                                {{-- set active for account details col --}}
                                @yield('user_details')
                            </ul>
                        </div>
                        <div class="user-fav">
                            <p>Others</p>
                            <ul>
                                <li><a href="{{ route('user_profile', session()->get('userId')) }}">Change password</a></li>
                                <li><a href="{{ URL::Route('logout') }}">Log out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-12 col-xs-12">

                    @yield('user_contents')

                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#change_img').click(function(){
            $('#avatar').click();
        });

        $('#avatar').change(function(){
            $('#frmImg').submit();
        })
    });
</script>
