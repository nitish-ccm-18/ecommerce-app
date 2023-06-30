@extends('layouts.dashboard.main')

@section('title')
   Products 
@endsection


@section('content')
<div class="container-fluid">
  <a href="{{ route('products.create')}}" class="btn btn-primary btn-sm mb-2">+ Products</a>
  <div class="row">
          <table class="table" id="products_table">
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Weight</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Launch</th>
                </tr>
            </thead>
            <tbody>
              
              @foreach ($categories as $category)
                @foreach ($category->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->weight }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->status ? "Active" : "Inactive" }}</td>
                    <td><img src="{{ url('public/Image/Products/'.$product->image)}}" alt="" width="100" height="100"></td>
                    <td>{{ $product->created_at }}</td>
                    <td>
                      <a href="{{ route('products.show',['id'=>$product->id]) }}" class="btn btn-success">Show</a>
                      <a href="/products/edit/{{$product->id}}" class="btn btn-warning">Edit</a>
                      <a href="{{ route('products.status.change',['id'=>$product->id]) }}" class="btn btn-primary">Active</a>
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
  </div>
</div>

@push('head')

@endpush
    
@endsection