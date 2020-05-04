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
        
        <!-- image -->
          <div class="form-group col-md-6 @error('image') has-error @enderror">
              {!! Form::label('image', 'Upload Logo') !!}
              <div class="position-relative">
                  {!! Form::file('image', ['class' => 'form-control', 'placeholder' => 'Choose an Image', 'required' => 'true', 'id' => 'image', 'accept'=>'image/*']) !!}
              </div>
              <div class="help-block"></div>
              @error('image')
                <span class="help-block">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>
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