@extends('layouts.master')
{{-- @section('title')
    {{ $title }}
@endsection --}}

@section('contents')
    <div class="hero common-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-ct">
                        <h1>celebrity listing - list</h1>
                        <ul class="breadcumb">
                            <li class="active"><a href="#">Home</a></li>
                            <li> <span class="ion-ios-arrow-right"></span> celebrity listing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($search->count() == 0)
        <div style="text-align: center" class="alert alert-success">Not Founding Actors/Directors/Writers suitable for
            your Order</div>
    @else
        <!-- celebrity list section-->
        <div class="page-single">
            <div class="container">
                <div class="row ipad-width2">
                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="topbar-filter">
                            <p class="pad-change">Found <span>{{ $search->count() }} celebrities</span> in total</p>
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

                        <div id="listView">
                            <div class="row">
                                <?php $i=0; ?>
                                @foreach ($search as $crew)
                                    <div class="col-md-12">
                                        <div class="ceb-item-style-2">
                                            <img width="103" height="141"
                                                src="{{File::exists(public_path().Storage::url($crew->image)) ? Voyager::image($crew->image) : 'https://image.tmdb.org/t/p/w500/'.$crew->image}}" alt="">
                                            <div class="ceb-infor">
                                                <form name="fMwA{{ $i }}" action="{{ route('movie_search') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="crewId" value="{{ $crew->crew_id }}">
                                                    <input type="hidden" name="position" value="{{ $crew->position }}">
                                                    <h2><a onclick="submit({{ $i }})">{{ $crew->crew_name }}</a></h2>
                                                </form>
                                                <span>{{ $crew->position == 0 ? 'actor' : ($crew->position == 1 ? 'Director' : 'Writer') }},
                                                    {{ $crew->nation }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++ ?>
                                @endforeach
                            </div>

                            <div class="topbar-filter">
                                <label>Page:</label>
                                <span>{{ $search->currentPage() }} of
                                    {{ ceil($search->total() / $search->perPage()) }}:</span>

                                <div class="pagination2">
                                    {{ $search->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <div class="sidebar">
                            <div class="searh-form">
                                <h4 class="sb-title">Search celebrity</h4>
                                <form name="searchFrm" class="form-style-1 celebrity-form" method="POST"
                                    action="{{ route('crews_search') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 form-it">
                                            <label>Celebrity name</label>
                                            <input name="name" id="name" type="text"
                                                placeholder="Enter keywords">
                                        </div>
                                        <div class="col-md-12 form-it">
                                            <label>Category</label>
                                            <select name="cate" id="cate">
                                                <option value="">Enter to choose Category</option>
                                                <option value="0_1">Actors</option>
                                                <option value="0_0">Actress</option>
                                                <option value="1">Directors</option>
                                                <option value="2">Writers</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-it">
                                            <label>Nation</label>
                                            <select name="nation" id="nation">
                                                <option value="">Enter to filter Nation</option>
                                                @foreach ($nations as $item)
                                                    <option value="{{ $item->nation }}">{{ $item->nation }}
                                                    </option>
                                                @endforeach
                                            </select>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- end of celebrity list section-->
    <script>
        jQuery(document).ready(function() {
            if ({{ request()->grid }}) {
                document.getElementById(0).click();
            }
        });
    </script>

    <script>
        function check() {
            var name = document.getElementById('name').value;
            var cate = document.getElementById('cate').value;
            var nation = document.getElementById('nation').value;

            if (!name & !cate & !nation) {
                alert('You must input a field');
                return false;
            } else return document.forms['searchFrm'].submit();
        }

        function submit(id) {
            let fID = 'fMwA'.concat(id);
            document.forms[fID].submit();
        }
    </script>
@endsection
