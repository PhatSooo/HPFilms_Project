@extends('layouts.master')

{{-- Access to user feature without sigin --}}
@if (session('fail'))
    <script>
        alert('You Must Be Login First');
    </script>
@endif

@section('contents')
    <div class="slider movie-items">
        <div class="container">
            <div class="row">
                <div class="social-link">
                    <p>Follow us: </p>
                    <a href="#"><i class="ion-social-facebook"></i></a>
                    <a href="#"><i class="ion-social-twitter"></i></a>
                    <a href="#"><i class="ion-social-googleplus"></i></a>
                    <a href="#"><i class="ion-social-youtube"></i></a>
                </div>
                <div class="slick-multiItemSlider">
                    @foreach ($new_movies as $movie)
                        <div class="movie-item">
                            <div class="mv-img">
                                <a
                                    href="{{ $movie->series != null ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug) }}"><img
                                        src="{{ File::exists(public_path() . Storage::url($movie->image)) ? Voyager::image($movie->image) : 'https://image.tmdb.org/t/p/w500/' . $movie->image }}"
                                        alt="" width="285" height="437"></a>
                            </div>
                            <div class="title-in">
                                {{-- <div class="cate">
                                    <span class="blue"><a href="#">Sci-fi</a></span>
                                </div> --}}
                                <h6><a
                                        href="{{ $movie->series != null ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug) }}">{{ $movie->title }}</a>
                                </h6>
                                {{-- <p><i class="ion-android-star"></i><span>{{$movie->avg_star}}</span> /10</p> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="movie-items">
        <div class="container">
            <div class="row ipad-width">
                <div class="col-md-8">
                    <div class="title-hd">
                        <h2>Movies</h2>
                        <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                    </div>
                    <div class="tabs">
                        <ul class="tab-links">
                            <li class="active"><a href="#tab1">#Popular</a></li>
                            <li><a href="#tab3"> #Top rated </a></li>
                            <li><a href="#tab4"> #Most reviewed</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="tab active">
                                <div class="row">
                                    <div class="slick-multiItem">
                                        @foreach ($popular_movies as $movie)
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">
                                                        <img src="{{ File::exists(public_path() . Storage::url($movie->image)) ? Voyager::image($movie->image) : 'https://image.tmdb.org/t/p/w500/' . $movie->image }}"
                                                            alt="" width="185" height="284">
                                                    </div>
                                                    <div class="hvr-inner">
                                                        <a
                                                            href="{{ $movie->series != null ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug) }}">
                                                            Read
                                                            more <i class="ion-android-arrow-dropright"></i> </a>
                                                    </div>
                                                    <div class="title-in">
                                                        <h6><a
                                                                href="{{ $movie->series != null ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug) }}">{{ $movie->title }}</a>
                                                        </h6>
                                                        {{-- <p><i class="ion-android-star"></i><span>{{$movie->avg_star}}</span> /10</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div id="tab3" class="tab">
                                <div class="row">
                                    <div class="slick-multiItem">
                                        @foreach ($top_rates as $item)
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">
                                                        <img src="{{ File::exists(public_path() . Storage::url($item->image)) ? Voyager::image($item->image) : 'https://image.tmdb.org/t/p/w500/' . $item->image }}"
                                                            alt="" width="185" height="284">
                                                    </div>
                                                    <div class="hvr-inner">
                                                        <a href="{{ URL::Route('movie_single', $item->slug) }}"> Read
                                                            more <i class="ion-android-arrow-dropright"></i> </a>
                                                    </div>
                                                    <div class="title-in">
                                                        <h6><a
                                                                href="{{ URL::Route('movie_single', $item->slug) }}">{{ $item->title }}</a>
                                                        </h6>
                                                        {{-- <p><i class="ion-android-star"></i><span>{{$item->avg_star}}</span> /10</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div id="tab4" class="tab">
                                <div class="row">
                                    <div class="slick-multiItem">
                                        @foreach ($top_reviews as $item)
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">
                                                        <img src="{{ File::exists(public_path() . Storage::url($item->image)) ? Voyager::image($item->image) : 'https://image.tmdb.org/t/p/w500/' . $item->image }}"
                                                            alt="" width="185" height="284">
                                                    </div>
                                                    <div class="hvr-inner">
                                                        <a href="{{ URL::Route('movie_single', $item->slug) }}"> Read
                                                            more <i class="ion-android-arrow-dropright"></i> </a>
                                                    </div>
                                                    <div class="title-in">
                                                        <h6><a
                                                                href="{{ URL::Route('movie_single', $item->slug) }}">{{ $item->title }}</a>
                                                        </h6>
                                                        {{-- <p><i class="ion-android-star"></i><span>{{$item->avg_star}}</span> /10</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="title-hd">
                        <h2>other</h2>
                        <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                    </div>
                    <div class="tabs">
                        <ul class="tab-links-2">
                            <li class="active"><a href="#tab22"> #Coming soon</a></li>
                            <li><a href="#tab23"> #Recommendation for you</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab22" class="tab active">
                                <div class="row">
                                    <div class="slick-multiItem">
                                        @foreach ($coming_soon as $item)
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">
                                                        <img src="{{ File::exists(public_path() . Storage::url($item->image)) ? Voyager::image($item->image) : 'https://image.tmdb.org/t/p/w500/' . $item->image }}"
                                                            alt="" width="185" height="284">
                                                    </div>
                                                    <div class="hvr-inner">
                                                        <a href="{{ URL::Route('movie_single', $item->slug) }}"> Read
                                                            more <i class="ion-android-arrow-dropright"></i> </a>
                                                    </div>

                                                    <div class="title-in">
                                                        <h6><a href="{{ URL::Route('movie_single', $item->slug) }}">{{ $item->title }}</a></h6>
                                                        {{-- <p><i class="ion-android-star"></i><span>7.4</span> /10</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            @if ($list_rec)
                                <div id="tab23" class="tab">
                                    <div class="row">
                                        <div class="slick-multiItem">
                                            @foreach ($list_rec as $item)
                                                <div class="slide-it">
                                                    <div class="movie-item">
                                                        <div class="mv-img">
                                                            <img src="{{ File::exists(public_path() . Storage::url($item->image)) ? Voyager::image($item->image) : 'https://image.tmdb.org/t/p/w500/' . $item->image }}"
                                                                alt="" width="185" height="284">
                                                        </div>
                                                        <div class="hvr-inner">
                                                            <a href="{{ URL::Route('movie_single', $item->slug) }}"> Read
                                                                more <i class="ion-android-arrow-dropright"></i> </a>
                                                        </div>

                                                        <div class="title-in">
                                                            <h6><a href="{{ URL::Route('movie_single', $item->slug) }}">{{ $item->title }}</a></h6>
                                                            {{-- <p><i class="ion-android-star"></i><span>7.4</span> /10</p> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div id="tab23" class="tab">
                                    <div class="row">
                                        <div class="alert alert-danger" role="alert">
                                            Let Login or Watch at least 1 movie to Use this Feature
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sidebar">
                        <div class="ads">
                            <img src="{{ asset('assets/images/uploads/ads1.png') }}" alt="" width="336"
                                height="296">
                        </div>
                        <div class="celebrities">
                            <h4 class="sb-title">Spotlight Celebrities</h4>
                            <?php $count = 0; ?>
                            @foreach ($spot_celeb as $item)
                                <div class="celeb-item">
                                    <a href="#"><img
                                            src="{{ File::exists(public_path() . Storage::url($item->image)) ? Voyager::image($item->image) : 'https://image.tmdb.org/t/p/w500/' . $item->image }}"
                                            alt="" width="70" height="70"></a>
                                    <div class="celeb-author">
                                        <form name="fMwA{{ $count }}" action="{{ route('movie_search') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="crewId" value="{{ $item->crew_id }}">
                                            <input type="hidden" name="position" value="{{ $item->position }}">
                                            <h6><a onclick="submit({{ $count }})">{{ $item->crew_name }}</a></h6>
                                        </form>
                                        <span>{{ $item->position == 0 ? 'ACTOR' : ($item->position == 1 ? 'DIRECTOR' : 'WRITER') }}</span>
                                    </div>
                                </div>
                                <?php $count++; ?>
                            @endforeach

                            <a href="{{ route('celeb_list') }}" class="btn">See all celebrities<i
                                    class="ion-ios-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="trailers">
        <div class="container">
            <div class="row ipad-width">
                <div class="col-md-12">
                    <div class="title-hd">
                        <h2>in theater</h2>
                        <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                    </div>
                    <div class="videos">
                        <div class="slider-for-2 video-ft">
                            @foreach ($theaters as $theater)
                                <div>
                                    <iframe class="item-video" src="#"
                                        data-src="https://www.youtube.com/embed/{{ $theater->trailer }}"></iframe>
                                </div>
                            @endforeach
                        </div>
                        <div class="slider-nav-2 thumb-ft">
                            @foreach ($theaters as $theater)
                                <div class="item">
                                    <div class="trailer-img">
                                        <img src="{{ File::exists(public_path() . Storage::url($theater->image)) ? Voyager::image($theater->image) : 'https://image.tmdb.org/t/p/w500/' . $theater->image }}"
                                            alt="photo by Barn Images" width="4096" height="2737">
                                    </div>
                                    <div class="trailer-infor">
                                        <h4 class="desc">{{ $theater->name }}</h4>
                                        <p>Release date:
                                            <span>{{ $theater->release_date ? $theater->release_date : 'Updating!' }}</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function submit(id) {
            let fID = 'fMwA'.concat(id);
            document.forms[fID].submit();
        }
    </script>
@endsection

@section('title')
    {{ $title }}
@endsection
