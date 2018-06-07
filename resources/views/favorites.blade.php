@extends('layouts.index')

@section('content')


    <div class="container">
    @if(isset($series)&& count($series))
            <h1> Vous <i class="fa fa-heart-o coeur"></i> ces séries :</h1>
            <div class="row">
            @foreach($series as $serie)
                <div class="col-xs-3 mosaique">
                    <a href="{{url('serie/'.$serie->id_Serie.'/'.$serie->name)}}" class="thumbnail">
                        <img src="{!! $serie->image_link !!}" alt="{!! $serie->name !!}"
                             class="img-responsive image"/>
                        <div class="overlay">
                            <div class="text">{!! $serie->name !!}</div>
                            <div class="delete"><i class="fa fa-trash fa-3x"></i></div>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
            {{ $series->links()}}
    @else
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title"> Aucun favoris est associé à votre compte <i class="fa fa-frown-o smiley"></i></div>
                <div class="title"> Il vous suffit de cliquer sur <i class="fa fa-heart-o coeur"></i> pour en ajouter</div>
            </div>
        </div>
    @endif
    </div>
@endsection