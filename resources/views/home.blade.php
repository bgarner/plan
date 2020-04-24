<!DOCTYPE html>
<html>
<head>
    <title>Plan</title>
    <link rel="stylesheet" type="text/css" href="/style/style.css" />
</head>
<body class="light">

<div class="container">

    <h1>.plan</h1>
    <div class="nav">
        <a href="#" class="openModal" id="openAccountModal" modal="accountModal">
            @if (Auth::check())
                {{ Auth::user()->email }}
            @else 
                Account
            @endif
        </a>
        <a href="#" class="openModal" id="openOptionsModal" modal="optionsModal">Options</a>
        <a href="#" class="openModal" id="openHelpModal" modal="helpModal">Help</a>
        <a href="#" class="lightbulb"></a>
    </div>

    <form>
        <div class="today">
            <p style="float: left; font-weight: bold;">{{ $today }}</p> 
            <div style="float: right; font-size: .6em;">
                <a href="#" title="Get a sharable link to this plan file">Share this plan</a><br />
                <a href="#" title="Download this plan as a text file">Download this plan</a>
            </div>
        </div>
        <textarea rows="15" style="padding: 10px; border-color: #ccc;">{{ $plan }}</textarea>
    </form>

    <p class="save_status"> &check; saved 10 seconds ago<p>
    <hr />
    <h2>Past</h2>
    <ul>
    @foreach($prev_plans as $pp)
        <li><a href="#" plan-id="{{ $pp->plan_id }}">{{ $pp->plan_title }}</a></li>
    @endforeach
    </ul>

    <div id="accountModal" class="modal">
        <div class="modal-content">
            <div class="modal-body">
            <span class="close">&times;</span>
            <table>
                <tr>
                    <td class="logincol">
                        <h3>Create an Account</h3>
                        <form>
                            <label>E-mail Address</label>
                            <input type="text" id="create_email" name="create_email" />
                            <lavel>Password</lavel>
                            <input type="password" id="create_password" name="create_password" />
                            <label>Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" />
                            <input type="submit" value="Register" />
                        </form>
                    </td>
                    <td>
                        <h3>Login</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <label>E-mail Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label>Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                            
                            <br />
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>

                            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </form>

                    </td>
                </tr>
            </table>
            </div>
        </div>
    </div>

    <div id="optionsModal" class="modal">
        <div class="modal-content">
            <div class="modal-body">
                <span class="close"> &times;</span>
                <p>Options Modal</p>
            </div>
        </div>
    </div>

    <div id="helpModal" class="modal">
        <div class="modal-content">
            <div class="modal-body">
                <span class="close"> &times;</span>
                <p>Help Modal</p>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="/js/modal.js"></script>
<script type="text/javascript" src="/js/ui.js"></script>
</body>
</html>