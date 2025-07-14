<div id="modalLogin" class="modal no-padding" data-delay="3000" style="max-width: 580px;">
    <div class="row">
        <div class="col-md-12">
            <div class="p-40 p-t-60 p-xs-20">
                <h3>Sign up or Login</h3>
                <form class="form-grey-fields" method="POST" action="{{ route('modal.login') }}">
                    @csrf
                    @if ($errors->has('email') || $errors->has('password'))
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <label for="loginEmail" class="form-label">Email</label>
                        <input type="text" name="email" id="loginEmail" class="form-control" placeholder="Username or Email" required value="{{ old('email') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                            <small>Lost your password?</small>
                        </a>
                    </div>

                    <div class="text-start mb-3">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                </form>
                <p class="text-start">Don't have an account yet? <a href="#modalRegister" data-lightbox="inline">Register New
                        Account</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    // Auto-open login modal if there are login errors
    @if ($errors->has('email') || $errors->has('password'))
        document.addEventListener('DOMContentLoaded', function() {
            if (window.jQuery && $.magnificPopup) {
                $.magnificPopup.open({ items: { src: '#modalLogin' }, type: 'inline' });
            } else if (window.lightbox) {
                lightbox.open('#modalLogin');
            } else {
                document.getElementById('modalLogin').style.display = 'block';
            }
        });
    @endif
</script>