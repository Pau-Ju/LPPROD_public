@extends('layouts.index')

@section('content')

    <div class="container">
        @if(isset($series)&& count($series))
            <h1> Voici les <i class="fa fa-film"></i> correspondant à votre <i class="fa fa-search"></i> :</h1>
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

        @else
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="title"> Aucun résultat pour votre recherche <i class="fa fa-frown-o smiley"></i></div>
                </div>
            </div>
        @endif
        {{$series->links()}}
    </div>
@endsection