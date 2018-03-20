@extends('layouts.index')

@section('content')


    <div class="container">
        @if(isset($last)&& count($last))
            <h1> Les dernières <i class="fa fa-film"></i> ajoutées :</h1>
            <div class="row">
                @foreach($last as $serie)
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
            @endif
    </div>

@endsection