<div id="modalClaimPark" class="modal no-padding" data-delay="3000" style="max-width: 780px;">
    <div class="row">
        <div class="col-md-12">
            <div class="p-40 p-t-60 p-xs-20">
                <h3 class="mb-4">Claim This Park</h3>

                <form class="form-grey-fields" method="POST" action="{{ route('rv-park.claim-park.store') }}">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <input name="park_id" type="hidden" value="{{ $parks->id }}">
                    <div class="row">
                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="park_name" class="form-label">Park Name</label>
                            <input type="text" name="park_name" id="park_name" value="{{ $parks->name }}" class="form-control" placeholder="Enter Park Name" readonly>
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="park_url" class="form-label">Park URL</label>
                            <input type="text" name="park_url" id="park_url" class="form-control" placeholder="Enter Park URL">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="address_line_1" class="form-label">Address Line 1</label>
                            <input type="text" name="address_line_1" id="address_line_1" class="form-control" placeholder="123 Main St">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="address_line_2" class="form-label">Address Line 2</label>
                            <input type="text" name="address_line_2" id="address_line_2" class="form-control" placeholder="Suite, Apt, etc.">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" id="city" class="form-control" placeholder="City">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" name="state" id="state" class="form-control" placeholder="State">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-4">
                            <label for="zip" class="form-label">Zip Code</label>
                            <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip Code">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required>
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number">
                        </div>

                        <div class="form-group mb-3 col-12">
                            <label for="message" class="form-label">Message (Optional)</label>
                            <textarea name="message" id="message" class="form-control" rows="3" placeholder="Write a short message (optional)"></textarea>
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="password" class="form-label">Password <small>(Set your login credentials)</small></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Create a Password" required>
                        </div>
                    </div>

                    <div class="text-start mb-3">
                        <button type="submit" class="btn btn-primary w-100">Submit Claim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>