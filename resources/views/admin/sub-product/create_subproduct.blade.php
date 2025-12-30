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
                                <h5 class="card-title">Add Sub Product</h5>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">


                                        <form id="addSubProductForm" enctype="multipart/form-data">
                                            @csrf

                                            <!-- ROW 1 -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Select Product</label>
                                                    <select class="form-control" id="category" name="product_id">
                                                        <option value="">Select Category</option>

                                                    </select>
                                                    <span class="text-danger error-text product_id_error"></span>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Name</label>
                                                    <input type="text" class="form-control" id="product_name"
                                                        name="product_name" placeholder="Enter product title">
                                                    <span class="text-danger error-text product_name_error"></span>
                                                </div>
                                            </div>

                                            <!-- ROW 2 -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Image</label>
                                                    <input type="file" class="form-control" id="product_image"
                                                        name="image">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Icon</label>
                                                    <input type="file" class="form-control" id="product_icon"
                                                        name="icon">
                                                </div>
                                            </div>

                                            <!-- ROW 3 -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Price</label>
                                                    <input type="text" class="form-control" id="edit_price"
                                                        name="product_price" placeholder="Enter price">
                                                    <span class="text-danger error-text product_price_error"></span>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Sale Price</label>
                                                    <input type="text" class="form-control" id="edit_saleprice"
                                                        name="product_saleprice" placeholder="Enter sale price">
                                                    <span class="text-danger error-text saleprice_error"></span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Quantity</label>
                                                    <input type="number" class="form-control" id="product_quantity"
                                                        name="product_quantity" placeholder="Enter Product Quantity">
                                                    <span class="text-danger error-text product_quantity_error"></span>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Size</label>
                                                    <input type="text" class="form-control" id="edit_product_size"
                                                        name="product_size" placeholder="Enter Product Size">
                                                    <span class="text-danger error-text product_size_error"></span>
                                                </div>
                                            </div>


                                            <!-- ROW 4 - Full Width Description -->
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Full Description</label>
                                                    <textarea class="form-control" id="product_description"
                                                        name="product_description" rows="3"
                                                        placeholder="Enter product description"></textarea>
                                                    <span
                                                        class="text-danger error-text product_description_error"></span>
                                                </div>
                                            </div>

                                            <!-- ROW 5 (NEW — split description into 2 fields for symmetry) -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Short Description</label>
                                                    <input type="text" class="form-control" id="product_sortdescription"
                                                        name="product_sortdescription" placeholder="Short description">
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

            <!-- display all data -->

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Sub Product List</h5>
                        </div>
                        <div class="card-body">
                            <table id="datatable1" class="display w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Parent Product</th>
                                        <th>Product Name</th>
                                        <th>Product Image</th>
                                        <th>Product Icon</th>
                                        <th>Price</th>
                                        <th>Sale Price</th>
                                        <th>Product Quantity</th>
                                        <th>Product Size</th>
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
                            <h5 class="modal-title">Edit Sub Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form id="updateSubProductForm">
                                @csrf

                                <input type="hidden" id="edit_id" name="id">

                                <!-- ROW 1 -->
                                <div class="row">

                                    <!-- Parent Category -->
                                    <div class="col-md-6 mb-3">
                                        <label>Parent Product</label>
                                        <select class="form-control" id="edit_parentProduct" name="product_id">
                                            <option value="">Select Parent Product</option>
                                        </select>
                                        <span class="text-danger error-text subproduct_error"></span>
                                    </div>

                                    <!-- Product Title -->
                                    <div class="col-md-6 mb-3">
                                        <label>Product Title</label>
                                        <input type="text" class="form-control" id="edit_productname"
                                            name="product_name">
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

                                        <input type="file" class="form-control" id="edit_image" name="product_image">

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

                                        <input type="file" class="form-control" id="edit_icon" name="product_icon">

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
                                        <input type="text" class="form-control" id="edit_price" name="edit_price">
                                        <span class="text-danger error-text edit_price_error"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Sale Price</label>
                                        <input type="text" class="form-control" id="edit_saleprice" name="edit_product_saleprice">
                                        <span class="text-danger error-text edit_product_saleprice_error"></span>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Product Quantity</label>
                                        <input type="number" class="form-control" id="edit_product_quantity"
                                            name="product_quantity" placeholder="Enter Product Quantity">
                                        <span class="text-danger error-text product_quantity_error"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Product Size</label>
                                        <input type="text" class="form-control" id="edit_product_size"
                                            name="product_size" placeholder="Enter Product Size">
                                        <span class="text-danger error-text product_size_error"></span>
                                    </div>
                                </div>

                                <!-- ROW 4 (Description) -->
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Sort Description</label>
                                        <textarea class="form-control" id="edit_sortproductdescription"
                                            name="product_description"></textarea>
                                    </div>
                                    <span class="text-danger error-text product_description_error"></span>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Description</label>
                                        <textarea class="form-control" id="edit_productdescription"
                                            name="product_sortdescription"></textarea>
                                    </div>
                                    <span class="text-danger error-text product_sortdescription_error"></span>
                                </div>

                                {{-- <button type="submit" class="btn btn-primary btn-sm float-start">
                                    Update Product
                                </button> --}}
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
        $("#addSubProductForm").on("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: ,
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
        // let table = $("#datatable1").DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ordering: false,

        //     ajax: {
        //         url: "{{ route('product.list') }}",
        //         type: "GET"
        //     },

        //     pageLength: 10,
        //     lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],

        //     columns: [
        //         { data: null, render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },

        //         { data: "category" },
        //         { data: "productname" },

        //         {
        //             data: "image",
        //             render: img => img ? `<img src="/storage/${img}" width="40">` : "No Image"
        //         },

        //         {
        //             data: "icon",
        //             render: img => img ? `<img src="/storage/${img}" width="30">` : "No Icon"
        //         },

        //         { data: "price" },
        //         { data: "saleprice" },
        //         { data: "productdescription" },

        //         {
        //             data: "id",
        //             render: id => `
        //         <a class="editBtn text-primary" data-id="${id}"><i class="fa-solid fa-pen-to-square"></i></a>
        //         <a class="deleteBtn text-danger" data-id="${id}" style="cursor:pointer">
        //             <i class="fa-solid fa-trash"></i>
        //         </a>
        //     `
        //         }
        //     ]
        // });

        // // Open popup form for update PRODUCT
        // $(document).on("click", ".editBtn", function () {
        //     let id = $(this).data("id");

        //     $.ajax({
        //         url: "/admin/product/edit/" + id,
        //         type: "GET",
        //         success: function (res) {

        //             // 1. Empty dropdown
        //             $("#edit_parentProduct").empty();

        //             // 2. Add default option
        //             $("#edit_parentProduct").append(`<option value="">Select Parent Category</option>`);

        //             // 3. Append categories coming from Blade
        //             loadEditCategoryDropdown(res.category);


        //             // 4. Set selected category for this product
        //             $("#edit_parentProduct").val(res.category);

        //             // Fill other fields
        //             $("#edit_id").val(res.id);
        //             $("#edit_productname").val(res.productname);
        //             $("#edit_productdescription").val(res.productdescription);
        //             $("#edit_price").val(res.price);
        //             $("#edit_saleprice").val(res.saleprice);

        //             // Show old image
        //             if (res.image) {
        //                 $("#old_image_preview").attr("src", "/storage/" + res.image).show();
        //             } else {
        //                 $("#old_image_preview").hide();
        //             }

        //             // Show old icon
        //             if (res.icon) {
        //                 $("#old_icon_preview").attr("src", "/storage/" + res.icon).show();
        //             } else {
        //                 $("#old_icon_preview").hide();
        //             }

        //             $("#new_image_preview").hide();
        //             $("#new_icon_preview").hide();

        //             $("#editProductModal").modal("show");
        //         }
        //     });
        // });


        // // Preview new product image
        // $("#edit_image").on("change", function () {
        //     let file = this.files[0];
        //     if (file) {
        //         $("#new_image_preview")
        //             .attr("src", URL.createObjectURL(file))
        //             .show();

        //         $("#old_image_preview").hide();
        //     }
        // });

        // // Preview new product icon
        // $("#edit_icon").on("change", function () {
        //     let file = this.files[0];
        //     if (file) {
        //         $("#new_icon_preview")
        //             .attr("src", URL.createObjectURL(file))
        //             .show();

        //         $("#old_icon_preview").hide();
        //     }
        // });


        // // Update PRODUCT
        // $("#updateSubProductForm").on("submit", function (e) {
        //     e.preventDefault();

        //     let id = $("#edit_id").val();
        //     let formData = new FormData(this);

        //     $(".error-text").text("");

        //     $.ajax({
        //         url: "/admin/product/update/" + id,
        //         type: "POST",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         headers: {
        //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        //         },
        //         success: function (res) {

        //             if (res.status === true) {

        //                 Swal.fire({
        //                     icon: "success",
        //                     text: res.message,
        //                     timer: 1500,
        //                     showConfirmButton: false
        //                 });

        //                 $("#editProductModal").modal("hide");
        //                 table.ajax.reload(null, false);
        //             }
        //         },

        //         error: function (xhr) {

        //             if (xhr.status === 422) {
        //                 let errors = xhr.responseJSON.errors;

        //                 $.each(errors, function (key, value) {
        //                     $("." + key + "_error").text(value[0]);
        //                 });

        //             } else {
        //                 Swal.fire({
        //                     icon: "error",
        //                     text: "Something went wrong!"
        //                 });
        //             }
        //         }
        //     });
        // });

        // $(document).on("click", ".deleteBtn", function () {
        //     let id = $(this).data("id");

        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "This product will be permanently deleted!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonText: "Yes, delete it!",
        //         cancelButtonText: "Cancel"
        //     }).then((result) => {
        //         if (result.isConfirmed) {

        //             $.ajax({
        //                 url: "/admin/product/delete/" + id,
        //                 type: "DELETE",
        //                 headers: {
        //                     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        //                 },
        //                 success: function (res) {
        //                     if (res.status === true) {
        //                         Swal.fire({
        //                             icon: "success",
        //                             title: "Deleted!",
        //                             text: res.message,
        //                             timer: 1500,
        //                             showConfirmButton: false
        //                         });

        //                         table.ajax.reload(null, false);
        //                     } else {
        //                         Swal.fire({
        //                             icon: "error",
        //                             title: "Error",
        //                             text: res.message
        //                         });
        //                     }
        //                 },
        //                 error: function () {
        //                     Swal.fire({
        //                         icon: "error",
        //                         title: "Error",
        //                         text: "Something went wrong!"
        //                     });
        //                 }
        //             });

        //         }
        //     });
        // });

    });
    // function loadCategoryDropdown() {
    //     $.ajax({
    //         url: "{{ route('category.titles') }}",
    //         type: "GET",
    //         success: function (data) {

    //             $("#category").empty();
    //             $("#category").append(`<option value="">Select Category</option>`);

    //             data.forEach(item => {
    //                 $("#category").append(`
    //                 <option value="${item.original}">${item.title}</option>
    //             `);
    //             });
    //         }
    //     });
    // }
    // function loadEditCategoryDropdown(selectedValue = "") {
    //     $.ajax({
    //         url: "{{ route('category.titles') }}",
    //         type: "GET",
    //         success: function (data) {

    //             let dropdown = $("#edit_parentProduct");

    //             dropdown.empty();
    //             dropdown.append(`<option value="">Select Category</option>`);

    //             data.forEach(cat => {
    //                 dropdown.append(`
    //                 <option value="${cat.original}">${cat.title}</option>
    //             `);
    //             });

    //             // Auto set selected category
    //             if (selectedValue !== "") {
    //                 dropdown.val(selectedValue);
    //             }
    //         }
    //     });
    // }

</script>
