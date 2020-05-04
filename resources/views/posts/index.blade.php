@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@if($posts->count())
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Name</td>
          <td>Logo</td>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <td>{{$post->id}}</td>
            <td>{{$post->name}}</td>
            <td><img src="{{$post->logo}}" width="100px"></td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@else
create first
@endif
@endsection