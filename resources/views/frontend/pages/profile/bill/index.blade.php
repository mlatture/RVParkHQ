@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" data-bg-parallax="{{ asset('assets/images/parallax/5.jpg') }}">
        <div class="container">
            <div class="page-title text-white text-center">
                <h1 class="display-4 fw-bold">Bill Summary</h1>
            </div>
            <div class="breadcrumb text-white-50 text-center mt-2">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="{{ route('rv-park.home') }}" class="text-white">Home</a></li>
                    <li class="list-inline-item">Bill Summary</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="container py-5">
        <div class="text-center mb-5">
            <h3 class="d-inline-block px-4 py-2 shadow-sm border rounded-pill fw-semibold">
                Bill Summary
            </h3>
        </div>
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr style="background-color: #edf0f1 !important;">
                <th class="text-center fw-bold">Name</th>
                <th class="text-center fw-bold">Schedule</th>
                <th class="text-center fw-bold">Payment</th>
                <th class="text-center fw-bold">Total</th>
                <th class="text-center fw-bold">Billing Date</th>
                <th class="text-center"></th>
            </tr>
            </thead>
            <tbody>
            @forelse($bills as $bill)
                <tr>
                    <td class="text-center">{{ $bill->subject ?? 'N/A' }}</td>
                    <td class="text-center"><span class="badge bg-info">{{ $bill->schedule }}</span></td>
                    <td class="text-center">
                        @if($bill->status == 'Paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif($bill->status == 'Pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($bill->status == 'failed')
                            <span class="badge bg-danger">Failed</span>
                        @endif
                    </td>
                    <td class="text-center">${{ number_format($bill->amount, 2) }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($bill->due_date)->format('F j, Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('rv-park.profile.bill.payments', encrypt($bill->id)) }}" class="text-primary me-2" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($bill->status == 'Pending')
                        <a href="{{ route('rv-park.pay-bill.process', $bill->payment_link_token) }}" class="text-secondary" title="Payment">
                            <i class="fas fa-credit-card"></i>
                        </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center">No Bill Summary Found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
