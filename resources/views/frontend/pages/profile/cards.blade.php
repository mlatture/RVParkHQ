@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" data-bg-parallax="assets/images/parallax/5.jpg">
        <div class="container">
            <div class="page-title text-white text-center">
                <h1 class="display-4 fw-bold">Payment Method</h1>
            </div>
            <div class="breadcrumb text-white-50 text-center mt-2">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="{{ route('rv-park.home') }}" class="text-white">Home</a></li>
                    <li class="list-inline-item">Payment Method</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="container-fluid py-5" style="background-color: #f8f9fa;">
        <div class="container">

            {{-- Summary and Add Button --}}
            <div class="d-flex justify-content-between align-items-center p-3 mb-4 bg-white rounded shadow-sm" style="background-color: #edf0f1 !important;">
                <div>
                <span class="text-success fw-bold">
                    <i class="bi bi-check-circle-fill"></i>
                    You have {{ $cards->count() }} active payment method{{ $cards->count() > 1 ? 's' : '' }}
                </span>
                </div>
                <a class="btn btn-primary" href="#modalCard" data-lightbox="inline">Add payment method</a>
            </div>

            <div class="bg-white rounded shadow-sm p-0">
                <div class="border-bottom px-4 py-3 bg-light" style="background-color: #edf0f1 !important;">
                    <h5 class="mb-0 fw-bold">Payment method list</h5>
                </div>

                @forelse($cards as $card)
                    <div class="d-flex align-items-center px-4 py-3 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-bold fs-5">
                                {{ substr($card->card_number, 0, 6) }}******{{ substr($card->card_number, -4) }}
                            </div>
                            <div class="text-muted small">
                                Credit Card &nbsp;|&nbsp; Expires {{ $card->expiry }} &nbsp;|&nbsp;
                                <span class="badge bg-secondary ms-2">DEFAULT METHOD</span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('rv-park.profile.delete-card', $card->id) }}"
                              style="display:inline; margin-left: 10px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this card?')">
                                Delete
                            </button>
                        </form>

                        <span class="ms-3 text-muted" style="font-size: 1.5rem;">&#8250;</span>
                    </div>
                @empty
                    <div class="px-4 py-4 text-center text-muted">No cards found.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="modalCard" class="modal no-padding" data-delay="3000" style="max-width: 580px;">
        <div class="row">
            <div class="col-md-12">
                <div class="p-40 p-t-60 p-xs-20">
                    <h3>Add New Card</h3>
                    <form id="addCardForm" class="form-grey-fields" method="POST" action="{{ route('rv-park.profile.add-card') }}">
                        @csrf
                        @if ($errors->has('card_number') || $errors->has('expiry') || $errors->has('cvc'))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="text" name="card_number" id="card_number" class="form-control"
                                   placeholder="Card Number" required value="{{ old('card_number') }}" maxlength="16"
                                   minlength="16" pattern="\d{16}" inputmode="numeric" autocomplete="cc-number">
                            <div id="cardNumberError" class="text-danger mt-1" style="display:none;"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="expiry" class="form-label">Expiry Date</label>
                            <input type="text" name="expiry" id="expiry" class="form-control" placeholder="MM / YY"
                                   required value="{{ old('expiry') }}" pattern="\d{2}/\d{2}" onblur="formatExpiration(this)">
                            <div id="expiryError" class="text-danger mt-1" style="display:none;"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="cvc" class="form-label">CVC</label>
                            <input type="text" name="cvc" id="cvc" class="form-control" placeholder="CVC" required
                                   value="{{ old('cvc') }}" maxlength="4" minlength="3" pattern="\d{3,4}" inputmode="numeric" autocomplete="cc-csc">
                        </div>
                        <div class="text-start mb-3">
                            <button type="submit" class="btn btn-success w-100">Add Card</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function showAddCardModal() {
            document.getElementById('addCardModal').style.display = 'block';
        }

        function hideAddCardModal() {
            document.getElementById('addCardModal').style.display = 'none';
        }

        function luhnCheck(cardNumber) {
            let sum = 0;
            let shouldDouble = false;
            for (let i = cardNumber.length - 1; i >= 0; i--) {
                let digit = parseInt(cardNumber.charAt(i));
                if (shouldDouble) {
                    digit *= 2;
                    if (digit > 9) digit -= 9;
                }
                sum += digit;
                shouldDouble = !shouldDouble;
            }
            return (sum % 10) === 0;
        }
        var cardInput = document.getElementById('card_number');
        var errorDiv = document.getElementById('cardNumberError');
        cardInput.addEventListener('input', function() {
            var cardNumber = cardInput.value.replace(/\D/g, '');
            if (cardNumber.length === 16) {
                if (!luhnCheck(cardNumber)) {
                    errorDiv.textContent = 'Please enter a valid card number.';
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.textContent = '';
                    errorDiv.style.display = 'none';
                }
            } else if (cardNumber.length > 0 && cardNumber.length < 16) {
                errorDiv.textContent = 'Card number must be 16 digits.';
                errorDiv.style.display = 'block';
            } else {
                errorDiv.textContent = '';
                errorDiv.style.display = 'none';
            }
        });
        document.getElementById('addCardForm').addEventListener('submit', function(e) {
            var cardNumber = cardInput.value.replace(/\D/g, '');
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            if (cardNumber.length !== 16 || !luhnCheck(cardNumber)) {
                errorDiv.textContent = 'Please enter a valid card number.';
                errorDiv.style.display = 'block';
                cardInput.focus();
                e.preventDefault();
                return false;
            }
        });

        function isFutureExpiry(expiry) {
            // Format: MM/YY
            if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) return false;
            var parts = expiry.split('/');
            var month = parseInt(parts[0], 10);
            var year = parseInt(parts[1], 10);
            // Convert 2-digit year to 4-digit year (assume 2000-2099)
            year += 2000;
            if (month < 1 || month > 12) return false;
            var now = new Date();
            var expDate = new Date(year, month - 1, 1);
            // Set to end of month
            expDate.setMonth(expDate.getMonth() + 1);
            expDate.setDate(0);
            // Must be after today
            return expDate > now;
        }
        var expiryInput = document.getElementById('expiry');
        var expiryError = document.getElementById('expiryError');
        expiryInput.addEventListener('input', function() {
            var val = expiryInput.value;
            if (val.length === 5) {
                if (!isFutureExpiry(val)) {
                    expiryError.textContent = 'Please enter a valid future expiry date (MM/YY).';
                    expiryError.style.display = 'block';
                } else {
                    expiryError.textContent = '';
                    expiryError.style.display = 'none';
                }
            } else if (val.length > 0 && val.length < 5) {
                expiryError.textContent = 'Expiry must be in MM/YY format.';
                expiryError.style.display = 'block';
            } else {
                expiryError.textContent = '';
                expiryError.style.display = 'none';
            }
        });
        document.getElementById('addCardForm').addEventListener('submit', function(e) {
            var val = expiryInput.value;
            expiryError.style.display = 'none';
            expiryError.textContent = '';
            if (!isFutureExpiry(val)) {
                expiryError.textContent = 'Please enter a valid future expiry date (MM/YY).';
                expiryError.style.display = 'block';
                expiryInput.focus();
                e.preventDefault();
                return false;
            }
        });

        function formatExpiration(input) {
            let value = input.value.replace(/\s+/g, '').replace(/[^0-9\/]/g, '');
            let parts = value.split('/');
            if (parts.length === 2) {
                let month = parts[0].padStart(2, '0').slice(0,2);
                let year = parts[1].padStart(2, '0').slice(0,2);
                input.value = month + '/' + year;
            } else if (parts.length === 1 && value.length > 0) {
                let month = parts[0].padStart(2, '0').slice(0,2);
                input.value = month + '/';
            }
        }

        // Only allow numbers in card_number and cvc fields
        cardInput.addEventListener('keypress', function(e) {
            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }
        });
        document.getElementById('cvc').addEventListener('keypress', function(e) {
            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }
        });
    </script>
@endsection
