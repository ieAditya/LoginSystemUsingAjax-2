@extends('layouts.app')

@section('title', 'Signup')

@section('content')
<div class="row d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow" style="width: 40rem;">
        <div class="card-body">
            <h5 class="card-title">Signup</h5>
            <div id="show_alert">
            </div>
            <form id="signup_form" enctype="multipart/form-data">
                @csrf
                <div class="mb-3" id="name_input_section">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control rounded-0" id="name" name="name" required>
                    <div class="invalid_feedback"></div>
                </div>

                <div class="mb-3" id="email_input_section">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control rounded-0" id="description" name="email" required>
                    <div class="invalid_feedback"></div>
                </div>

                <div class="mb-3" id="pswd_input_section">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control rounded-0" id="password" name="password" required>
                    <div class="invalid_feedback"></div>
                </div>

                <div class="mb-3" id="confpswd_input_section">
                    <label class="form-label" for="conf_password">Confirm Password</label>
                    <input type="password" class="form-control rounded-0" id="conf_password" name="conf_password"
                        required>
                    <div class="invalid_feedback"></div>
                </div>

                <div class="mb-3" id="image_input_section">
                    <label class="form-label" for="image">Profile photo</label>
                    <input type="file" class="form-control rounded-0" id="image" name="image">
                    <div class="invalid_feedback"></div>
                </div>

                <div class="mb-3 d-grid">
                    <button type="submit" id="signup_btn" class="d-grid btn btn-dark rounded-0">Signup</button>
                </div>
            </form>
            <p class="mt-2">Already a user? <a href="/"
                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Login
                    here</a></p>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#signup_form').on('submit', function (event) {
            event.preventDefault();
            $('#signup_btn').text('Please wait...');
            var form = $("#signup_form")[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{route('auth.register')}}",
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    $alertType = "primary";
                    $alertMessage = "Account registered successfully!! Login please";
                    if (response.hasOwnProperty("user_exist")) {
                        $alertType = "warning";
                        $alertMessage = "Email id already taken!! Try logging in";
                    }
                    else if (response.hasOwnProperty("no_match")) {
                        $alertType = "warning";
                        $alertMessage = "Passwords do not match!!";
                    }
                    else {
                        $('#signup_form')[0].reset();
                        // alert(response.message);
                    }
                    $('#show_alert').html(`<div class="alert alert-${$alertType} alert-dismissible fade show" role="alert">
                    <strong>${$alertMessage}.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                    $('#signup_btn').text('Signup');
                    console.log(response);
                },
                error: function (response) {
                    // $('#signup_btn').text('Signup');
                    console.log(response.responseText);
                    $('#signup_btn').text('Signup');
                    alert("Error!!");
                }
            });
        });
    });
</script>
@endsection