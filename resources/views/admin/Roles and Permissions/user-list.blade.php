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
                            <h5 class="card-title">Add User</h5>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="post" action="" id="addUserForm">
                                @csrf
                                <div class="col-md-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter full name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter email">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="number" placeholder="Enter phone">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Enter password">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Select Role</label>
                                    <select name="role_id" class="form-select">
                                        <option value="">Select Role</option>
                                        {{-- @foreach($role as $roles) --}}
                                        {{-- <option value="{{ $roles->id }}">{{ $roles->rolename }}</option> --}}
                                        {{-- @endforeach --}}
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">Save User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Management -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Manage Users</h5>
                        </div>
                        <div class="card-body">
                            <table id="datatable1" class="display w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit User Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="userForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="userModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="id" id="user_id">

                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="number" id="phone">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password (leave blank to keep old)</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-select" name="role_id" id="role_id" required>
                                        <option value="">Select Role</option>

                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save User</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="assignPermissionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="permissionForm">
            @csrf

            <input type="hidden" name="user_id" id="permission_user_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="permissionCheckboxes"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Save Permissions
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


@include('admin.includes.footer')

<script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#addUserForm").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('user.submit') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire("Success", "User added successfully!", "success");
                $('#datatable1').DataTable().ajax.reload(null, false);

    // optional: reset form
    $('#addUserForm')[0].reset();
            },
            error: function (xhr) {
                Swal.fire("Error", "Validation failed", "error");
            }
        });
    });

  $(document).ready(function () {

    let table = $('#datatable1').DataTable({
        processing: true,
        serverSide: false,
        ordering: false,

        ajax: {
            url: "{{ route('userlist') }}",
            type: "GET",
            dataSrc: "data"
        },

        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "name" },
            { data: "email" },
            { data: "role" },
            {
                data: "id",
                render: function (id) {
    return `
        <a href="javascript:void(0)"
           class="text-warning me-2 editBtn"
           data-id="${id}">
            <i class="fa-solid fa-pen-to-square fa-lg"></i>
        </a>

        <a href="javascript:void(0)"
           class="text-danger deleteBtn"
           data-id="${id}">
            <i class="fa-solid fa-trash fa-lg"></i>
        </a>
    `;
}

            }
        ]
    });

    // DELETE USER
    $(document).on('click', '.deleteBtn', function () {

        let id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This user will be deleted permanently.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('userdelete', ':id') }}".replace(':id', id),
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.status === true) {
                            Swal.fire("Deleted!", res.message, "success");
                            table.ajax.reload(null, false);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire("Error!", "Something went wrong!", "error");
                    }
                });
            }
        });
    });

});

</script>


<script>

$('#permissionForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('permissions.assign') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function (res) {
            Swal.fire("Success", res.message, "success");
            $('#assignPermissionModal').modal('hide');
        },
        error: function () {
            Swal.fire("Error", "Permission assign failed", "error");
        }
    });
});

</script>
