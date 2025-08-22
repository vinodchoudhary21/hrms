@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')

    <style>
        /* Popup background */
        .popup-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            display: none;
            /* Initially hidden */
        }

        .popup-overlay.active {
            display: flex;
        }

        /* Popup content box */
        .popup-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .popup-heading {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        select,
        button {
            width: 100%;
            padding: 0.6rem;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #218838;
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


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">

            <!-- Edit Popup (single edit) -->
            <!-- popup modal inside your Blade file -->

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- large and centered modal -->
                    <div class="modal-content">
                        <form id="editUserForm" action="{{ route('tasks.updates') }}" method="post"
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




            <!-- delete popup -->
            <div class="popup-overlay" onclick="removePopupDelete(event)" id="popupDelete">
                <div class="popup-content width-50" id="popupUpInnerDelete">
                    <h3 class="popup-heading">Are you sure to delete the record</h3>
                    <button class="close-btn" id="closePopupBtnDelete" onclick="handleDeleteClose(this)">&times;</button>
                    <div id="form_container" style="padding: 0;">
                        <div class="popup-content" id="popupUpInnerEdit">
                            <h3 class="popup-heading">Edit Project</h3>
                            <button class="close-btn" onclick="handleEditClose()" type="button">&times;</button>

                            <div class="form-wrapper">
                                <form method="POST" id="editUserForm" action="">
                                    @csrf
                                    <input type="hidden" name="id" id="editId">

                                    <div class="form-group">
                                        <label for="editStatus">Status</label>
                                        <select name="status" id="editStatus" required>
                                            <option value="pending">Pending</option>
                                            <option value="accept">Accept</option>
                                            <option value="reject">Reject</option>
                                        </select>
                                    </div>

                                    <button type="submit">Update</button>
                                </form>
                            </div>

                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>

                    </div>
                </div>
            </div>

            <!-- delete popup ends  -->








            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <h3 class="main-text-h3">Users Data</h3>



                    <div class="table-functionality">
                        <div class="page-select">

                        </div>

                        <div class="pagination-container">


                        </div>

                        <div class="search-bar">
                            <a href="{{ route('admin.addtasks') }}"
                                style="background-color: blue; color:white; text-decoration:none" class="btn btn-primary">+
                                Add Project</a>
                        </div>

                    </div>

                    <div id="data_container">
                        <h3 class="main-text-h3">Users Data Table</h3>
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
                                    <tbody>
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
                                            <td class="action-bar">
                                                <i class="fa fa-edit text-success ll" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" onclick="setEditData(this)"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->task_name }}"
                                                    data-status="{{ $item->status }}">
                                                </i>

                                                <a href="{{ route('tasks.delect', ['id' => $item->id]) }}"
                                                    class="dropdown-item text-danger">
                                                    <i class="fa fa-trash kk"></i>

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


                @if (session('success'))
                    <div id="customToast"
                        style="position: fixed; top: 20px; right: 20px; z-index: 9999; background-color: #28a745; color: white;
                padding: 12px 20px; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.15); display: none;">
                        {{ session('success') }}
                    </div>

                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            const toast = document.getElementById('customToast');
                            if (toast) {
                                toast.style.display = 'block';
                                setTimeout(() => {
                                    toast.style.display = 'none';
                                }, 3000);
                            }
                        });
                    </script>
                @endif



                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            @endsection
