@include('admin.includes.header')
@include('admin.includes.sidebar')

<div class="app-content">

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Product</h5>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel">

                                    <form id="addProductForm" method="POST"  enctype="multipart/form-data">
                                        @csrf

                                        <!-- IMAGE -->
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Product Image</label>
                                                <input type="file" class="form-control" id="productimage" name="image">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Product Icon</label>
                                                <input type="file" class="form-control" id="producticon" name="icon">
                                            </div>
                                        </div>

                                        <!-- TITLE -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Product Title</label>
                                                <input type="text" class="form-control" id="producttitle" name="title"
                                                    placeholder="Enter product title">
                                            </div>
                                        </div>

                                        <!-- DESCRIPTION -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Product Description</label>
                                                <textarea class="form-control" id="productdescription"
                                                    name="description" rows="3"
                                                    placeholder="Enter product description"></textarea>
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
    </div>
</div>

@include('admin.includes.footer')

<script>
    $('#addProductForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "{{ route('infocards.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status === true) {
                    Swal.fire({
                        title: "Success!",
                        text: res.message,
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $('#addProductForm')[0].reset();

                    if (typeof table !== "undefined") {
                        table.ajax.reload(null, false);
                    }
                }
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let message = "";

                    $.each(errors, function (key, value) {
                        message += value[0] + "<br>";
                    });

                    Swal.fire({
                        title: "Validation Error!",
                        html: message,
                        icon: "error"
                    });

                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong!",
                        icon: "error"
                    });
                }
            }
        });
    })

// hide the feild if you choose on
    $("#productimage").on("change", function () {
        if (this.files.length > 0) {
            $("#producticon").closest('.col-md-6').hide();
        } else {
            $("#producticon").closest('.col-md-6').show();
        }
    });

    $("#producticon").on("change", function () {
        if (this.files.length > 0) {
            $("#productimage").closest('.col-md-6').hide();
        } else {
            $("#productimage").closest('.col-md-6').show();
        }
    });

</script>
