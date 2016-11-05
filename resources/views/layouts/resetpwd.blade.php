@extends('layouts/app')
	@section('content')
		<div class="row " >
			<div class="col-md-12 col-sm-12 col-xs-12" >
                
                <div  class=" col-sm-offset-3 col-sm-4" >
                <h2 class="col-sm-12">Change Password</h2>
                @if (session()->has('pwdSuccessMsg'))
                    <div class="alert alert-success">{!! session('pwdSuccessMsg') !!}</div>
                @endif               
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('pwdMsg'))
                    <div class="alert alert-danger">{{ session('pwdMsg') }}</div>
                @endif
                <form  id="frmPwd" autocomplete="off" name="frmPwd"  method="POST" action="{{route('resetpwd')}}">
                    {!! Form::token() !!}
                    {!! Form::hidden('verificationCode', $verificationCode) !!}
                    
                    <div class="col-sm-12 col-xs-12 form-group">
                        {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password', 'required')) !!}
                        <span  class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                        <span  class="validationError">Password must be one upper and lower case, one number and one special chars.</span>
                    </div>
                    <div class="col-sm-12 col-xs-12 form-group">
                        {!! Form::password('cpassword', array('class'=>'form-control', 'placeholder'=>'Confirm Password', 'required')) !!}
                        <span  class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                    </div>	
                    
                    <div class="col-sm-12 col-xs-12">
                        <div class="row">
                        <div class="col-sm-5 col-xs-5">
                            {!! Form::submit('Change password' ,array('class'=>'btn btn-primary')) !!}
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

    });
    
    
</script>
@stop