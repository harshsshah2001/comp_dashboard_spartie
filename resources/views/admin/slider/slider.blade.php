@include('admin.includes.header')
@include('admin.includes.sidebar')


<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title">Add Slider</h5>
                        </div>

                        <div class="card-body">
                            <form id="addSliderForm" enctype="multipart/form-data">
                                @csrf

                                {{-- ROW 1 --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Slider Image</label>
                                        <input type="file" class="form-control" id="sliderImage" name="sliderimage">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mobile Slider Image</label>
                                        <input type="file" class="form-control" id="mobileSliderImage" name="mobilesliderimage">
                                    </div>
                                </div>

                                {{-- ROW 2 --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Heading</label>
                                        <input type="text" class="form-control" name="sliderheading">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Heading Color</label>
                                        <input type="color" name="headingcolor"
                                            style="width:40px;height:40px;padding:0;border:none;cursor:pointer;">
                                    </div>
                                </div>

                                {{-- ROW 3 --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sub Heading</label>
                                        <input type="text" class="form-control" name="slidersubheading">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sub Heading Color</label>
                                        <input type="color" name="subheadingcolor"
                                            style="width:40px;height:40px;padding:0;border:none;cursor:pointer;">
                                    </div>
                                </div>

                                {{-- ROW 4 --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="sliderdescription" rows="3"></textarea>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Description Color</label>
                                        <input type="color" name="descriptioncolor"
                                            style="width:40px;height:40px;padding:0;border:none;cursor:pointer;">
                                    </div>
                                </div>

                                {{-- ROW 5 --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Button Text</label>
                                        <input type="text" class="form-control" name="buttontext">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Button Link</label>
                                        <input type="text" class="form-control" name="buttonlink">
                                    </div>
                                </div>

                                {{-- ROW 6 --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Button Background Color</label>
                                        <input type="color" name="buttonbgcolor"
                                            style="width:40px;height:40px;padding:0;border:none;cursor:pointer;">
                                    </div>
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



<!-- 🟦 COPY OF CROPPER MODAL FROM FILE 1 -->
<style>
.modal-dialog {
    max-width: 90vw;
    max-height: 90vh;
    margin: auto;
}

.modal-content {
    max-height: 90vh;
    overflow: hidden;
}

.modal-body {
    overflow: hidden !important;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
}

#cropperImage {
    max-width: 100%;
    max-height: 65vh;
    object-fit: contain;
    display: block;
}
</style>

<!-- MODAL (exact same as file 1) -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <img id="cropperImage" style="max-width:100%;">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="cropImageBtn">Crop & Save</button>
            </div>

        </div>
    </div>
</div>



{{-- AJAX SUBMIT --}}
<script>
$("#addSliderForm").on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('slider.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },

        success: function (res) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message,
                timer: 1000,
                showConfirmButton: false
            });

            $("#addSliderForm")[0].reset();
        },
        error: function () {
            Swal.fire("Error", "Something went wrong!", "error");
        }
    });
});
</script>



<!-- 🟦 CROPPER SCRIPT (EXACT COPY FROM FILE 1) -->
<script>
let cropper;
let currentInput = null; // <-- stores sliderImage or mobileSliderImage
let cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

// Initialize cropper on input change
function initCropperInput(inputId) {

    document.getElementById(inputId).addEventListener("change", function(event) {

        let file = event.target.files[0];
        if (!file) return;

        currentInput = inputId; // <-- store which input we are cropping

        let reader = new FileReader();
        reader.onload = function(e) {

            document.getElementById("cropperImage").src = e.target.result;

            cropperModal.show();

            setTimeout(() => {
                // destroy old cropper if exists
                if (cropper) cropper.destroy();

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
}

// Attach to BOTH fields
initCropperInput("sliderImage");
initCropperInput("mobileSliderImage");


// ----------- CROP & SAVE BUTTON WORKING FIX -------------
document.getElementById("cropImageBtn").addEventListener("click", function () {

    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
        width: 1200,
        height: 800,
    });

    canvas.toBlob(function(blob) {

        let fileInput = document.getElementById(currentInput); // <-- correct input

        // keep original filename
        let originalFile = fileInput.files[0];
        let newFile = new File([blob], originalFile.name, { type: originalFile.type });

        // replace file correctly
        let dt = new DataTransfer();
        dt.items.add(newFile);
        fileInput.files = dt.files;

        cropperModal.hide();
    });
});

// Reset cropper when modal closes
document.getElementById("cropperModal").addEventListener("hidden.bs.modal", function () {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
    document.getElementById("cropperImage").src = "";
});
</script>
