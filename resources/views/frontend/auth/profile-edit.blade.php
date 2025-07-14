<div id="modalProfileEdit" class="modal no-padding" data-delay="3000" style="max-width: 580px;">
    <div class="row">
        <div class="col-md-12">
            <div class="p-40 p-t-60 p-xs-20">
                <h3 class="mb-4">Edit Profile</h3>

                <form class="form-grey-fields" method="POST" action="{{ route('modal.profile.update') }}">
                    @csrf
                    @if ($errors->has('name') || $errors->has('email') || $errors->has('password'))
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="row">
                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Full Name" required value="{{ old('name', Auth::user()->name) }}">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required value="{{ old('email', Auth::user()->email) }}">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="password" class="form-label">New Password (Optional)</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-type new password">
                        </div>
                    </div>

                    <div class="text-start mb-3">
                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Auto-open profile edit modal if there are validation errors
    @if ($errors->has('name') || $errors->has('email') || $errors->has('password'))
        document.addEventListener('DOMContentLoaded', function() {
            if (window.jQuery && $.magnificPopup) {
                $.magnificPopup.open({ items: { src: '#modalProfileEdit' }, type: 'inline' });
            } else if (window.lightbox) {
                lightbox.open('#modalProfileEdit');
            } else {
                document.getElementById('modalProfileEdit').style.display = 'block';
            }
        });
    @endif
</script> 