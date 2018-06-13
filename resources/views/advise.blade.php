@extends('layouts.index')

@section('content')
    <div class="container">
        @if(isset($series)&& count($series))
            <h1> Nous vous <i class="fa fa-tripadvisor"></i> ces <i class="fa fa-film"></i>:</h1>
            <div class="row">
                @foreach($series as $serie)
                    <div class="col-xs-3 mosaique">
                        <a href="{{url('serie/'.$serie->id_Serie.'/'.str_replace(" ", "-", $serie->name))}}" class="thumbnail">
                            <img src="{!! $serie->image_link !!}" alt="{!! ucfirst(strtolower($serie->name)) !!}"
                                 class="img-responsive image"/>
                            <div class="overlay">
                                <div class="text">{!! ucfirst(strtolower($serie->name))!!}</div>

                                @php($id = $serie->id_Serie)
                                @auth
                                    <div class="rating">
                                        <div id='series-{{$id}}'><script type='text/javascript'>CreateListeEtoile('series-{{$id}}',{{$serie->note}});</script></div>
                                    </div>
                                    <div class="favorites">
                                        <div id='favorites-{{$id}}'><script type='text/javascript'>CreateFavorites('favorites-{{$id}}');</script></div>
                                    </div>

                                @endauth
                            </div>
                        </a>
                        <div class="moyenne">
                            @switch($serie->moyenne)
                                @case(0)
                                <img src="images\notation\0.png">
                                @break
                                @case(0.5)
                                <img src="images\notation\05.png">
                                @break
                                @case(1)
                                <img src="images\notation\1.png">
                                @break
                                @case(1.5)
                                <img src="images\notation\15.png">
                                @break
                                @case(2)
                                <img src="images\notation\2.png">
                                @break
                                @case(2.5)
                                <img src="images\notation\25.png">
                                @break
                                @case(3)
                                <img src="images\notation\3.png">
                                @break
                                @case(3.5)
                                <img src="images\notation\35.png">
                                @break
                                @case(4)
                                <img src="images\notation\4.png">
                                @break
                                @case(4.5)
                                <img src="images\notation\45.png">
                                @break
                                @case(5)
                                <img src="images\notation\5.png">
                                @break
                            @endswitch
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $series->links()}}
            @else
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="title"> Pour être recommandé</div>
                    <div class="title"> Il vous suffit de cliquer sur <i class="fa fa-heart-o coeur"></i> et/ou <i class="fa fa-star-o"></i></div>
                </div>
            </div>
        @endif

    </div>
@endsection

@section('script')
    @auth
        <script src="{{ asset('js/notation.js') }}"></script>
        <script src="{{ asset('js/favoris.js') }}"></script>
    @endauth
@endsection