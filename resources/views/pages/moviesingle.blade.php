@extends('layouts.master')

@if (session('success'))
    <script>
        alert('Thanks for your rating');
    </script>
@elseif (session('fail'))
    <script>
        alert('Something went wrong');
    </script>
@endif

@section('contents')
    <div class="hero mv-single-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- <h1> movie listing - list</h1>
                                                <ul class="breadcumb">
                                                    <li class="active"><a href="#">Home</a></li>
                                                    <li> <span class="ion-ios-arrow-right"></span> movie listing</li>
                                                </ul> -->
                </div>
            </div>
        </div>
    </div>
    <div class="page-single movie-single movie_single">
        <div class="container">
            <div class="row ipad-width2">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="movie-img sticky-sb">
                        <img src="https://image.tmdb.org/t/p/w500/{{ $movie[0]->image }}" alt="">
                        <div class="movie-btn">
                            <div class="btn-transform transform-vertical red">
                                <div><a href="#" class="item item-1 redbtn"> <i class="ion-play"></i> Watch
                                        Trailer</a></div>
                                <div><a href="https://www.youtube.com/embed/{{ $movie[0]->trailer }}"
                                        class="item item-2 redbtn fancybox-media hvr-grow"><i class="ion-play"></i></a>
                                </div>
                            </div>
                            <div class="btn-transform transform-vertical">
                                <div><a href="#" class="item item-1 yellowbtn"> <i class="ion-card"></i> Buy
                                        ticket</a></div>
                                <div><a href="#" class="item item-2 yellowbtn"><i class="ion-card"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="movie-single-ct main-content">
                        <h1 class="bd-hd">{{ $movie[0]->title }}
                            <span>{{ date_format(new DateTime($movie[0]->date_release), 'Y') }}</span>
                        </h1>
                        <div class="social-btn">
                            @if (Session::get('userId'))
                                @if ($get_favorites)
                                    <a style="cursor: pointer" onclick="favorite(true)" class="parent-btn"><i
                                            class="ion-heart-broken"></i> Remove from Your Favorite</a>
                                @else
                                    <a style="cursor: pointer" onclick="favorite(false)" class="parent-btn"><i
                                            class="ion-heart"></i> Add to Favorite</a>
                                @endif
                            @else
                                <a style="cursor: pointer" onclick="return alert('You must be login first')"
                                    class="parent-btn"><i class="ion-heart"></i> Add to Favorite</a>
                            @endif

                            <script>
                                function favorite(check) {
                                    if (check) {
                                        window.location.href = "{{ route('favorite', [$movie[0]->slug, 'true']) }}";
                                    } else {
                                        window.location.href = "{{ route('favorite', [$movie[0]->slug, 'false']) }}";
                                    }
                                }
                            </script>
                            <div class="hover-bnt">
                                <a href="#" class="parent-btn"><i class="ion-android-share-alt"></i>share</a>
                                <div class="hvr-item">
                                    <a href="#" class="hvr-grow"><i class="ion-social-facebook"></i></a>
                                    <a href="#" class="hvr-grow"><i class="ion-social-twitter"></i></a>
                                    <a href="#" class="hvr-grow"><i class="ion-social-googleplus"></i></a>
                                    <a href="#" class="hvr-grow"><i class="ion-social-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="movie-rate">
                            <div class="rate">
                                <i class="ion-android-star"></i>
                                <p><span>{{ round($get_rates[0]->avg_stars, 1) }}</span> /10<br>
                                    <span class="rv">{{ $get_rates[0]->count_votes }} Votes</span>
                                </p>
                            </div>
                            <?php $check_login = isset($_SESSION['userId']) ? $_SESSION['userId'] : ''; ?>
                            <script>
                                function change(id) {
                                    var ab = document.getElementById(id + "_star").value;
                                    for (var i = ab; i >= 1; i--) {
                                        document.getElementById(i).className = "ion-ios-star";
                                    }
                                    var cd = parseInt(ab) + 1;
                                    for (var j = cd; j <= 10; j++) {
                                        document.getElementById(j).className = "ion-ios-star-outline";
                                    }
                                }

                                function off(id) {
                                    var count = {{ count($get_stars_by_user) }};
                                    if (count > 0)
                                        var ab = {{ $get_stars_by_user[0]->stars }};
                                    else var ab = 0;
                                    if (!ab) {
                                        for (var i = 1; i <= id; i++) {
                                            document.getElementById(i).className = "ion-ios-star-outline";
                                        }
                                    } else {
                                        for (var i = 1; i <= ab; i++) {
                                            document.getElementById(i).className = "ion-ios-star";
                                        }

                                        var cd = parseInt(ab) + 1;
                                        for (var j = cd; j <= 10; j++) {
                                            document.getElementById(j).className = "ion-ios-star-outline";
                                        }
                                    }
                                }

                                function rate(id) {
                                    document.getElementById("true_rate").value = id;
                                    document.forms['rating_form'].submit();
                                }
                            </script>
                            <div class="rate-star">
                                <p>Rate This Movie: </p>
                                @if (Session::has('userId'))
                                    <form method="POST" action="{{ route('rating', $movie[0]->slug) }}"
                                        name="rating_form">
                                        @csrf
                                        <input type="hidden" name="true_rate" id="true_rate">
                                        <input type="hidden" name="slug" value="{{ $movie[0]->slug }}">
                                        <input type="hidden" id="1_star" value="1" name="1">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="1"></i>
                                        <input type="hidden" id="2_star" value="2" name="2">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="2"></i>
                                        <input type="hidden" id="3_star" value="3" name="3">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="3"></i>
                                        <input type="hidden" id="4_star" value="4" name="4">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="4"></i>
                                        <input type="hidden" id="5_star" value="5" name="5">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="5"></i>
                                        <input type="hidden" id="6_star" value="6" name="6">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="6"></i>
                                        <input type="hidden" id="7_star" value="7" name="7">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="7"></i>
                                        <input type="hidden" id="8_star" value="8" name="8">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="8"></i>
                                        <input type="hidden" id="9_star" value="9" name="9">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="9"></i>
                                        <input type="hidden" id="10_star" value="10" name="10">
                                        <i class="ion-ios-star-outline" onmouseout=off(this.id) onmouseover=change(this.id)
                                            onclick=rate(this.id) id="10"></i>
                                        <button type="submit" style="display:none"></button>
                                    </form>
                                @else
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                @endif
                            </div>
                            <script>
                                var check = {{ Session::get('userId') ? Session::get('userId') : 0 }}
                                if (check) {
                                    var ab = {{ $get_stars_by_user[0]->stars }}
                                    for (var i = ab; i >= 1; i--) {
                                        document.getElementById(i).className = "ion-ios-star";
                                    }
                                }
                            </script>
                        </div>
                        <div class="movie-tabs">
                            <div class="tabs">
                                <ul class="tab-links tabs-mv">
                                    <li class="active"><a href="#overview">Overview</a></li>
                                    <li><a href="#reviews"> Reviews</a></li>
                                    <li><a href="#moviesrelated"> Related Movies</a></li>
                                    <li {{ Session::get('userId') ? '' : 'style=pointer-events:none;opacity:0.4;' }}><a
                                            href="#moviewatching"> Watch Movies</a></li>

                                </ul>
                                <div class="tab-content">
                                    <div id="overview" class="tab active">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-12 col-xs-12">
                                                {!! $movie[0]->overview !!}
                                                <div class="title-hd-sm">
                                                    <h4>cast</h4>
                                                </div>
                                                <!-- movie cast -->
                                                <div class="mvcast-item">
                                                    <?php $i = 0; ?>
                                                    @foreach ($get_actors as $actor)
                                                        <div class="cast-it">
                                                            <div class="cast-left">
                                                                <img style="width:70px; height:70px;"
                                                                    src="https://image.tmdb.org/t/p/w500{{ $actor->image }}"
                                                                    alt="">
                                                                <form name="fMwA{{ $i }}"
                                                                    action="{{ route('movie_search') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="crewId"
                                                                        value="{{ $actor->crew_id }}">
                                                                    <input type="hidden" name="position"
                                                                        value="{{ $actor->position }}">
                                                                    <a
                                                                        onclick="submit({{ $i }})">{{ $actor->crew_name }}</a>
                                                                </form>
                                                            </div>
                                                            <p>........{{ $actor->character_name }}</p>
                                                        </div>
                                                        <?php $i++; ?>
                                                    @endforeach

                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12 col-sm-12">
                                                <div class="sb-it">
                                                    <h6>Director: </h6>
                                                    <p><a>
                                                            @if (count($get_directs) > 0)
                                                                <?php $count = 0; ?>
                                                                @foreach ($get_directs as $direct)
                                                                    @if ($count < 3)
                                                                        <a href="#">{{ $direct->crew_name }}{{ $loop->last ? '' : ',' }}
                                                                        </a>
                                                                        <?php $count++; ?>
                                                                    @else
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <p><a>Updating</a></p>
                                                        @endif
                                                    </a></p>
                                            </div>
                                            <div class="sb-it">
                                                <h6>Writer: </h6>
                                                <p><a>
                                                        @if (count($get_writers) > 0)
                                                            <?php $count = 0; ?>
                                                            @foreach ($get_writers as $writer)
                                                                @if ($count < 3)
                                                                    <a href="#">{{ $writer->crew_name }}{{ $loop->last ? '' : ',' }}
                                                                    </a>
                                                                    <?php $count++; ?>
                                                                @else
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <p><a>Updating</a></p>
                                                    @endif
                                                </a></p>
                                        </div>
                                        <div class="sb-it">
                                            <h6>Stars: </h6>

                                            @if (!empty($get_actors))
                                                <?php $count = 0; ?>
                                                @foreach ($get_actors as $actor)
                                                    @if ($count < 3)
                                                        <form name="fMwA{{ $count }}"
                                                            action="{{ route('movie_search') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="crewId"
                                                                value="{{ $actor->crew_id }}">
                                                            <input type="hidden" name="position"
                                                                value="{{ $actor->position }}">
                                                            <p><a
                                                                    onclick="submit({{ $count }})">{{ $actor->crew_name }}{{ $loop->last ? '' : ',' }}</a>
                                                            </p>
                                                        </form>
                                                        <?php $count++; ?>
                                                    @else
                                                    @break
                                                @endif
                                            @endforeach
                                        @else
                                            <p><a>Updating</a></p>
                                        @endif

                                    </div>
                                    <div class="sb-it">
                                        <h6>Genres:</h6>
                                        @if (!empty($get_genres))
                                            <div style="display: flex">
                                                <p>
                                                    @foreach ($get_genres as $genre)
                                                        <a href="#">
                                                            {{ $genre->genre_name }}{{ $loop->last ? '' : ',' }}
                                                        </a>
                                                    @endforeach
                                                </p>
                                            </div>
                                        @else
                                            <p>Updating</p>
                                        @endif
                                    </div>
                                    <div class="sb-it">
                                        <h6>Release Date:</h6>
                                        <p> {{ date_format(new DateTime($movie[0]->date_release), 'M-d-Y') }}
                                        </p>
                                    </div>
                                    <div class="sb-it">
                                        <h6>Run Time:</h6>
                                        <p> {{ date('h \h\ i', mktime(0, $movie[0]->runtime)) }} min</p>
                                    </div>
                                    <div class="sb-it">
                                        <h6>Plot Keywords:</h6>
                                        <p class="tags">
                                            @if (!empty($get_keywords))
                                                @foreach ($get_keywords as $keyword)
                                                    <span class="time"><a href="#">
                                                            {{ $keyword->keyword_name }} </a></span>
                                                @endforeach
                                            @else
                                                <p>Updating</p>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="ads">
                                        <img src="{{ asset('assets/images/uploads/ads1.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="reviews" class="tab review">
                            <div class="row">
                                <div class="rv-hd">
                                    <div class="div">

                                    </div>
                                    <a id="write-review" onclick="write_review()" class="redbtn">Write
                                        Review</a>
                                </div>
                                <div class="topbar-filter">
                                    <p>Found <span>{{ count($get_reviews) }} reviews</span> in total</p>
                                    <label>Filter by:</label>
                                    <select>
                                        <option value="popularity">Popularity Descending</option>
                                        <option value="popularity">Popularity Ascending</option>
                                        <option value="rating">Rating Descending</option>
                                        <option value="rating">Rating Ascending</option>
                                        <option value="date">Release date Descending</option>
                                        <option value="date">Release date Ascending</option>
                                    </select>
                                </div>

                                {{-- Write review div --}}
                                <div class="container">
                                    <form style="display: none" id="hiddenFrm"
                                        action=" {{ route('review', $movie[0]->slug) }}" method="POST">
                                        @csrf
                                        <label for="review">Write Your Review</label>
                                        <input type="text" name="review">

                                        <button type="submit" class="bton-send">Send</button> || <a
                                            class="bton-cancel" onclick="closeInput()">Cancel</a>
                                    </form>
                                    <br>
                                </div>
                                {{-- End Write review div --}}

                                @foreach ($get_reviews as $review)
                                    <div class="mv-user-review-item">
                                        <div class="user-infor">
                                            <img src="{{ Voyager::image($review->avatar) }}" alt="">
                                            <div>
                                                <h3>{{ $review->name }}</h3>
                                                <div class="no-star">
                                                    @for ($i = $review->stars; $i >= 1; $i--)
                                                        <i class="ion-android-star"></i>
                                                    @endfor
                                                    @for ($i = $review->stars + 1; $i <= 10; $i++)
                                                        <i class="ion-android-star last"></i>
                                                    @endfor
                                                </div>

                                                <p class="time">
                                                    {{ $review->created_at }}
                                                </p>
                                            </div>
                                        </div>
                                        <p>{!! $review->review !!}</p>
                                    </div>
                                @endforeach

                                <div class="topbar-filter">
                                    <label>Reviews per page:</label>
                                    <select>
                                        <option value="range">5 Reviews</option>
                                        <option value="saab">10 Reviews</option>
                                    </select>
                                    <div class="pagination2">
                                        <span>Page 1 of 6:</span>
                                        <a class="active" href="#">1</a>
                                        <a href="#">2</a>
                                        <a href="#">3</a>
                                        <a href="#">4</a>
                                        <a href="#">5</a>
                                        <a href="#">6</a>
                                        <a href="#"><i class="ion-arrow-right-b"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="moviesrelated" class="tab">
                            <div class="row">
                                <h3>Related Movies To</h3>
                                <h2>{{ $movie[0]->title }}</h2>
                                <div class="topbar-filter">
                                    <p>Found <span>{{count($list_rec)}} movies</span> in total</p>
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

                                @foreach ($list_rec as $item)
                                    <div class="movie-item-style-2">
                                        <img src="{{File::exists(public_path().Storage::url($item->image)) ? Voyager::image($item->image) : 'https://image.tmdb.org/t/p/w500/'.$item->image}}" alt="">
                                        <div class="mv-item-infor">
                                            <h6><a href="{{ $item->series != null ? URL::Route('series_single', $item->slug) : URL::Route('movie_single', $item->slug) }}">{{$item->title}} <span>({{ date_format(new DateTime($item->date_release), 'Y') }})</span></a></h6>
                                            {{$item->overview}}
                                            <p class="run-time"> Run Time: {{ date('h \h\ i \p', mktime(0, $item->runtime)) }} .   <span>Release: {{ date_format(new DateTime($item->date_release), 'd-M-Y') }}</span>  </p>
                                            <p>Director: {!!$item->crew_id ? '<a href="#">'.$item->crew_name.'</a>' : '<a href="#">Updating</a>' !!} </p>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="topbar-filter">
                                    <label>Movies per page:</label>
                                    <select>
                                        <option value="range">5 Movies</option>
                                        <option value="saab">10 Movies</option>
                                    </select>
                                    <div class="pagination2">
                                        <span>Page 1 of 2:</span>
                                        <a class="active" href="#">1</a>
                                        <a href="#">2</a>
                                        <a href="#"><i class="ion-arrow-right-b"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script>
                            var isPause = true;
                            var view = 0;

                            function video_play() {
                                if (isPause) {
                                    document.getElementById("video_play").pause();
                                    isPause = false;
                                    if (view == 0) {
                                        $.ajax({
                                            url: "{{ route('history', $movie[0]->slug) }}",
                                            type: "post",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "user_id": "{{ Session::get('userId') }}",
                                                "movie_id": "{{ $movie[0]->movie_id }}"
                                            },
                                            success: function() {
                                                view = 1;
                                            },
                                            error: function() {
                                                alert("Something went wrong!")
                                            }
                                        });
                                    }
                                } else {
                                    document.getElementById("video_play").play();
                                    isPause = true;
                                }
                            }
                        </script>
                        <div id="moviewatching" class="tab">
                            <form id="frm" action="{{ route('history', $movie[0]->slug) }}"
                                method="POST">
                                @csrf

                                <input type="hidden" value="{{ $movie[0]->movie_id }}" id="movieId">
                                <input type="hidden" value="{{ Session::get('userId') }}" id="userId">
                                <a onclick="video_play()"><video controls id="video_play"
                                        src="{{ Voyager::image($movie[0]->link) }}"></video></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
    var get = document.getElementById("isUserLogin");
    if (get != null) {
        sessionValue = get.value;
    } else sessionValue = null;

    function write_review() {
        if (sessionValue == '1') {
            var isRating = {{ $get_stars_by_user[0]->stars }};
            if (isRating > 0) {
                document.getElementById("hiddenFrm").style.display = "block";
                return true;
            }
            alert('Let we know your vote opinion about this film');
            return false;
        } else {
            alert('Please login before Writing your Review!!');
            return false;
        }
    }

    function closeInput() {
        document.getElementById("hiddenFrm").style.display = "none";
    }

    function submit(id) {
        let fID = 'fMwA'.concat(id);
        document.forms[fID].submit();
    }
</script>
@endsection

@section('title')
{{ $title }}
@endsection
