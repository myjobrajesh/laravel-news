@extends('layouts/app')
    @section('topMenu')
        <li><a href="#" id="addNewArticleLnk">Add New News/Article</a></li>
    @endsection
    
	@section('content')
		<div class="row " >
			<div class="col-md-12 col-sm-12 col-xs-12" >
                <div class="newsListRow">
                    @if (session()->has('newsSuccessMsg'))
                        <div class="alert alert-success">{!! session('newsSuccessMsg') !!}</div>
                    @endif
                    
                    @if($myNews->total())
                        <h2>My News</h2>
                        <ul class="list-unstyled">
                        @foreach($myNews as $news)
                            <li class="col-sm-12" >
                                <span class="col-sm-11">
                                <a href="{{route('newsdetail', $news->slug)}}">{{$news->title}}</a>
                                </span>
                                <span class="col-sm-1"><a href="#" class="deleteNews" data-id="{{$news->id}}"><i class="glyphicon glyphicon-trash"></i></a></span>
                            </li>
                        @endforeach
                        <li>{{$myNews->links()}}</li>
                        </ul>
                        @else
                            No news available
                    @endif
                </div>
                <div class="articleFormRow hide">
                    <h2>Add / Publish News</h2>
                    
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('newsMsg'))
                        <div class="alert alert-danger">{{ session('newsMsg') }}</div>
                    @endif
                    <form  id="frmAdd" autocomplete="off" name="frmAdd"  method="POST" action="{{route('addnews')}}" enctype="multipart/form-data">
                        {!! Form::token() !!}
                        
                        <div class="col-sm-12 col-xs-12 form-group">
                            {!! Form::text('title', '',  array('class'=>'form-control', 'placeholder'=>'Title', 'required')) !!}
                            <span  class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                        </div>
                        <div class="col-sm-12 col-xs-12 form-group">
                            {{Form::textarea('description','',array('class' => 'form-control', 'placeholder'=>'Description', 'id' => 'description'))}}
                            <span  class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                        </div>
                        <div class="col-sm-12 col-xs-12 form-group">
                            {!! Form::file('file', '',  array('class'=>'form-control', 'placeholder'=>'Title', 'required')) !!}
                            <span  class="validationError"><i class="glyphicon glyphicon-asterisk"></i></span>
                        </div>
                            
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                            <div class="col-sm-5 col-xs-5">
                                {!! Form::submit('Publish News' ,array('class'=>'btn btn-primary')) !!}
                            </div>
                          </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        
        <div class="modal  fade " id="confirm" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body" >
                 Are you sure you want to delete this news?
                 <form action ="{{route('newsdelete')}}" method="POST">
                        {!! Form::token() !!}
                        {!!Form::hidden("newsId", '')!!}
                  </form>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>    
            
    @endsection
    
    @section('jsSection')
        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
        <script src="{!!asset('/js/summernote.js')!!}"></script>
    <script>
    $(function(){
        $('#description').summernote({
            height:300,
        });
        
        $("#addNewArticleLnk").on('click', function(e) {
            e.preventDefault();
            $(".newsListRow").removeClass('show').hide();
            $(".articleFormRow").removeClass('hide').show();
            
        });
        
        $(".deleteNews").on('click', function(e) {
            e.preventDefault();
            var newsId = $(this).data("id");
            var formObj = $('#confirm form');
            formObj.find("input[name='newsId']").val(newsId);
            
            $('#confirm').modal('show')
            .one('click', '#delete', function() {
                formObj.submit();
            });
            
        });
        
    });
    
    
</script>
@stop