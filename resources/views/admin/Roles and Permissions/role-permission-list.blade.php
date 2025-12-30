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
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Role Permissions Management</h5>
                        </div>
                        <div class="card-body">
                            <table id="datatable1" class="display w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Role Name</th>
                                        <th>Description</th>
                                        <th>Manage Permissions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manage Permissions Modal -->
            <div class="modal fade" id="managePermissionsModal" tabindex="-1"
                aria-labelledby="managePermissionsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form id="assignPermissionsForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="managePermissionsModalLabel">Manage Permissions</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="role_id" id="modal_role_id">

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="select_all_permissions">
                                        <label class="form-check-label fw-bold" for="select_all_permissions">Select All
                                            Permissions</label>
                                    </div>
                                </div>

                                <div id="permissionsList" class="row">
                                    <!-- Permissions will be dynamically loaded here -->
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save Permissions</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>


@include('admin.includes.footer')

<script>
    let table = $("#datatable1").DataTable({
        processing: true,
        serverSide: false,
        ordering: false,

        ajax: {
            url: "{{ route('role.list') }}",
            type: "GET"
        },

        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],

        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },

            { data: "rolename" },
            { data: "description" },

           {
                data: 'id',
                orderable: false,
                render: function (id) {
                    return `
                        <button class="btn btn-sm btn-warning manage-permissions" data-id="${id}">Manage Permissions</button>
                    `;
                }
            }
        ]
    });



</script>

<script>
    // Open modal & fetch permissions
    $(document).on('click', '.manage-permissions', function () {
        let roleId = $(this).data('id');
        $('#modal_role_id').val(roleId);
        $('#permissionsList').html('');

        $.ajax({
            url: "{{ route('permissions.list') }}",
            type: "GET",
            success: function (res) {
                if (res.status) {
                    let html = '';

                    $.each(res.data, function (index, permission) {
                        html += `
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input permission-checkbox"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="${permission.id}"
                                        id="permission_${permission.id}">
                                    <label class="form-check-label" for="permission_${permission.id}">
                                        ${permission.permission_name }
                                    </label>
                                </div>
                            </div>
                        `;
                    });

                    $('#permissionsList').html(html);
                    $('#managePermissionsModal').modal('show');
                }
            }
        });
    });

    // Select All permissions
    $(document).on('change', '#select_all_permissions', function () {
        $('.permission-checkbox').prop('checked', $(this).is(':checked'));
    });

    // Save permissions
    $('#assignPermissionsForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('permissions.assign') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (res) {
                if (res.status) {
                    $('#managePermissionsModal').modal('hide');
                    alert(res.message);
                }
            }
        });
    });
</script>
