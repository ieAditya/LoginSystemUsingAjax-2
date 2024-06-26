@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="row d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow" style="width: 40rem;">
        <div class="card-body">
            <h5 class="card-title">Reset Password</h5>
            <form id="reset_form" enctype="multipart/form-data">
                @csrf
                <div class="mb-3" id="email_input_section">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control rounded-0" id="description" name="email">
                    <div class="invalid_feedback"></div>

                </div>
                <div class="mb-3" id="pswd_input_section">
                    <label class="form-label" for="new_password">New Password</label>
                    <input type="password" class="form-control rounded-0" id="new_password" name="new_password">
                    <div class="invalid_feedback"></div>

                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" id="login_btn" class="d-grid btn btn-dark rounded-0">Reset Password</button>
                </div>
            </form>
            <a href="/"
                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Login
                here</a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {

    });
</script>
@endsection