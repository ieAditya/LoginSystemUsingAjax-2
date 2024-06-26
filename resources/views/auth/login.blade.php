@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow" style="width: 40rem;">
        <div class="card-body">
            <h5 class="card-title">Login</h5>
            <div id="show_alert">
            </div>
            <form id="login_form" enctype="multipart/form-data">
                @csrf
                <div class="mb-3" id="email_input_section">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control rounded-0" id="description" name="email">
                    <div class="invalid_feedback"></div>

                </div>
                <div class="mb-3" id="pswd_input_section">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control rounded-0" id="password" name="password">
                    <div class="invalid_feedback"></div>

                </div>
                <div class="mb-3" id="forgot_pswd_section">
                    <a href="/forgot"
                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Forgot
                        Password?</a>

                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" id="login_btn" class="d-grid btn btn-dark rounded-0">Login</button>
                </div>
            </form>
            <p class="mt-2">New user? <a href="/signup"
                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Register
                    here</a></p>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#login_form').on('submit', function (event) {
            event.preventDefault();
            $('#login_btn').text('Please wait...');
            var form = $("#login_form")[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{route('auth.login')}}",
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    $alertType = "primary";
                    $alertMessage = "Successfully logged in!!";
                    if (response.hasOwnProperty("wrong_password")) {
                        $alertType = "warning";
                        $alertMessage = "Wrong password!!";
                    }
                    else if (response.hasOwnProperty("user_not_exist")) {
                        $alertType = "warning";
                        $alertMessage = "User not registered!! Try signing up";
                    }
                    $('#login_form')[0].reset();
                    // alert(response.message);

                    $('#show_alert').html(`<div class="alert alert-${$alertType} alert-dismissible fade show" role="alert">
                    <strong>${$alertMessage}.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                    if ($alertMessage == "Successfully logged in!!")
                        window.location = '{{ route('dashboard') }}';

                    console.log(response);
                },
                error: function (response) {
                    // $('#signup_btn').text('Signup');
                    console.log(response.responseText);
                    $('#login_btn').text('Login');
                }
            });
        });
    });
</script>
@endsection