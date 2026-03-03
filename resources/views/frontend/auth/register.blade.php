<div id="modalRegister" class="modal no-padding" data-delay="3000" style="max-width: 580px;">
    <div class="row">
        <div class="col-md-12">
            <div class="p-40 p-t-60 p-xs-20">
                <h3 class="mb-4">Register a New Account</h3>

                <form class="form-grey-fields" method="POST" action="{{ route('modal.register') }}">
                    @csrf

                    @if ($errors->has('email'))
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                    @endif

                    @if ($errors->has('password'))
                        <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                    @endif

                    @if ($errors->has('name') || $errors->has('password_confirmation'))
                        <div class="alert alert-danger">
                            @if ($errors->has('name'))
                                <div>{{ $errors->first('name') }}</div>
                            @endif
                            @if ($errors->has('password_confirmation'))
                                <div>{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>
                    @endif

                    <div class="row">
                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Full Name" required value="{{ old('name') }}">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required value="{{ old('email') }}">
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Create Password" required>
                                <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility" title="Show/Hide password">
                                    <span data-open="👁" data-closed="🙈">👁</span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-type Password" required>
                                <button type="button" class="password-toggle" id="togglePasswordConfirmation" aria-label="Toggle password confirmation visibility" title="Show/Hide password confirmation">
                                    <span data-open="👁" data-closed="🙈">👁</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-start mb-3">
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </div>
                </form>

                <p class="text-start mb-0">
                    Already have an account?
                    <a href="#modalLogin" data-lightbox="inline">Login Here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    #modalRegister .password-wrapper {
        position: relative;
    }

    #modalRegister .password-wrapper input {
        padding-right: 44px;
    }

    #modalRegister .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        padding: 0;
        line-height: 1;
        font-size: 18px;
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const togglePasswordConfirmBtn = document.getElementById('togglePasswordConfirmation');

        const toggleInputVisibility = (input, button) => {
            if (!input || !button) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            const icon = button.querySelector('span');
            if (icon) {
                icon.textContent = isPassword ? icon.dataset.closed : icon.dataset.open;
            }
        };

        if (togglePasswordBtn) {
            togglePasswordBtn.addEventListener('click', function() {
                toggleInputVisibility(passwordInput, togglePasswordBtn);
            });
        }

        if (togglePasswordConfirmBtn) {
            togglePasswordConfirmBtn.addEventListener('click', function() {
                toggleInputVisibility(passwordConfirmInput, togglePasswordConfirmBtn);
            });
        }

        // Auto-open register modal if there are register errors
        @if (
            $errors->has('name') ||
            $errors->has('email') ||
            $errors->has('password') ||
            $errors->has('password_confirmation')
        )
            if (window.jQuery && $.magnificPopup) {
                $.magnificPopup.open({ items: { src: '#modalRegister' }, type: 'inline' });
            } else if (window.lightbox) {
                lightbox.open('#modalRegister');
            } else {
                document.getElementById('modalRegister').style.display = 'block';
            }
        @endif
    });
</script>
