@extends('layouts.index')

@section('content')


    <div class="container">
        @if(isset($series)&& count($series))
            <h1> Toutes les <i class="fa fa-film"></i> :</h1>
            <div class="row">
                @foreach($series as $serie)
                    <div class="col-xs-3 mosaique">
                        <a href="{{url('serie/'.$serie->id_Serie.'/'.$serie->name)}}" class="thumbnail">
                            <img src="{!! $serie->image_link!!}" alt="{!! $serie->name !!}"
                                 class="img-responsive image"/>
                            <div class="overlay">
                                <div class="text">{!! $serie->name !!}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            {{ $series->links() }}
        @endif

    </div>

@endsection