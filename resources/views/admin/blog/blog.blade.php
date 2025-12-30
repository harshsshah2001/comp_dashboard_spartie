@include('admin.includes.header')
@include('admin.includes.sidebar')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title">Add Blog</h5>
                        </div>

                        <div class="card-body">
                            <form id="addBlogForm" enctype="multipart/form-data">
                                @csrf

                                <!-- TITLE -->
                                <div class="mb-3">
                                    <label class="form-label">Blog Title</label>
                                    <input type="text" class="form-control" name="title">
                                    <span class="text-danger error title_error"></span>
                                </div>

                                <!-- DATE -->
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date">
                                    <span class="text-danger error date_error"></span>
                                </div>

                                <!-- IMAGE -->
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image">
                                    <span class="text-danger error image_error"></span>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>

                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.includes.footer')

<script>
    $("#addBlogForm").on('submit', function (e) {
        e.preventDefault();

        $(".error").text(""); // clear previous errors

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('blog.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function (res) {

                if(res.status === 'success'){
                    Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    timer: 1200,
                    showConfirmButton: false
                });
                }

                $("#addBlogForm")[0].reset();
            },

            error: function (xhr) {

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {
                        $("." + key + "_error").text(value[0]);
                    });

                } else {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            }
        });
    });

</script>
