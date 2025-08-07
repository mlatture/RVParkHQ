@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" data-bg-parallax="{{ asset('assets/images/parallax/5.jpg') }}">
        <div class="container">
            <div class="page-title text-white text-center">
                <h1 class="display-4 fw-bold">Bill Payments</h1>
            </div>
            <div class="breadcrumb text-white-50 text-center mt-2">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="{{ route('rv-park.home') }}" class="text-white">Home</a></li>
                    <li class="list-inline-item"><a href="{{ route('rv-park.profile.bill') }}" class="text-white">Bill Summary</a></li>
                    <li class="list-inline-item">Bill Payments</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="container py-5">
        <div class="text-center mb-5">
            <h3 class="d-inline-block px-4 py-2 shadow-sm border rounded-pill fw-semibold">
                Bill Payments
            </h3>
        </div>
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr style="background-color: #edf0f1 !important;">
                <th class="text-center fw-bold">Bill</th>
                <th class="text-center fw-bold">Paid Amount</th>
                <th class="text-center fw-bold">Status</th>
                <th class="text-center fw-bold">Date</th>
                <th class="text-center fw-bold"></th>
            </tr>
            </thead>
            <tbody>
            @forelse($payment_history as $payment)
                <tr>
                    <td class="text-center">{{ $payment->bill->subject ?? 'N/A' }}</td>
                    <td class="text-center">${{ number_format($payment->amount, 2) }}</td>
                    <td class="text-center">
                        @if($payment->status == 'success')
                            <span class="badge bg-success">Paid</span>
                        @elseif($payment->status == 'duplicate')
                            <span class="badge bg-info">Duplicate</span>
                        @else
                            <span class="badge bg-danger">Failed</span>
                        @endif
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($payment->processed_at)->format('F j, Y') }}</td>
                    @if($payment->status == 'failed')
                        <td class="text-center">
                            <a href="{{ route('rv-park.pay-bill.card', encrypt($payment->id)) }}" class="text-secondary" title="Payment">
                                <i class="fas fa-credit-card"></i>
                            </a>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center">No payment history found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
