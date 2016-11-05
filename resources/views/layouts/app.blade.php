@include("layouts.partials.header")
	<section class="centerRow">
        <div class="col-sm-12 col-md-12 col-xs-12 topMenu">
            <ul class="list-unstyled list-inline">
                @if(Auth::check())
                <li><a href="{{route('dashboard')}}" class="{{ (Request::is('dashboard')) ? 'active' : ''}}">My News</a></li>
                @endif
                @yield('topMenu')
                <li><a href="{{route('newsstand')}}" class="{{ (Request::is('/')) ? 'active' : ''}}" >NewsStand</a></li>
                <li><a href="{{route('newsrss')}}" target="_blank">RSS Feed</a></li>    
                
                @if(Auth::check())
                <li><a href="{{route('signout')}}">Logout</a></li>
                @else
                    <li><a href="{{route('login')}}"  class="{{ (Request::is('login')) ? 'active' : ''}}">SignIn OR Register</a></li>
                @endif
            </ul>
        </div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
			        @yield('content')
				</div>
			</div>
        </div>
	</section>
@include("layouts.partials.footer")
