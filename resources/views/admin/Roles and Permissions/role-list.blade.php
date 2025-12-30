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
                            <h5 class="card-title">Add Role</h5>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" id="roleForm">
                                @csrf
                                <div class="col-md-3">
                                    <label class="form-label">Role Name</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter role name">
                                    <span class="text-danger error-text name_error"></span>

                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">description</label>
                                    <input type="text" name="description" class="form-control"
                                        placeholder="Enter description">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">Save Role</button>
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
                            <h5 class="card-title">Role List</h5>
                        </div>
                        <div class="card-body">
                            <table id="datatable1" class="display w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Role Name</th>
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

            <div class="modal fade" id="editRoleModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form id="updateRoleForm">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <input type="hidden" id="edit_id" name="id">

                                <div class="mb-3">
                                    <label>Role Name</label>
                                    <input type="text" id="edit_name" name="name" class="form-control">
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
    $(document).ready(function(){
        $('#roleForm').on('submit',function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url:"{{ route('rolesubmit') }}",
                method:"POST",
                data:formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    if(response.status == true){
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $("#roleForm")[0].reset();
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
            url: "{{ route('roles') }}",
            type: "GET"
        },

        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },

            { data: "name" },

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

    $(document).on("click", ".deleteBtn", function () {
    let id = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "This role will be deleted permanently.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('roledelete', ':id') }}".replace(':id', id),
                type: "DELETE",

                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')  // 🔥 REQUIRED
                },

                success: function (res) {
                    if (res.status === true) {
                        Swal.fire("Deleted!", res.message, "success");
                        $("#datatable1").DataTable().ajax.reload();
                        table.ajax.reload(null, false);
                    }
                },

                error: function (xhr) {
                    console.log("DELETE ERROR:", xhr.responseText);
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
        url: "/roles/edit/" + id,
        type: "GET",
        success: function (res) {

            $("#edit_id").val(res.id);
            $("#edit_name").val(res.name);
            $("#edit_description").val(res.description);

            $("#editRoleModal").modal("show");
        }
    });
});


// UPDATE ROLE AJAX
$("#updateRoleForm").on("submit", function (e) {
    e.preventDefault();

    let id = $("#edit_id").val();
    let formData = new FormData(this);

    $.ajax({
        url: "/roles/update/" + id,
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

                $("#editRoleModal").modal("hide");

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
