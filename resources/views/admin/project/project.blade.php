@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')

    <style>
        /* Hide dropdown by default */
        .action-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 999;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-width: 140px;
            border-radius: 6px;
            display: none;
            padding: 6px 0;
        }

        /* Common style for items */
        .action-dropdown li {
            list-style: none;
        }

        /* Edit/Delete item style */
        .action-dropdown .dropdown-item {
            display: block;
            width: 100%;
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            background: none;
            text-align: left;
            color: #333;
            text-decoration: none;
            cursor: pointer;
        }

        /* Hover effect */
        .action-dropdown .dropdown-item:hover {
            background-color: #f5f5f5;
        }

        /* Delete button red */
        .action-dropdown .text-danger {
            color: #dc3545 !important;
        }

        /* Edit icon green */
        .action-dropdown .text-success {
            color: #28a745 !important;
        }
    </style>


    <style>
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            display: inline-block;
            text-align: center;
            min-width: 100px;
        }

        .status-pending {
            background-color: #ffc107;
            /* Yellow */
            color: #212529;
        }

        .status-processing {
            background-color: #007bff;
            /* Blue */
        }

        .status-completed {
            background-color: #a72828;
            /* Green */
        }
    </style>



    <!-- Bootstrap 5.3 JS Bundle (includes Popper) -->
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">

            <!-- Edit Popup (single edit) -->
            <!-- popup modal inside your Blade file -->

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- large and centered modal -->
                    <div class="modal-content">
                        <form id="editUserForm" action="{{ route('project.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="editId" name="id">
                            <input type="hidden" id="AllEditId" name="ids">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label for="editStatus" style="font-weight: bold;">Status:</label>
                                            <select name="status" id="editStatus" required
                                                style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ccc;
               border-radius: 6px; background-color: #f9f9f9; outline: none;">
                                                <option value="pending">Pending</option>
                                                <option value="accept">Accepted</option>
                                                <option value="reject">Rejected</option>

                                            </select>
                                        </div>

                                        <!-- DOB -->

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i>
                                    Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                        class="fa fa-times"></i> Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <h3 class="main-text-h3">Project</h3>
                      <button type="button" class="btn btn-primary mt-3" onclick="openAllEditModal()">
                                <i class="fa fa-edit"></i> All Status Update
                            </button>
                    <div class="table-functionality">
                        <div class="search-bar" style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                            <a href="{{ route('admin.addproject') }}"
                                style="background: linear-gradient(to right, #0056b3, #007bff);
                  color: white;
                  padding: 10px 25px;
                  font-size: 15px;
                  border: none;
                  border-radius: 50px;
                  text-decoration: none;
                  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                  gap: 8px; margin-left: 900px">
                                <i class="bi bi-plus-circle" style="font-size: 18px;"></i>+ Add Project
                            </a>
                          

                        </div>
                    </div>

                    <div id="data_container">
                        <h3 class="main-text-h3">Project Table</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Sr no.</th>

                                        <th>Project Name</th>
                                        <th>Client Name</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Project Remark</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($project as $item)
                                    <tbody>
                                        <tr>
                                            <td><input type="checkbox" class="allCheckbox" value="{{ $item->id }}">

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->client_name }}</td>
                                            <td>{{ $item->start_time }}</td>
                                            <td>{{ $item->end_time }}</td>
                                            <td>{{ $item->project_remark }}</td>
                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span class="status-badge status-pending">Pending</span>
                                                @elseif ($item->status == 'accept')
                                                    <span class="status-badge status-processing">Accepted</span>
                                                @elseif ($item->status == 'reject')
                                                    <span class="status-badge status-completed">Rejected</span>
                                                @endif
                                            </td>



                                            <td class="action-bar">
                                                <i class="fa fa-edit text-success ll" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" onclick="setEditData(this)"
                                                    data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                                </i>

                                                <a href="{{ route('project.delect', ['id' => $item->id]) }}"
                                                    class="dropdown-item text-danger">
                                                    <i class="fa fa-trash kk"></i>
                                                </a>

                                            </td>

                                        </tr>
                                    </tbody>
                                @endforeach

                            </table>
                        </div>
                    </div>





                </div>

                <script>
                    function setEditData(button) {
                        const id = button.getAttribute('data-id');
                        const status = button.getAttribute('data-status');

                        document.getElementById('AllEditId').value = '';
                        document.getElementById('editId').value = id;
                        document.getElementById('editStatus').value = status;
                    }
                </script>

                <script>
                    document.getElementById('selectAll').addEventListener('change', function() {
                        const isChecked = this.checked;
                        document.querySelectorAll('.allCheckbox').forEach(function(checkbox) {
                            checkbox.checked = isChecked;
                        });
                    });
                </script>


                <script>
                    function openAllEditModal() {
                        let selected = [];
                        document.querySelectorAll('.allCheckbox:checked').forEach(cb => {
                            selected.push(cb.value);
                        });

                        if (selected.length === 0) {
                            alert("Please select at least one leave");
                            return;
                        }

                        document.getElementById('editId').value = '';
                        document.getElementById('AllEditId').value = selected.join(',');
                        document.getElementById('editStatus').value = 'pending';

                        const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                        modal.show();
                    }
                </script>






                @include('tostar_msg.tostar');

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



            @endsection
