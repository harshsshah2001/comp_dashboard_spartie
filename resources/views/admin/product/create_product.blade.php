@include('admin.includes.header')
@include('admin.includes.sidebar')

<style>
    /* Make top bar (Show entries + Search) on the same line */
    div.dataTables_wrapper div.dataTables_length {
        float: left !important;
    }

    div.dataTables_wrapper div.dataTables_filter {
        float: right !important;
        text-align: right !important;
    }

    /* Align the Search label + input inside */
    div.dataTables_filter label {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 6px;
        margin-bottom: 0 !important;
    }

    div.dataTables_wrapper .dataTables_paginate {
        display: none !important;
    }
</style>


<div class="app-content">

    <div class="content-wrapper">
        <div class="container-fluid">

            {{-- insert data --}}

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header">
                                <h5 class="card-title">Add Product</h5>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">


                                        <form id="addProductForm" enctype="multipart/form-data">
                                            @csrf

                                            <!-- ROW 1 -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Select Category</label>
                                                    <select class="form-control" id="category" name="category">
                                                        <option value="">Select Category</option>

                                                    </select>
                                                    <span class="text-danger error-text category_error"></span>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Title</label>
                                                    <input type="text" class="form-control" id="productname"
                                                        name="productname" placeholder="Enter product title">
                                                    <span class="text-danger error-text productname_error"></span>
                                                </div>
                                            </div>

                                            <!-- ROW 2 -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Image</label>
                                                    <input type="file" class="form-control" id="productimage"
                                                        name="image">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Icon</label>
                                                    <input type="file" class="form-control" id="producticon"
                                                        name="icon">
                                                </div>
                                            </div>

                                            <!-- ROW 3 -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Price</label>
                                                    <input type="text" class="form-control" id="edit_price"
                                                        name="price">

                                                    <span class="text-danger error-text price_error"></span>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Sale Price</label>
                                                    <input type="text" class="form-control" id="saleprice"
                                                        name="saleprice">

                                                    <span class="text-danger error-text saleprice_error"></span>
                                                </div>
                                            </div>

                                            <!-- ROW 4 (NEW — split description into 2 fields for symmetry) -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Short Description</label>
                                                    <input type="text" class="form-control" id="shortdesc"
                                                        name="shortdesc" placeholder="Short description">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Label</label>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="badge"
                                                            id="badgeSale" value="sale">
                                                        <label class="form-check-label" for="badgeSale">Sale</label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="badge"
                                                            id="badgeFeatured" value="featured">
                                                        <label class="form-check-label" for="badgeFeatured">Is
                                                            Featured</label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="badge"
                                                            id="badgeNew" value="new">
                                                        <label class="form-check-label" for="badgeNew">New</label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="badge"
                                                            id="badgeDiscount" value="discount">
                                                        <label class="form-check-label"
                                                            for="badgeDiscount">Discount</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ROW 5 - Full Width Description -->
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Full Description</label>
                                                    <textarea class="form-control" id="productdescription"
                                                        name="productdescription" rows="3"
                                                        placeholder="Enter product description"></textarea>
                                                    <span
                                                        class="text-danger error-text productdescription_error"></span>
                                                </div>
                                            </div>

@can('create product')
    <button type="submit" class="btn btn-primary">
        Submit
    </button>
@else
    <button type="button" class="btn btn-secondary" disabled>
        No Permission
    </button>
