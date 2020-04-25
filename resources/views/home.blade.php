<!DOCTYPE html>
<html>
<head>
    <title>Plan</title>
    <link rel="stylesheet" type="text/css" href="/style/style.css" />
</head>
@if($darkmode == 1)
<body class="dark"> 
@else
<body class="light"> 
@endif

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
        @if($darkmode == 1)
        <a href="#" class="lightbulb" data-darkmode="0"></a>
        @else
        <a href="#" class="lightbulb" data-darkmode="1"></a>
        @endif
    </div>

    <div style="display: block; clear: both;">
        <div class="today">
            <p style="float: left; font-weight: bold;" id="today">{{ $today }}</p> 
            <div style="float: right; font-size: .6em;">
                <a href="#" title="Get a sharable link to this plan file">Share this plan</a><br />
                <a href="#" title="Download this plan as a text file">Download this plan</a>
            </div>
        </div>
        @isset($plan->todays->plan)
        <textarea rows="25" id="plan" style="padding: 10px; border-color: #ccc;">{{ $plan->todays->plan }}</textarea>
        @else
        <textarea rows="25" id="plan" style="padding: 10px; border-color: #ccc;"></textarea>
        @endisset

        @isset($plan->todays->plan_id)
        <input type="hidden" name="current_plan_id" id="current_plan_id" value="{{ $plan->todays->plan_id }}" />
        @else
        <input type="hidden" name="current_plan_id" id="current_plan_id" value="" /> 
        @endisset
        <input type="hidden" name="current_user_id" id="current_user_id" value="{{ $user_id }}" />
    </div>
    
    <p class="save_status"><p>
    <hr />
    <h2>History (last 30 plans)</h2>
    <ul>
        @isset($plan->todays->plan)
        <li><a href="" id="todays_plan_link" class="load-plan" plan-date="{{ $today }}" plan-id="{{ $plan->todays->plan_id }}">{{ $today }}</a></li> 
        @else
        <li><a href="" id="todays_plan_link" class="load-plan" plan-date="{{ $today }}" plan-id="">{{ $today }}</a></li> 
        @endisset
    @foreach($plan->prev_plans as $pp)
        <li><a href="#" class="load-plan" plan-date={{ $pp->plan_title }} plan-id="{{ $pp->plan_id }}">{{ $pp->plan_title }}</a></li>
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
                <br />
                <h5>Options</h5>
                <p style="font-size: .8em;">
                    This is where the options would be, if there were any. There are not.
                </p>
            </div>
        </div>
    </div>

    <div id="helpModal" class="modal">
        <div class="modal-content">
            <div class="modal-body">
                <span class="close"> &times;</span>
                <br />
                <h5>What is this?</h5>
                <p style="font-size: .8em;">
                    This is a place you can write your plan for the day, inspired by <a style="font-weight: bold;" href="https://garbagecollected.org/2017/10/24/the-carmack-plan/" target="_blank">John Carmack's .plan file</a>. This will create a .plan for the day when you log in. You get 1 plan per day. You can load/edit your old plans by clicking on the date below. You can also share a URL to a specific plan to give someone "read only" access. Your plan will automatically save, you can check the status in the bottom right corner.
                </p>
                <h5>What should I put in here?</h5>
                <p style="font-size: .8em;">
                    Anything you want. To do lists, code samples, blog posts, half-baked ideas, status reports. It's up to you. Don't put anything sensitive (ie credit card numbers, passwords, etc) because this data is not encryped. (Your account password, of course, is).
                </p>
                <h5>Wait, are you reading this stuff?</h5>
                <p style="font-size: .8em;">
                    No, I don't care about your plans. I am busy. 
                </p>
                <h5>Can I change the font and stuff?</h5>
                <p style="font-size: .8em;">
                No. But there is a "dark mode".
                </p>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="/js/modal.js"></script>
<script type="text/javascript" src="/js/ui.js"></script>
<script type="text/javascript" src="/js/plan.js"></script>
</body>
</html>