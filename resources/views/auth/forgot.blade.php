@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="row d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow" style="width: 40rem;">
        <div class="card-body">
            <h5 class="card-title">Forgot Password</h5>
            <div id="show_alert">
            </div>
            <form id="forgot_form" enctype="multipart/form-data">
                @csrf
                <div class="mb-3" id="email_input_section">
                    Enter your email addresss and we will send you a link to reset your password
                </div>
                <div class="mb-3" id="email_input_section">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control rounded-0" id="description" name="email">
                    <div class="invalid_feedback"></div>

                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" id="forgot_btn" class="d-grid btn btn-dark rounded-0">Reset Password</button>
                </div>
            </form>
            <p class="mt-2">Go to <a href="/"
                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">login
                    page</a></p>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#forgot_form').on('submit', function (e) {
            e.preventDefault();
            $('#forgot_btn').val('Please wait...');
            $.ajax({
                url: "{{route('auth.reset')}}",
                type: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    // $alertType = "primary";
                    // $alertMessage = "Reset password email sent!!";
                    // if (response.hasOwnProperty("fail")) {
                    //     $alertType = "warning";
                    //     $alertMessage = "Email not registered!!";
                    // }
                    // $('#show_alert').html(`<div class="alert alert-${$alertType} alert-dismissible fade show" role="alert">
                    // <strong>${$alertMessage}.</strong>
                    // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    // </div>`);
                    // $('#forgot_btn').val('Reset Password');
                    console.log(response);
                },
                error: function (response) {
                    // $('#signup_btn').text('Signup');
                    console.log(response.responseText);
                    // $('#forgot_btn').val('Reset Password');
                    // alert("Error!!");
                }
            });
        });
    });
</script>
@endsection