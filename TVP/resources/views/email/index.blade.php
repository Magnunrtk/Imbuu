@extends('layout')
@section('title', 'Confirm Email')
@section('content')
    <p>
        In order to have full access to your account, you have to confirm you email first.<br>
        If you did not receive an email yet, please <a href="{{ route('account.login.index') }}">log in</a> your account and resend your confirmation email.
    </p>
    <form class="form" action="{{ route('account.confirm.action') }}" method="post">
        @csrf
        <div class="panel">
            <div class="panel__title">Confirm Account</div>
            <div class="panel__content">
                <div class="row">
                    <div class="col-3">
                        <label for="confirmationKey" class="form__label">Confirmation Key:</label>
                    </div>
                    <div class="col-9">
                        @if(isset($confirmationKey))
                            <input type="text" value="{{ $confirmationKey }}" name="confirmationKey" id="confirmationKey" class="form__control" required="" autofocus="" autocomplete="off">
                        @else
                            <input type="text" value="" name="confirmationKey" id="confirmationKey" class="form__control" required="" autofocus="" autocomplete="off">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center text--center">
            <div class="col-6">
                <button class="btn btn-primary" type="submit">
                    Submit
                </button>
            </div>
            <div class="col-6">
                <a href="{{ route('account.login.index') }}" class="btn btn-primary">
                    Login
                </a>
            </div>
        </div>
    </form>
@endsection
