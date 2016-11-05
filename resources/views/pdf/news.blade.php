<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>
	<body class="bodyBg" >
    <section class="centerRow">
        <div style="width:720px;">
            <h2>{{$news->title}}</h2>
            <div  style="width:100%">Published On {{$news->created_at->format('M j, Y @ g:i a')}} By {{$news->user->name}}</div>
            <div  style="width:100%">{!!$news->description!!}</div>
            @if($news->filepath)
            <div  style="width:100%"><img src="{{url($news->filepath)}}" style="max-width:720px"></div>
            @endif
        </div>
	</section>
    <section class="footerRow" style="bottom:0; position:absolute">
		
	</section>
    </body>
</html>