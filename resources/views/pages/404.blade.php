@extends('layouts.master')

@section('contents')
    <div class="page-single-2">
        <div class="container">
            <div class="row">
                <div class="middle-content">
                    <a href="{{URL::Route('index')}}"><img class="md-logo" src="{{asset('assets/images/logo1.png')}}" alt=""></a>
                    <img src="{{asset('assets/images/uploads/err-img.png')}}" alt="">
                    <h1>Page not found</h1>
                    <a href="{{URL::Route('index')}}" class="redbtn">go home</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    {{$title}}
@endsection
