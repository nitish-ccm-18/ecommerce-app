@extends('layouts.app')

@section('title')
    Welcome
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light mt-3 mb-5 ">
        <!-- Container wrapper -->
        <div class="container-fluid">

            <!-- Navbar brand -->
            <strong>Categories:</strong>


            <!-- Collapsible wrapper -->
            <div class="navbar-collapse overflow-auto" id="">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">

                    <!-- Link -->
                    <li class="nav-item acitve">
                        <a class="nav-link" href="/">All</a>
                    </li>
                    @isset($categories)
                        @foreach ($categories as $category)
                            <li class="nav-item">
                                <a href="/{{ $category->id }}" class="nav-link">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    @endisset

                </ul>
            </div>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->

    <!-- Products -->
    <section>
        <div class="alert d-none" id="add_to_cart_msg">
            <strong>Success!</strong> Item added to cart
        </div>
        <div class="text-center">
            <div class="row" id="ProductViewer">
                @if ($products && $products->isNotEmpty())
                    @foreach ($products as $id => $product)
                        <div class="col-lg-2 col-md-2 mb-4" data-id="{{ $product->id }}">
                            <div class="card">
                                <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
                                    data-mdb-ripple-color="light">
                                    <img src="{{ url('public/Image/Products/' . $product->image) }}" width="200px"
                                        height="200px" />
                                    <a href="#!">
                                        <div class="mask">
                                            <div class="d-flex justify-content-start align-items-end h-100">
                                                <h5><span
                                                        class="badge bg-dark ms-2">{{ $product->featured ? 'Featured' : '' }}</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="hover-overlay">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <a href="/products/{{ $product->id }}" class="text-reset">
                                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                                    </a>
                                    <a href="" class="text-reset ">
                                        <p>{{ $product->category->name }}</p>
                                    </a>
                                    <div class="mb-3">
                                        <span class=" price">$ {{ $product->sale_price }}</span>
                                        <del class="text-muted">{{ $product->price }}</del>
                                    </div>
                                    <button type="button" class="btn btn-success addtocart"
                                        data-product-id={{ $product->id }}><i class="fa-solid fa-cart-plus "></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center mt-3">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="d-flex justify-content-center mt-3">
                        <h3 class="text-center">Products will be uploaded soon.</h3>
                    </div>
                @endif
            </div>

            @push('scripts')
                <script>
                    $('.addtocart').click(function(e) {
                        e.preventDefault();
                        var product_id = $(this).attr('data-product-id');

                        $.ajax({
                            url: '{{ route('cart.add') }}',
                            method: 'post',
                            data: {
                                _token: '{{ csrf_token() }}',
                                product_id: product_id
                            },
                            success: function(response) {
                                $('#add_to_cart_msg')
                                    .addClass('alert-success')
                                    .removeClass('d-none')

                                setTimeout(() => {
                                    $('#add_to_cart_msg').addClass('d-none');
                                }, 2000);
                                getCartCount();
                            }
                        });
                    });
                </script>
            @endpush
        @endsection
