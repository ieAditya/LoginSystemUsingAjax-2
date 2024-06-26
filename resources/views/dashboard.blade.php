@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- <p>{{$userData['image']}}</p> -->
<div class="container">
    <div class="row my-5">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Welcome</h5>
                    <a href="{{ route('logout') }}" class="d-grid btn btn-dark rounded-0">Logout</a>
                </div>
                <div id="show_alert">
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-4 px-5 text-center" style="border-right: 1px solid #999;">
                            <img src="users/{{$userData['image']}}" id="image_preview" class="img-fluid img-thumbnail"
                                alt="Image couldn't be loaded!" width="200" height="200">
                            <div>
                                <label for="picture">Change Profile image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                <input type="hidden" name="user_id" id="user_id" value="{{$userData['id']}}">
                            </div>
                        </div>
                        <div class="col-lg-8 p-5">
                            <form id="update_form">
                                @csrf
                                <div class="mb-3" id="name_input_section">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control rounded-0" id="name" name="name"
                                        value="{{$userData['name']}}" required>
                                    <div class="invalid_feedback"></div>
                                </div>

                                <div class="mb-3" id="email_input_section">
                                    <label for="email" class="form-label">Email</label>
                                    <p class="form-control rounded-0">{{$userData['email']}}</p>
                                    <div class="invalid_feedback"></div>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" id="update_btn" class="btn btn-dark rounded-0">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {

        $('#image').change(function (event) {
            const file = event.target.files[0];
            let url = window.URL.createObjectURL(file);
            $('#image_preview').attr('src', url);
            let fd = new FormData();
            fd.append('picture', file);
            fd.append('user_id', $('#user_id').val());
            fd.append('_token', '{{csrf_token()}}');
            $.ajax({
                url: "{{route('image.update')}}",
                type: "POST",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    $('#show_alert').html(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>${response.success}.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                    console.log(response);
                },
                error: function (response) {
                    $('#show_alert').html(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>${response.fail}.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                    console.log(response.responseText);
                    // alert("Error!!");
                }
            });
        });

        $('#update_form').on('submit', function (event) {
            event.preventDefault();
            $('#update_btn').text('Updating info...');
            var form = $("#update_form")[0];
            var data = new FormData(form);
            data.append('user_id', $('#user_id').val())
            $.ajax({
                url: "{{route('auth.update')}}",
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    $alertType = 'primary'
                    $alertMessage = 'Name updated successfully'
                    if (response.hasOwnProperty("fail")) {
                        $alertType = 'warning'
                        $alertMessage = 'Nothing to update'
                    }
                    $('#show_alert').html(`<div class="alert alert-${$alertType} alert-dismissible fade show" role="alert">
                    <strong>${$alertMessage}.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                    $('#update_btn').text('Update');
                    console.log(response);
                },
                error: function (response) {
                    console.log(response.responseText);
                    $('#update_btn').text('Update');
                }
            });
        });

        // function loaddata() {
        //     $("#name").val(userData -> name);
        //     // $("#email").val(userData['email']);
        //     // $("#image").val('users/' + userData['image']);
        // }
        // loaddata();
    });
</script>
@endsection