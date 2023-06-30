@extends('layouts.dashboard.main')

@section('title')
{{ $category->name }}
@endsection


@section('content')
<div class="card w-75">
    <div class="card-body">
      <h5 class="card-title">Name : {{ $category->name }}</h5>
      <p class="card-text">
        Description : {{ $category->description }}</p>
    </div>
  </div>
@endsection