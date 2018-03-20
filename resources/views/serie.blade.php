@extends('layouts.index')

@section('content')


    <div class="container">
            <h1> Informations sur la <i class="fa fa-film"></i>:</h1>
            <div class="row">
                    <div class="col-xs-3 mosaique">
                        <a href="{!! $serie->url !!}" class="thumbnail">
                            <img src="{!! $serie->url !!}" alt="{!! $serie->name !!}"
                                 class="img-responsive image"/>
                            <div class="overlay">
                                <div class="text">{!! $serie->name !!}</div>
                            </div>
                        </a>
                    </div>

            </div>
    </div>
@endsection