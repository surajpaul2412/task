@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-body">
    {!! Form::open(['method' => 'POST', 'action' => 'PostController@store', 'class' => 'form-row', 'files'=>true]) !!}
      <h3 class="pt-3 px-3">Create Post</h3>
      <hr>
      <div class="form-body form-row px-3 py-2">
        <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name') !!}
            <div class="position-relative">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'required' => 'true', 'id' => 'question','data-validation-required-message'=>"This field is required",'minlength'=>3,'maxlength'=>191,'data-validation-minlength-message'=>'Name cannot be less than 3 characters','data-validation-maxlength-message'=>'Name cannot be more than 255 characters']) !!}
            </div>
            <div class="help-block"></div>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        
        <!-- logo -->
          <div class="form-group col-md-6 @error('logo') has-error @enderror">
              {!! Form::label('logo', 'Upload Logo') !!}
              <div class="position-relative">
                  {!! Form::file('logo', ['class' => 'form-control', 'placeholder' => 'Choose your Logo', 'required' => 'true', 'id' => 'logo', 'accept'=>'logo/*']) !!}
              </div>
              <div class="help-block"></div>
              @error('logo')
                <span class="help-block">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>

        <!-- image -->
        <div class="form-group col-md-10 {{ $errors->has('image') ? ' has-error' : '' }}">
            {!! Form::label('image', 'Image') !!}

            <div class="position-relative">
                {!! Form::file('image[]', ['class' => 'form-control', 'id' => 'image']) !!}
            </div>
        </div>
        
        <div class="form-group col-md-2">
            {!! Form::label('add_image', 'Add Image') !!}
            <div class="position-relative">
                <button type="button" class="btn btn-success mr-1" id="add_image">
                  <i class="ft-plus"></i> Add Image
                </button>
            </div>
        </div>

        <div id="more_images">
            
        </div>

        <div class="form-group col-md-12">
            @if ($errors->has('image.*'))
                <span class="help-block">
                    <strong>All images must be in the ratio (5:3) and less than 2 Mb.</strong>
                </span>
            @endif
        </div>
        <!-- end image -->
      </div>
      <div class="form-actions pb-3" align="center">
        <a href="{{ route('posts.index') }}"><button type="button" class="btn btn-warning mr-1">
          <i class="ft-x"></i> Cancel
        </button></a>
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-check-square-o"></i> Save
        </button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add_image').click(function(e){ 
                e.preventDefault();
                    $('#more_images').append('<div><div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}"><div class="position-relative">{!! Form::file('image[]', ['class' => 'form-control', 'required' => 'true', 'id' => 'image']) !!}</div></div><div class="form-group"><div class="position-relative"><button type="button" class="btn btn-danger" id="remove_image"><i class="ft-minus"></i> Remove Image</button></div></div></div>');
            });
            
            $('#more_images').on("click","#remove_image", function(e){ 
                e.preventDefault(); $(this).parent('div').parent('div').parent('div').remove();
            })
        });
    </script>
@endsection