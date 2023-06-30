@extends('layouts.dashboard.main')

@section('title')
   Categories
@endsection


@section('content')
<div class="container-fluid">
  <a href="{{route('categories.create')}}" class="btn btn-primary btn-sm mb-2">+ Categories</a>
  <table class="table">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">status</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($categories as $category)
          <tr>
              <td>{{ $category->name }}</td>
              <td>{{ $category->status == 0 ? "Inactive" : "Active" }}</td>
              <td><a href="{{ route('categories.show', ['id' => $category->id ]) }}" class="btn btn-primary btn-sm">Show</a></td>
              <td><a href="/categories/edit/{{ $category->id }}" class="btn btn-primary btn-sm">Edit</a></td>
              <td>
                <a href="{{ route('categories.status.change', ['id' => $category->id ]) }}"
                class=""><i class="fa-solid fa-toggle-{{ $category->status ? 'on' : 'off' }} fa-2xl"></i></a>
        </td>
            </tr>
          @endforeach
      </tbody>
  </table> 
</div>

  @push('scripts') 
  <script>
  </script>
  @endpush 

@endsection