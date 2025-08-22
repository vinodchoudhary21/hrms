@extends('user.layout.usercontact')


@section('page', 'page title')


@section('usercontact')


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
            background-color: #28a745;
            /* Green */
        }
    </style>


    <!-- Bootstrap 5.3 JS Bundle (includes Popper) -->
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- large and centered modal -->
                    <div class="modal-content">
                        <form id="editUserForm" action="{{ route('task.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="editId" name="id">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row g-3">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <label for="editTaskName" class="form-label">Task name</label>
                                            <input type="text" class="form-control" id="editTaskName" name="task_name"
                                                required readonly>
                                        </div>


                                        <!-- Gender -->
                                        <div class="col-md-6">
                                            <label for="editStatus" style="font-weight: bold;">Status:</label>
                                            <select name="status" id="editStatus" required
                                                style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ccc;
               border-radius: 6px; background-color: #f9f9f9; outline: none;">
                                                <option value="pending">Pending</option>
                                                <option value="In Processing">In Processing</option>
                                                <option value="Completed">Completed</option>

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


            <div class="popup-overlay" onclick="removePopupDelete(event)" id="popupDelete">
                <div class="popup-content width-50" id="popupUpInnerDelete">
                    <h3 class="popup-heading">Are you sure to delete the record</h3>
                    <button class="close-btn" id="closePopupBtnDelete" onclick="handleDeleteClose(this)">&times;</button>
                    <div id="form_container" style="padding: 0;">
                        <form action="" id="" class="">



                            <div class="form-submit-container">
                                <button class="btn success"><i class="fa fa-check over-hid"></i>Yes</button>
                                <button class="btn danger" onclick="handleDeleteClose(this)"><i
                                        class="fa fa-x-mark"></i>No</button>

                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- delete popup ends  -->








            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <h3 class="main-text-h3">Users Task</h3>



                    <div class="table-functionality">
                        <div class="page-select">

                        </div>

                        <div class="pagination-container">


                        </div>

                        <div class="search-bar">

                        </div>

                    </div>

                    <div id="data_container">
                        <h3 class="main-text-h3">Users Task Table</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>

                                        <th>Sr no.</th>

                                        <th>Project Taks</th>
                                        <th>Employes</th>
                                        <th>Task Name</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($Tasksh as $item)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->project->project_name ?? 'n/a' }}</td>
                                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                                        <td>{{ $item->task_name }}</td>
                                        <td>{{ $item->start_time }}</td>
                                        <td>{{ $item->end_time }}</td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="status-badge status-pending">Pending</span>
                                            @elseif ($item->status == 'In Processing')
                                                <span class="status-badge status-processing">In Processing</span>
                                            @elseif ($item->status == 'Completed')
                                                <span class="status-badge status-completed">Completed</span>
                                            @endif
                                        </td>



                                        <td>

                                            <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                onclick="setEditData(this)" data-id="{{ $item->id }}"
                                                data-name="{{ $item->task_name }}" data-status="{{ $item->status }}"> <i
                                                    style="background-color:none" class="fa fa-edit text-success edit"></i></a>


                                            <a href="{{ route('tasksuser.delect', ['id' => $item->id]) }}">
                                                <i class="fa fa-trash delect"></i>
                                            </a>
                                        </td>






                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>





                </div>

                <script>
                    function setEditData(button) {
                        const id = button.getAttribute('data-id');
                        const name = button.getAttribute('data-name');
                        const status = button.getAttribute('data-status');

                        // Set form values in modal
                        document.getElementById('editId').value = id;
                        document.getElementById('editTaskName').value = name;
                        document.getElementById('editStatus').value = status;
                    }
                </script>


                <script>
                    function toggleDropdown(button) {
                        const dropdown = button.nextElementSibling;
                        // Close all other open dropdowns
                        document.querySelectorAll('.action-dropdown').forEach(el => {
                            if (el !== dropdown) el.style.display = 'none';
                        });
                        // Toggle current
                        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
                    }

                    // Close dropdown if clicked outside
                    document.addEventListener('click', function(event) {
                        if (!event.target.closest('.action-wrapper')) {
                            document.querySelectorAll('.action-dropdown').forEach(el => el.style.display = 'none');
                        }
                    });
                </script>





                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


            @endsection
