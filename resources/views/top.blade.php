@extends('layouts.index')

@section('content')

    <div class="container">
        @if(isset($series)&& count($series))
            <h1> Séries les mieux notées <i class="fa fa-star-o"></i>:</h1>
            <div class="row">
                @foreach($series as $serie)
                    <div class="col-xs-3 mosaique">
                        <a href="{{url('serie/'.$serie->id.'/'.$serie->name)}}" class="thumbnail">
                            <img src="{!! $serie->url !!}" alt="{!! $serie->name !!}"
                                 class="img-responsive image"/>
                            <div class="overlay">
                                <div class="text">{!! $serie->name !!}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            {{ $series->links()}}
        @endif

    </div>
@endsection