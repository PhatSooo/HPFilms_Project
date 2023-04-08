@extends('layouts.master')
{{-- @section('title')
    {{$title}}
@endsection --}}

@section('contents')
    <div class="hero common-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-ct">
                        <h1> movie listing - list</h1>
                        <ul class="breadcumb">
                            <li class="active"><a href="#">Home</a></li>
                            <li> <span class="ion-ios-arrow-right"></span> movie search</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($search->count() == 0)
        <div style="text-align: center" class="alert alert-success">Not Founding Movie with your Order</div>
    @else
        <div id="div_change" class="page-single movie_list">
            <div class="container">
                <div class="row ipad-width">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="topbar-filter">
                            <p>Found <span>{{ count($search) }} movies</span> in total</p>
                            <label>Sort by:</label>
                            <select>
                                <option value="popularity">Popularity Descending</option>
                                <option value="popularity">Popularity Ascending</option>
                                <option value="rating">Rating Descending</option>
                                <option value="rating">Rating Ascending</option>
                                <option value="date">Release date Descending</option>
                                <option value="date">Release date Ascending</option>
                            </select>
                        </div>

                        <div id="movie_list">
                            @foreach ($search as $movie)
                                <div class="movie-item-style-2">
                                    <img src="{{File::exists(public_path().Storage::url($movie->image)) ? Voyager::image($movie->image) : 'https://image.tmdb.org/t/p/w500/'.$movie->image}}" alt="">
                                    <div class="mv-item-infor">
                                        <h6><a
                                                href="{{ $movie->series != null ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug) }}">{{ $movie->title }}
                                                <span>({{ date_format(new DateTime($movie->date_release), 'Y') }})</span></a>
                                        </h6>
                                        {{-- <p class="rate"><i class="ion-android-star"></i><span>{{$movie->avg_star}}</span> /10</p> --}}
                                        {!! Str::limit($movie->overview, 500, '...') !!}
                                        <p class="run-time"> Run Time:
                                            <a>{{ date('h \h\ i \p', mktime(0, $movie->runtime)) }}</a> . <span>Release:
                                                <a>{{ date_format(new DateTime($movie->date_release), 'd-M-Y') }}</a></span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            <div class="topbar-filter">
                                <div class="pagination2">
                                    {{ $search->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="sidebar">
                            <div class="searh-form">
                                <h4 class="sb-title">Search for movie</h4>
                                <form class="form-style-1" name="searchFrm" method="POST"
                                    action="{{ route('movie_search') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 form-it">
                                            <label>Movie name</label>
                                            <input id="name" name="movie" type="text"
                                                placeholder="Enter Movie Name">
                                        </div>
                                        <div class="col-md-12 form-it">
                                            <label>Genres & Subgenres</label>
                                            <div class="group-ip">
                                                <select id="genres" name="genres[]" multiple=""
                                                    class="ui fluid dropdown">
                                                    <option value="">Enter to filter genres</option>
                                                    @foreach ($genres as $item)
                                                        <option value="{{ $item->genre_id }}">{{ $item->genre_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-12 form-it">
                                            <label>Rating Range</label>

                                            <select id="rates" name="rates">
                                                <option value="">-- Select the rating range below --</option>
                                                <option value="under5">-- Under 5 stars --</option>
                                                <option value="5to8">-- From 5 to 8 stars --</option>
                                                <option value="upper8">-- Upper 8 stars --</option>
                                            </select>

                                        </div>
                                        <div class="col-md-12 form-it">
                                            <label>Release Year</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select id="fYear" name="fYear">
                                                        <option value="">From</option>
                                                        <option value="1900">1900</option>
                                                        <option value="2000">2000</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2020">2020</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select id="tYear" name="tYear">
                                                        <option value="">To</option>
                                                        <option value="2000">2000</option>
                                                        <option value="2005">2005</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2015">2015</option>
                                                        <option value="{{ date('Y') }}">Now</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">
                                            <input onclick="check()" class="submit" type="button" value="submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="ads">
                                <img src="{{ asset('assets/images/uploads/ads1.png') }}" alt="">
                            </div>
                            <div class="sb-facebook sb-it">
                                <h4 class="sb-title">Find us on Facebook</h4>
                                <iframe src="#"
                                    data-src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ftemplatespoint.net%2F%3Ffref%3Dts&tabs=timeline&width=340&height=315px&small_header=true&adapt_container_width=false&hide_cover=false&show_facepile=true&appId"
                                    height="315" style="width:100%;border:none;overflow:hidden"></iframe>
                            </div>
                            <div class="sb-twitter sb-it">
                                <h4 class="sb-title">Tweet to us</h4>
                                <div class="slick-tw">
                                    <div class="tweet item" id="">
                                        <!-- Put your twiter id here -->
                                    </div>
                                    <div class="tweet item" id="">
                                        <!-- Put your 2nd twiter account id here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function check() {
            var name = document.getElementById('name').value;
            var genres = document.getElementById('genres').value;
            var rates = document.getElementById('rates').value;
            var tYear = document.getElementById('tYear').value;
            var fYear = document.getElementById('fYear').value;

            if (!name & !genres & !rates & !tYear & !fYear) {
                alert('You must input a field');
                return false;
            } else if (tYear && !fYear) {
                alert('You must choose Release Year From and Release Year To');
                return false;
            } else if (!tYear && fYear) {
                alert('You must choose Release Year From and Release Year To');
                return false;
            } else return document.forms['searchFrm'].submit();
        }
    </script>

@endsection
