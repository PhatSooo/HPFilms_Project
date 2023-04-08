@extends('layouts.user')
@section('title')
    {{ $title }}
@endsection

@section('user_name')
    {{ $user->name }}
@endsection

@section('link')
    <li class="active"><a href="#">Home</a></li>
    <li> <span class="ion-ios-arrow-right"></span>RATED MOVIES</li>
@endsection

@section('user_details')
    <li><a href="{{ URL::Route('user_profile', Session::get('userId')) }}">Profile</a></li>
    <li><a href="{{ URL::Route('user_favorite_list', Session::get('userId')) }}">Favorite movies</a></li>
    <li class="active"><a href="#">Rated movies</a></li>
    <li><a href="{{ URL::Route('user_histories', Session::get('userId')) }}">Histories Views</a></li>
@endsection

@section('user_img')
    <img src="{{Voyager::image($user->avatar)}}" alt="">
@endsection

@section('user_contents')
    <div class="topbar-filter">
        <p>Found <span>{{$review_rate->count()}} rates</span> in total</p>
        <label>Sort by:</label>
        <select>
            <option value="range">-- Choose option --</option>
            <option value="saab">-- Choose option 2--</option>
        </select>
    </div>

    @foreach ($review_rate as $item)
        <div class="movie-item-style-2 userrate">
            <img src="{{File::exists(public_path().Storage::url($item->image)) ? Voyager::image($item->image) : 'https://image.tmdb.org/t/p/w500/'.$item->image}}" alt="">
            <div class="mv-item-infor">
                <h6><a href="{{$item->series != NULL ? URL::Route('series_single', $item->slug) : URL::Route('movie_single', $item->slug)}}">{{$item->title}} <span>({{date_format(new DateTime($item->date_release), 'Y')}})</span></a></h6>
                <p class="time sm-text">your rate:</p>
                <p class="rate"><i class="ion-android-star"></i><span>{{$item->stars}}</span> /10</p>

                @if ($item->review != NULL)
                    <p class="time sm-text">your reviews:</p>
                    <p class="time sm">{{$item->created_at}}</p>
                    {!! $item->review !!}
                @endif

            </div>
        </div>
    @endforeach

    <div class="topbar-filter">
        <label>Page:</label>
        <span>{{$review_rate->currentPage()}} of {{ceil($review_rate->total()/$review_rate->perPage())}}:</span>

        <div class="pagination2">
            {{$review_rate->links()}}
        </div>
    </div>
@endsection
