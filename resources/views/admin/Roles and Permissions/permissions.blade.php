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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Permission</h5>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="post" action="" id="permissionForm">
                                <div class="col-md-5">
                                    <label class="form-label">Permission Name</label>
                                    <input type="text" name="permission_name" class="form-control"
                                        placeholder="e.g., agent.create">
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="description" class="form-control"
                                        placeholder="Short description">
                                </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Save Permission</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Permission List</h5>
                        </div>
                        <div class="card-body">
                            <table id="datatable1" class="display w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Permission Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="editpermissionModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form id="updatepermissionForm">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Permission</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <input type="hidden" id="edit_id" name="id">

                                <div class="mb-3">
                                    <label>Permission Name</label>
                                    <input type="text" id="edit_permissioname" name="permission_name"
                                        class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Description</label>
                                    <input type="text" id="edit_description" name="description" class="form-control">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


@include('admin.includes.footer')

<script>
    $(document).ready(function () {

        //for add data
        $('#permissionForm').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{ route('permissionsubmit') }}",
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status == true) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $("#permissionForm")[0].reset();
                    }
                    table.ajax.reload(null, false);
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
            })
        })

        // DataTable initialization
        let table = $('#datatable1').DataTable({
            processing: true,
            serverSide: false,
            ordering: false,

            ajax: {
                url: "{{ route('permissions') }}",
                type: "GET"
            },

            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },

                { data: "permission_name" },

                { data: "description" },

                {
                    data: "id",
                    render: function (id) {
                        return `
            <a href="javascript:void(0)" class="text-warning me-2 editBtn" data-id="${id}" style="cursor:pointer;">
                <i class="fa-solid fa-pen-to-square fa-lg"></i>
            </a>

            <a href="javascript:void(0)" class="text-danger deleteBtn" data-id="${id}" style="cursor:pointer;">
                <i class="fa-solid fa-trash fa-lg"></i>
            </a>
        `;
                    }
                }

            ]

        });


        //for delete
        $(document).on("click", ".deleteBtn", function () {
            let id = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "This permission will be deleted permanently.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/permission/delete/${id}`,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status) {
                                Swal.fire("Deleted!", response.message, "success");

                                // Remove row if needed
                                $(`#row-${id}`).remove();
                                table.ajax.reload(null, false);
                            }

                        },
                        error: function () {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }
                    });
                }
            });
        });


        // OPEN ROLE EDIT POPUP
        $(document).on("click", ".editBtn", function () {
            let id = $(this).data("id");

            $.ajax({
                url: "/permission/edit/" + id,
                type: "GET",
                success: function (res) {

                    $("#edit_id").val(res.id);
                    $("#edit_permissioname").val(res.permission_name);
                    $("#edit_description").val(res.description);

                    $("#editpermissionModal").modal("show");
                }
            });
        });


        // UPDATE Permission AJAX
        $("#updatepermissionForm").on("submit", function (e) {
            e.preventDefault();

            let id = $("#edit_id").val();
            let formData = new FormData(this);

            $.ajax({
                url: "/permission/update/" + id,
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

                        $("#editpermissionModal").modal("hide");

                        // reload datatable
                        table.ajax.reload(null, false);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let msg = "";

                        $.each(errors, function (key, value) {
                            msg += value[0] + "<br>";
                        });

                        Swal.fire({
                            icon: "error",
                            title: "Validation Error",
                            html: msg
                        });

                    } else {
                        Swal.fire("Error", "Something went wrong!", "error");
                    }
                }
            });
        });


    })
</script>