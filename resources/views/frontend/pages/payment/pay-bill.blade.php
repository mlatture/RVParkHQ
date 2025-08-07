@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" data-bg-parallax="assets/images/parallax/5.jpg">
        <div class="container">
            <div class="page-title text-white text-center">
                <h1 class="display-4 fw-bold">Payment</h1>
            </div>
            <div class="breadcrumb text-white-50 text-center mt-2">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="{{ route('rv-park.home') }}" class="text-white">Home</a></li>
                    <li class="list-inline-item">Payment</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Pay Your Bill</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <h5>Invoice Details</h5>
                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Subject:</strong> {{ $bill->subject }}</li>
                            <li class="list-group-item"><strong>Description:</strong> {{ $bill->description }}</li>
                            <li class="list-group-item"><strong>Amount:</strong> ${{ number_format($bill->amount, 2) }}
                            </li>
                            <li class="list-group-item"><strong>Status:</strong> <span
                                    class="badge {{ $bill->status === 'paid' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($bill->status) }}</span>
                            </li>
                            <li class="list-group-item"><strong>Due
                                    Date:</strong> {{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('F d, Y') : 'N/A' }}
                            </li>
                        </ul>

                        <h5>Your Information</h5>
                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Name:</strong> {{ auth()->user()->name }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ auth()->user()->email }}</li>
                        </ul>

                        @if($bill->status !== 'paid')
                            <form method="POST" action="{{ route('rv-park.pay-bill.process', $bill->payment_link_token) }}">
                                @csrf
                                @if($cards->count())
                                    <div class="mb-3">
                                        <label for="card_option" class="form-label">Select Card</label>
                                        <select class="form-control" id="card_option" name="card_option"
                                                onchange="toggleCardFields(this.value)">
                                            @foreach($cards as $card)
                                                <option value="{{ $card->id }}">**** ****
                                                    **** {{ substr($card->card_number, -4) }} ({{ $card->expiry }})
                                                </option>
                                            @endforeach
                                            <option value="new">Add New Card</option>
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="card_option" value="new">
                                @endif
                                <div id="card-fields" style="display: {{ $cards->count() ? 'none' : 'block' }};">
                                    <div class="mb-3">
                                        <label for="card_number" class="form-label">Card Number</label>
                                        <input type="text" class="form-control" id="card_number"
                                               name="card_number" {{ $cards->count() ? '' : 'required' }}>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expiry" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry" name="expiry"
                                               placeholder="MM/YY" {{ $cards->count() ? '' : 'required' }}>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cvc" class="form-label">CVC</label>
                                        <input type="text" class="form-control" id="cvc"
                                               name="cvc" {{ $cards->count() ? '' : 'required' }}>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Pay
                                    ${{ number_format($bill->amount, 2) }}</button>
                            </form>
                            <script>
                                function toggleCardFields(val) {
                                    document.getElementById('card-fields').style.display = (val === 'new') ? 'block' : 'none';
                                    // Set required attribute dynamically
                                    document.getElementById('card_number').required = (val === 'new');
                                    document.getElementById('expiry').required = (val === 'new');
                                    document.getElementById('cvc').required = (val === 'new');
                                }
                            </script>
                        @else
                            <div class="alert alert-success mt-3">This bill has already been paid.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
