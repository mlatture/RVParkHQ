<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\DemoAppService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct(private readonly DemoAppService $demoAppService)
    {
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;

    /**
     * show login form for admin guard
     */
    public function showLoginForm(): Renderable
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }

        $this->demoAppService->maybeSetDemoLocaleToEnByDefault();

//        $email = app()->environment('local') ? 'superadmin@example.com' : '';
//        $password = app()->environment('local') ? '12345678' : '';

//        return view('backend.auth.login')->with(compact('email', 'password'));
        return view('backend.auth.login');
    }

    /**
     * Login admin.
     *
     * @return void
     */
    public function login(LoginRequest $request)
    {
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password, 'type' => $request->type], $request->remember)) {
            $this->demoAppService->maybeSetDemoLocaleToEnByDefault();
            session()->flash('success', 'Successfully Logged in!');

            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('web')->attempt(['username' => $request->email, 'password' => $request->password], $request->remember)) {
            $this->demoAppService->maybeSetDemoLocaleToEnByDefault();
            session()->flash('success', 'Successfully Logged in!');

            return redirect()->route('admin.dashboard');
        }

        session()->flash('error', __('auth.failed'));
        return back();
    }

    /**
     * logout admin guard
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('admin.login');
    }

    public function showRegistrationForm()
    {
        return view('backend.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'type' => $request->type,
            'username' => strtolower($request->name),
            'name' => ucfirst($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');
        Auth::login($user);

        session()->flash('success', 'Account registered & logged in successfully.');
        return redirect()->route('admin.dashboard');
    }
}