@endcan
                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- display all data -->

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Product List</h5>
                        </div>
                        <div class="card-body">
                            <table id="datatable1" class="display w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Parent Category</th>
                                        <th>Product Name</th>
                                        <th>Product Image</th>
                                        <th>Badge</th>
                                        <th>Product Icon</th>
                                        <th>Price</th>
                                        <th>Sale Price</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Product Modal -->
            <div class="modal fade" id="editProductModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form id="updateProductForm">
                                @csrf

                                <input type="hidden" id="edit_id" name="id">

                                <!-- ROW 1 -->
                                <div class="row">

                                    <!-- Parent Category -->
                                    <div class="col-md-6 mb-3">
                                        <label>Parent Category</label>
                                        <select class="form-control" id="edit_parentCategory" name="category">
                                            <option value="">Select Parent Category</option>
                                        </select>
                                        <span class="text-danger error-text category_error"></span>
                                    </div>

                                    <!-- Product Title -->
                                    <div class="col-md-6 mb-3">
                                        <label>Product Title</label>
                                        <input type="text" class="form-control" id="edit_producttitle"
                                            name="productname">
                                        <span class="text-danger error-text productname_error"></span>
                                    </div>

                                </div>

                                <!-- ROW 2 -->
                                <div class="row">

                                    <!-- Product Image -->
                                    <div class="col-md-6 mb-3">
                                        <label>Product Image</label>

                                        <!-- Old Image -->
                                        <div style="margin-bottom: 10px;">
                                            <img id="old_image_preview" src="" width="80" height="80"
                                                style="display:none; border-radius:5px;">
                                        </div>

                                        <input type="file" class="form-control" id="edit_image" name="image">

                                        <!-- New Preview -->
                                        <div style="margin-top: 10px;">
                                            <img id="new_image_preview" src="" width="80" height="80"
                                                style="display:none; border-radius:5px;">
                                        </div>
                                        <span class="text-danger error-text image_error"></span>
                                    </div>

                                    <!-- Product Icon -->
                                    <div class="col-md-6 mb-3">
                                        <label>Product Icon</label>

                                        <!-- Old Icon -->
                                        <div style="margin-bottom: 10px;">
                                            <img id="old_icon_preview" src="" width="80" height="80"
                                                style="display:none; border-radius:5px;">
                                        </div>

                                        <input type="file" class="form-control" id="edit_icon" name="icon">

                                        <!-- New Preview -->
                                        <div style="margin-top: 10px;">
                                            <img id="new_icon_preview" src="" width="80" height="80"
                                                style="display:none; border-radius:5px;">
                                        </div>
                                        <span class="text-danger error-text icon_error"></span>
                                    </div>

                                </div>

                                <!-- ROW 3 -->
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label>Price</label>
                                        <input type="text" class="form-control" id="update_price" name="price">
                                        <span class="text-danger error-text price_error"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Sale Price</label>
                                        <input type="text" class="form-control" id="edit_saleprice" name="saleprice">
                                        <span class="text-danger error-text saleprice_error"></span>
                                    </div>

                                </div>

                                <!-- ROW 4 (Description) -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Product Label</label>

                                    <div class="row">

                                        <!-- LEFT COLUMN -->
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="badge"
                                                    id="edit_BadgeSale" value="sale">
                                                <label class="form-check-label" for="editBadgeSale">Sale</label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="badge"
                                                    id="edit_BadgeFeatured" value="featured">
                                                <label class="form-check-label" for="editBadgeFeatured">Is
                                                    Featured</label>
                                            </div>
                                        </div>

                                        <!-- RIGHT COLUMN -->
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="badge"
                                                    id="edit_BadgeNew" value="new">
                                                <label class="form-check-label" for="editBadgeNew">New</label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="badge"
                                                    id="edit_BadgeDiscount" value="discount">
                                                <label class="form-check-label" for="editBadgeDiscount">Discount</label>
                                            </div>
                                        </div>

                                    </div>

                                    <span class="text-danger error-text badge_error"></span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Full Description</label>
                                    <textarea class="form-control" id="edit_productdescription"
                                        name="productdescription" rows="3"></textarea>
                                    <span class="text-danger error-text productdescription_error"></span>
                                </div>


                                <button type="submit" class="btn btn-primary btn-sm float-start">
                                    Update Product
                                </button>
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
    $(document).ready(function () {

        $(window).on('load', function () {
            loadCategoryDropdown();
        });

        // add data
        $("#addProductForm").on("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('product.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res.status === true) {
                        Swal.fire({
                            title: "Success!",
                            text: res.message,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        table.ajax.reload(null, false);
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
        });

        // display data
        let table = $("#datatable1").DataTable({
            processing: true,
            serverSide: true,
            ordering: false,

            ajax: {
                url: "{{ route('product.list') }}",
                type: "GET"
            },

            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],

            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },

                { data: "category" },
                { data: "productname" },

                {
                    data: "image",
                    render: img => img ? `<img src="/storage/${img}" width="40">` : "No Image"
                },

                {
                    data: "icon",
                    render: img => img ? `<img src="/storage/${img}" width="30">` : "No Icon"
                },

                { data: "badge" },
                { data: "price" },
                { data: "saleprice" },
                { data: "productdescription" },

                {
                    data: "id",
                    render: id => `
                <a class="editBtn text-primary" data-id="${id}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="deleteBtn text-danger" data-id="${id}" style="cursor:pointer">
                    <i class="fa-solid fa-trash"></i>
                </a>
            `
                }
            ]
        });

        // Preview new product image
        $("#edit_image").on("change", function () {
            let file = this.files[0];
            if (file) {
                $("#new_image_preview")
                    .attr("src", URL.createObjectURL(file))
                    .show();

                $("#old_image_preview").hide();
            }
        });

        // Preview new product icon
        $("#edit_icon").on("change", function () {
            let file = this.files[0];
            if (file) {
                $("#new_icon_preview")
                    .attr("src", URL.createObjectURL(file))
                    .show();

                $("#old_icon_preview").hide();
            }
        });

        // Open Edit Popup
        $(document).on("click", ".editBtn", function () {
            let id = $(this).data("id");

            $.ajax({
                url: "/admin/product/edit/" + id,
                type: "GET",
                success: function (res) {

                    $("#edit_parentCategory").empty().append(`<option value="">Select Parent Category</option>`);
                    loadEditCategoryDropdown(res.category);
                    $("#edit_parentCategory").val(res.category);

                    $("#edit_id").val(res.id);
                    $("#edit_producttitle").val(res.productname);
                    $("#edit_productdescription").val(res.productdescription);

                    $("#update_price").val(res.price);
                    $("#edit_saleprice").val(res.saleprice);
                    $("#edit_productdescription").val(res.productdescription);


                    $("input[name='edit_BadgeSale'][value='" + res.badge + "']").prop("checked", true);

                    if (res.image) {
                        $("#old_image_preview").attr("src", "/storage/" + res.image).show();
                    } else {
                        $("#old_image_preview").hide();
                    }

                    if (res.icon) {
                        $("#old_icon_preview").attr("src", "/storage/" + res.icon).show();
                    } else {
                        $("#old_icon_preview").hide();
                    }

                    $("#new_image_preview").hide();
                    $("#new_icon_preview").hide();

                    $("#editProductModal").modal("show");
                }

            });
        });
        // Update PRODUCT
        $("#updateProductForm").on("submit", function (e) {
            e.preventDefault();

            let id = $("#edit_id").val();
            let formData = new FormData(this);

            $(".error-text").text("");

            $.ajax({
                url: "/admin/product/update/" + id,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (res) {

                    if (res.status === true) {

                        Swal.fire({
                            icon: "success",
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $("#editProductModal").modal("hide");
                        table.ajax.reload(null, false);
                    }
                },

                error: function (xhr) {

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function (key, value) {
                            $("." + key + "_error").text(value[0]);
                        });

                    } else {
                        Swal.fire({
                            icon: "error",
                            text: "Something went wrong!"
                        });
                    }
                }
            });
        });

        $(document).on("click", ".deleteBtn", function () {
            let id = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "This product will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "/admin/product/delete/" + id,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function (res) {
                            if (res.status === true) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: res.message
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Something went wrong!"
                            });
                        }
                    });

                }
            });
        });

    });
    function loadCategoryDropdown() {
        $.ajax({
            url: "{{ route('category.titles') }}",
            type: "GET",
            success: function (data) {

                $("#category").empty();
                $("#category").append(`<option value="">Select Category</option>`);

                data.forEach(item => {
                    $("#category").append(`
                    <option value="${item.original}">${item.title}</option>
                `);
                });
            }
        });
    }

    function loadEditCategoryDropdown(selectedValue = "") {
        $.ajax({
            url: "{{ route('category.titles') }}",
            type: "GET",
            success: function (data) {

                let dropdown = $("#edit_parentCategory");

                dropdown.empty();
                dropdown.append(`<option value="">Select Category</option>`);

                data.forEach(cat => {
                    dropdown.append(`
                    <option value="${cat.original}">${cat.title}</option>
                `);
                });

                // Auto set selected category
                if (selectedValue !== "") {
                    dropdown.val(selectedValue);
                }
            }
        });
    }

</script>
