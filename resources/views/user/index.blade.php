@extends('layouts.front.default')

@section('content')
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Shop in style</h1>
                <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                @forelse ($product as $product)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            @if ($product->image)
                                <img class="card-img-top" src="{{ asset('images/' . $product->image) }}" width="300px" />
                            @else
                                <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg"
                                    alt="..." />
                            @endif
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                                    <div class="d-flex justify-content-center small mb-2">
                                        {{ $product->rates->rate_limit }} | {{ $product->duration }}
                                    </div>

                                    <!-- Product reviews-->
                                    <!-- Product price-->
                                    Rp {{ number_format($product->price) }}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <form class="form-horizontal" method="POST" action="{{ route('order.store') }}">
                                        @method('POST')
                                        @csrf
                                        <input type="hidden" name="user_id" value={{ Auth::user()->id }}>
                                        <input type="hidden" name="product_id" value={{ $product->id }}>
                                        <button class="btn btn-outline-dark mt-auto" id="pay-button">Beli</button>
                                    </form>
                                </div>
                                {{-- <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Beli</a></div> --}}
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse


            </div>
        </div>
    </section>
@endsection
