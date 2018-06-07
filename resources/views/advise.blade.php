@extends('layouts.index')

@section('content')
    <div class="container">
        @if(isset($series)&& count($series))
            <h1> Nous vous <i class="fa fa-tripadvisor"></i> ces <i class="fa fa-film"></i>:</h1>
            <div class="row">
                @foreach($series as $serie)
                    <div class="col-xs-3 mosaique">
                        <a href="{{url('serie/'.$serie->id.'/'.$serie->name)}}" class="thumbnail">
                            <img src="{!! $serie->image_link !!}" alt="{!! $serie->name !!}"
                                 class="img-responsive image"/>
                            <div class="overlay">
                                <div class="text">{!! $serie->name !!}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            {{ $series->links()}}
            @else
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="title"> Pour être <i class="fa fa-tripadvisor"></i></div>
                    <div class="title"> Il vous suffit de cliquer sur <i class="fa fa-heart-o coeur"></i> et/ou <i class="fa fa-star-o"></i></div>
                </div>
            </div>
        @endif

    </div>
@endsection