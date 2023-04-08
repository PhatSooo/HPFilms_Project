@extends('layouts.user')
@section('title')
    {{ $title }}
@endsection

@section('user_name')
    {{ $user->name }}
@endsection

@section('link')
    <li class="active"><a href="#">Home</a></li>
    <li> <span class="ion-ios-arrow-right"></span>FAVORITE MOVIES</li>
@endsection

@section('user_details')
    <li><a href="{{ URL::Route('user_profile', Session::get('userId')) }}">Profile</a></li>
    <li class="active"><a href="#">Favorite movies</a></li>
    <li><a href="{{ URL::Route('user_rate', Session::get('userId')) }}">Rated movies</a></li>
    <li><a href="{{ URL::Route('user_histories', Session::get('userId')) }}">Histories Views</a></li>
@endsection

@section('user_img')
    <img src="{{Voyager::image($user->avatar)}}" alt="">
@endsection

@section('user_contents')
    <div class="topbar-filter user">
        <p>Found <span>{{$favorites_list->count()}} movies</span> in total</p>
        <label>Sort by:</label>
        <select>
            <option value="range">-- Choose option --</option>
            <option value="saab">-- Choose option 2--</option>
        </select>
    </div>

    <div id="listView">
        <div class="flex-wrap-movielist user-fav-list">
            @foreach ($favorites_list as $favorite)
                <div class="movie-item-style-2">
                    <img style="width: 100px; height: 153px" src="{{File::exists(public_path().Storage::url($favorite->image)) ? Voyager::image($favorite->image) : 'https://image.tmdb.org/t/p/w500/'.$favorite->image}}" alt="">
                    <div class="mv-item-infor">
                        <h6><a href="{{$favorite->series != NULL ? URL::Route('series_single', $favorite->slug) : URL::Route('movie_single', $favorite->slug)}}">{{$favorite->title}} <span>({{date_format(new DateTime($favorite->date_release), 'Y')}})</span></a></h6>
                        {!!$favorite->overview!!}
                        <p class="run-time"> Run Time: {{date('h\h\ i\p', mktime(0, $favorite->runtime))}}   <span>Release: {{date_format(new DateTime($favorite->date_release), 'd-M-Y')}} </span></p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="topbar-filter">
            <label>Page:</label>
            <span>{{$favorites_list->currentPage()}} of {{ceil($favorites_list->total()/$favorites_list->perPage())}}:</span>

            <div class="pagination2">
                {{$favorites_list->links()}}
            </div>
        </div>
    </div>

@endsection
