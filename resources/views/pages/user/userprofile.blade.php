@extends('layouts.user')
@section('title')
    {{ $title }}
@endsection

@section('link')
    <li class="active"><a href="#">Home</a></li>
    <li> <span class="ion-ios-arrow-right"></span>Profile</li>
@endsection

@section('user_name')
    {{ $user->name }}
@endsection

@section('user_details')
    <li class="active"><a href="#">Profile</a></li>
    <li><a href="{{ URL::Route('user_favorite_list', Session::get('userId')) }}">Favorite movies</a></li>
    <li><a href="{{ URL::Route('user_rate', Session::get('userId')) }}">Rated movies</a></li>
    <li><a href="{{ URL::Route('user_histories', Session::get('userId')) }}">Histories Views</a></li>

@endsection

@section('user_img')
    <img src="{{Voyager::image($user->avatar)}}" alt="">
@endsection

@section('user_contents')
    <div class="form-style-1 user-pro">
        <form action="{{ route('update_info',session()->get('userId')) }}" method="POST" class="user">
            @if (session('user_status'))
                <div class="alert alert-success" role="alert">
                    {{ session('user_status') }}
                </div>
            @endif

            @method('PUT')
            @csrf

            <h4>01. Profile details</h4>
            <div class="row">
                <div class="col-md-6 form-it">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" placeholder="edward@kennedy.com">
                </div>

                @if ($user->email_verified_at)
                    <div class="col-md-3 form-it">
                        <br>
                        <label style="color: rgb(0, 255, 0);padding-top:18px">&#x2714; <span style="padding-left: 10px">Your
                                Email is verified!!</span></label>
                    </div>
                @else
                    <div class="col-md-3 form-it">
                        <br>
                        <label style="color: red;padding-top:18px">&#x2718; <span style="padding-left: 10px">Your Email
                                is not verified!!</span></label>
                    </div>
                    <div class="col-md-3 form-it" style="padding-top:20px">
                        <br>
                        <a id="Verify_Email" href="{{route('verification.notice',false)}}" class="yellowbtn">Verify Email</a>
                    </div>
                @endif

            </div>

            @if (Session::has('verify_email'))
                <script>
                    $('#Verify_Email').text('Resend!');
                    $("#Verify_Email").attr("href","{{route('verification.notice',true)}}")
                </script>
                <div style="padding-left:50%;color: antiquewhite"><a>**{{Session::get('verify_email')}}**</a></div>
                <br>
            @endif

            <?php $name = explode(' ', $user->name);
            $firstName = $name[0];
            array_shift($name); ?>

            <div class="row">
                <div class="col-md-6 form-it">
                    <label>First Name</label>
                    <input type="text" name="firstName" value="{{ $firstName }}" placeholder="Edward ">
                </div>
                <div class="col-md-6 form-it">
                    <label>Last Name</label>
                    <input type="text" name="lastName" value="@foreach ($name as $n) {{$n}} @endforeach"
                        placeholder="Kennedy">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <input class="submit" type="submit" value="save">
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('change_pass', Session::get('userId')) }}" class="password">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @method('PATCH')
            <h4>02. Change password</h4>
            @csrf
            <div class="row">
                <div class="col-md-6 form-it">
                    <label>Old Password</label>
                    <input name="old_pass" type="password" placeholder="**********">
                </div>
                @error('old_pass')
                    <br>
                    <br>
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 form-it">
                    <label>New Password</label>
                    <input name="new_pass" type="password" placeholder="***************">
                </div>
                @error('new_pass')
                    <br>
                    <br>
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 form-it">
                    <label>Confirm New Password</label>
                    <input name="confirm_pass" type="password" placeholder="*************** ">
                </div>
                @error('confirm_pass')
                    <br>
                    <br>
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-2">
                    @if (Session::has('cant_change'))
                        <script>
                            alert('{{Session::get("cant_change")}}')
                        </script>
                    @endif

                    <input class="submit" type="submit" value="change">
                </div>
            </div>
        </form>
    </div>
@endsection
