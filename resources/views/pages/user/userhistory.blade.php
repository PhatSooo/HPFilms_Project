@extends('layouts.user')
@section('title')
    {{ $title }}
@endsection

@section('user_name')
    {{ $user->name }}
@endsection

@section('link')
    <li class="active"><a href="#">Home</a></li>
    <li> <span class="ion-ios-arrow-right"></span>History Views</li>
@endsection

@section('user_details')
    <li><a href="{{ URL::Route('user_profile', Session::get('userId')) }}">Profile</a></li>
    <li><a href="{{ URL::Route('user_favorite_list', Session::get('userId')) }}">Favorite movies</a></li>
    <li><a href="{{ URL::Route('user_rate', Session::get('userId')) }}">Rated movies</a></li>
    <li class="active"><a href="#">Histories Views</a></li>
@endsection

@section('user_img')
    <img src="{{Voyager::image($user->avatar)}}" alt="">
@endsection

@section('user_contents')
    <div class="topbar-filter">
        <p>Found <span>{{count($histories)}} views</span> in total</p>
        <label>Sort by:</label>
        <select>
            <option value="range">-- Choose option --</option>
            <option value="saab">-- Choose option 2--</option>
        </select>
    </div>

    @foreach ($histories as $history)
        <div class="movie-item-style-2 userrate">
            <img style="width: 50px; height: auto" src="{{File::exists(public_path().Storage::url($history->image)) ? Voyager::image($history->image) : 'https://image.tmdb.org/t/p/w500/'.$history->image}}" alt="">
            <div class="mv-item-infor">
                <h6><a href="{{$history->series != NULL ? URL::Route('series_single', $history->slug) : URL::Route('movie_single', $history->slug)}}">{{$history->title}} <span>   ({{date_format(new DateTime($history->date_release), 'Y')}})</span></a></h6>
                <div style="display: flex; justify-content: space-between;">
                    <p style="margin-top: 0px" class="time sm-text">Watch at:</p>
                    <p style="padding-left: 10px" class="rate"><i>{{$history->updated_at}}</i></p>
                    <a id="{{$history->id}}" onclick="delete_his(this.id)" href="#" style="padding-left: 50px;color: red;">Remove</a>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function delete_his(id){
            if(confirm("Are you sure to delete this history!") == true){
                $.ajax({
                    url:"{{route('remove_history',[Session::get('userId'),"id"])}}",
                    type:"put",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "history_id":id
                    },
                    success: function () {
                        location.reload();
                    },
                    error: function () {
                        alert("Something went wrong!");
                    }
                });
            }
        }
    </script>

@endsection
