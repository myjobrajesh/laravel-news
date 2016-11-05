@extends('emails/email')
@section('content')
        <p>To activate your {{config('app.siteName')}} account please click or paste the URL below into your browser. </p>
        <p><a style="color:#055106" href='{{ URL::to('activateuser', array($verificationCode)) }}'>{{ URL::to('activateuser', array($verificationCode)) }}</a></p>
        
@endsection