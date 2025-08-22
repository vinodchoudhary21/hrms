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
            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <br>



                    <div id="data_container">
                        <h3 class="main-text-h3">Users Sallery Table</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>

                                        <th>Sr no.</th>

                                        <th>Employee Name</th>
                                        <th>Employee Email</th>
                                        <th>Month</th>
                                        <th>Salary</th>
                                        <th>Salary Clip</th>
                                    </tr>
                                </thead>
                                @foreach ($sallerysh as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                                        <td>{{ $item->user->email ?? 'N/A' }}</td>
                                        <td>{{ $item->month }}</td>
                                        <td>{{ $item->earned_salary }}</td>
                                        <td>
                                            <a href="{{ route('salary.slip.pdf', $item->id) }}"
                                                class="btn btn-success btn-sm">Download PDF</a>

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
