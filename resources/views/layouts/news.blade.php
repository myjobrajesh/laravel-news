@extends('layouts/app')
	@section('content')
		<div class="row " >
			<div class="col-md-12 col-sm-12 col-xs-12" >
                <div class="newsRow">
                    @if($news)
                        <h2>{{$news->title}}</h2>
                        <div>Published On {{$news->created_at->format('M j, Y @ g:i a')}} By {{$news->user->name}}</div>
                        <div class="downloadPdf"><a href="{{route('newsdownload', $news->slug)}}">Download PDF</a></div>    
                        <div>{!!$news->description!!}</div>
                        @if($news->filepath)
                        <div ><img src="{{$news->filepath}}" class="img-responsive"></div>
                        @endif
                    @else
                        No news available
                    @endif
                </div>
            </div>
        </div>

    @endsection
    