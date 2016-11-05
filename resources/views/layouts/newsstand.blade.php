@extends('layouts/app')
    @section('content')
		<div class="row " >
			<div class="col-md-12 col-sm-12 col-xs-12" >
                <div class="newsListRow">
                    @if($newsList->count())
                        <h2>Latest News</h2>
                        <ul class="list-unstyled">
                        @foreach($newsList as $news)
                            <li class="col-sm-12" >
                                <span class="col-sm-11">
                                <a href="{{route('newsdetail', $news->slug)}}">{{$news->title}}</a>
                                </span>
                                
                            </li>
                        @endforeach
                        </ul>
                        @else
                            No news available.
                    @endif
                </div>
                
            </div>
        </div>

    @endsection
    
