@extends('layouts/app')
	@section('content')
		<div class="row " >
			<div class="col-md-12 col-sm-12 col-xs-12" >
                
                <div id="signInRow" class=" col-sm-offset-3 col-sm-4 {{(session()->has('signupMsg')) ? 'hide' : ''}}" >
                <h2 class="col-sm-12">Login</h2>
                @if (session()->has('signupSuccessMsg'))
                    <div class="alert alert-success">{!! session('signupSuccessMsg') !!}</div>
                @endif               
                @if (session()->has('signinMsg'))
                    <div class="alert alert-danger">{{ session('signinMsg') }}</div>
                @endif
                <form  id="frmSignIn" autocomplete="off" name="frmSignIn"  method="POST" action="{{route('signin')}}">
                    {!! Form::token() !!}
                    <div class="col-sm-12 col-xs-12 form-group">
                        {!! Form::email('username', '', array('class'=>'form-control', 'placeholder'=>'Email', 'required')) !!}
                    </div>
                    <div class="col-sm-12 col-xs-12 form-group">
                    {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password', 'required')) !!}
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            {!! Form::submit('Sign In' ,array('class'=>'btn btn-primary')) !!}
                        </div>
                        <div class="col-sm-9 col-xs-12 text-right">
                            Don't have an account?
                            <a href="#" id='createAccountBtn'>Create Account</a>
                        </div>
                      </div>
                    </div>
                </form>
                </div>
                    
                <div id="signUpRow" class=" col-sm-offset-3 col-sm-5  {{(session()->has('signupMsg')) ? 'show' : 'hide'}}" >
                <h2>Register</h2>
                @if (session()->has('signupMsg'))
                    <div class="alert alert-danger">{!! session('signupMsg') !!}</div>
                @endif
                <form  id="frmSignUp" autocomplete="off" name="frmSignUp"  method="POST" action="{{route('signup')}}">
                    {!! Form::token() !!}
                    <div class="col-sm-12 form-group col-xs-12">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                {!! Form::text('firstname', '', array('class'=>'form-control', 'placeholder'=>'First Name', 'required')) !!}
                                <span  class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                {!! Form::text('lastname', '', array('class'=>'form-control', 'placeholder'=>'Last Name', 'required')) !!}
                                <span  class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-sm-12 col-xs-12 form-group" >
                        {!! Form::email('email', '', array('class'=>'form-control', 'placeholder'=>'Email', 'required')) !!}
                        <span class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                    </div>
                    {{--<div class="col-sm-12 col-xs-12 form-group">
                        {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password', 'required')) !!}
                        <span  class="validationError">Password must be one upper and lower case, one number and one special chars.</span>
                    </div>
                    <div class="col-sm-12 col-xs-12 form-group">
                        {!! Form::password('cpassword', array('class'=>'form-control', 'placeholder'=>'Confirm Password', 'required')) !!}
                        <span  class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                    </div>
                    --}}
                    <div class="col-sm-12 col-xs-12">
                        <div class="row">
                        <div class="col-sm-5 col-xs-5">
                            {!! Form::submit('Register' ,array('class'=>'btn btn-primary')) !!}
                        </div>
                        <div class="col-sm-7 col-xs-7 text-right">
                            <a href="#" id='lnkLoginBtn'>Back To Login</a>
                        </div>
                      </div>
                    </div>
                </form>
                </div>
                
            </div>
        </div>
    @endsection
    
    @section('jsSection')
    <script>
    $(function(){
            //$("#signInRow").hide();
            //$("#signUpRow").removeClass('hide').show();
        $("#createAccountBtn").on('click', function(e) {
            e.preventDefault();
            $("#signInRow").hide();
            $("#signUpRow").removeClass('hide').show();
        });
        $("#lnkLoginBtn").on('click', function(e) {
            e.preventDefault();
            $("#signInRow").removeClass('hide').show();
            $("#signUpRow").removeClass('show').hide();
        });
    });
    
    
</script>
@stop