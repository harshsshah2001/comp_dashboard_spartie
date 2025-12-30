@include('admin.includes.header')
@include('admin.includes.sidebar')

<style>
    /* Make modal always fit inside screen */
    .modal-dialog {
        max-width: 90vw;
        max-height: 90vh;
        margin: auto;
    }

    .modal-content {
        max-height: 90vh;
        overflow: hidden;
        /* No scroll inside modal */
    }

    .modal-body {
        overflow: hidden !important;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    /* Auto fit cropper image so it never causes scroll */
    #cropperImage {
        max-width: 100%;
        max-height: 65vh;
        /* Perfect height so footer is visible */
        object-fit: contain;
        display: block;
    }
</style>


<div class="app-content">

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header">
                                <h5 class="card-title">Add ImageBox</h5>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">
                                        <form id="addImageboxForm" enctype="multipart/form-data">
                                            @csrf

                                            <!-- ROW 1 -->
                                            <div class="row">


                                                <div class="col-md-6 mb-3">
                                                    <label for="categoryTitle" class="form-label">Image Title</label>
                                                    <input type="text" class="form-control" id="imageboxTitle"
                                                        name="imageboxtitle" placeholder="Enter ImageBOx Title">
                                                    <div class="form-text">Provide the visible title for this Image.
                                                    </div>
                                                    <span class="text-danger error-text categorytitle_error"></span>

                                                </div>



                                            </div>
                                            <label for="imageboxImage" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="imageboxImage" name="image">
                                            <div class="form-text">Upload the main image for this category.
                                            </div>
                                            <span class="text-danger error-text image_error"></span>

                                            {{-- @if(hasPermission('edit-post')) --}}

                                            <button type="submit" class="btn btn-primary">Submit</button>

                                            {{-- @endif --}}
                                        </form>

                                        <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Crop Image</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <img id="cropperImage" style="max-width: 100%;">
                                                    </div>


                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" id="cropImageBtn">Crop &
                                                            Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        @include('admin.includes.footer')


        <script>
            $("#addImageboxForm").on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('imagebox.store') }}",

                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    success: function (res) {
                        if (res.status === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                                timer: 1000,
                                showConfirmButton: false
                            });

                            $("#addImageboxForm")[0].reset();
                            // table.ajax.reload(null, false);
                            // loadCategoryDropdown();  // 🔥 Refresh dropdown list

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: res.message,
                            });
                        }
                    },

                    error: function (err) {

                        // Clear old errors
                        $('.error-text').text('');


                        if (err.status === 422) {
                            // Loop through validation errors and show below fields
                            $.each(err.responseJSON.errors, function (field, messages) {
                                $('.' + field + '_error').text(messages[0]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Something went wrong!'
                            });
                        }
                    }


                });
            });


            let cropper;
            let cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

            $("#imageboxImage").on("change", function (event) {
                let file = event.target.files[0];

                if (!file) return;

                let reader = new FileReader();
                reader.onload = function (e) {
                    $("#cropperImage").attr("src", e.target.result);

                    cropperModal.show();

                    setTimeout(() => {
                        cropper = new Cropper(document.getElementById("cropperImage"), {
                            aspectRatio: 3 / 2,
                            viewMode: 1,
                            autoCropArea: 1,
                            responsive: true,
                            background: false,
                        });

                    }, 200);
                };

                reader.readAsDataURL(file);
            });


            $("#cropImageBtn").on("click", function () {
                let canvas = cropper.getCroppedCanvas({
                    width: 1200,
                    height: 800,
                });

                canvas.toBlob(function (blob) {

                    // Replace original file with cropped file inside FormData
                    let fileInput = document.querySelector('#imageboxImage');
                    let cropFile = new File([blob], "cropped_image.jpg", { type: "image/jpeg" });

                    let dataTransfer = new DataTransfer();
                    dataTransfer.items.add(cropFile);
                    fileInput.files = dataTransfer.files;

                    cropperModal.hide();
                });
            });

        </script>