@include('admin.includes.header')
@include('admin.includes.sidebar')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title">Add Deal Of The Week</h5>
                        </div>

                        <div class="card-body">
                            <form id="addcountdownForm" enctype="multipart/form-data">
                                @csrf

                                <!-- 1st ROW -->
                                <div class="row">
                                    <!-- DEAL TITLE -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Deal Title</label>
                                        <input type="text" class="form-control" name="title">
                                        <span class="text-danger error title_error"></span>
                                    </div>

                                    <!-- DEAL SUBTITLE -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Subtitle</label>
                                        <input type="text" class="form-control" name="subtitle">
                                        <span class="text-danger error subtitle_error"></span>
                                    </div>
                                </div>

                                <!-- 2nd ROW -->
                                <div class="row">
                                    <!-- END DATE & TIME -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">End Date & Time</label>
                                        <input type="datetime-local" class="form-control" name="end_datetime">
                                        <span class="text-danger error end_datetime_error"></span>
                                    </div>

                                    <!-- IMAGE -->
                                    <div class="col-md-6 mb-3">
                                        <label for="Image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="Image" name="image">
                                        <div class="form-text">Upload the main image for this Countdown.</div>
                                        <span class="text-danger error-text image_error"></span>
                                    </div>
                                </div>

                                <!-- STATUS (One row alone) -->
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger error status_error"></span>
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
    $("#addcountdownForm").on('submit', function (e) {
        e.preventDefault();

        $(".error").text(""); // clear previous errors

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('countdown.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function (res) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    timer: 1200,
                    showConfirmButton: false
                });

                $("#addcountdownForm")[0].reset();
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
