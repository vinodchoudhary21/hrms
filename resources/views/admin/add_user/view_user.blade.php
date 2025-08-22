@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')


    <link rel="stylesheet" href="{{ url('/') }}/public/admin/css/style.css">

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




    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">


            <div id="include_all_data_wrapper">
                <div id="table_data_page">

                    <div class="table-functionality">


                        <div class="pagination-container">


                        </div>


                    </div>

                    <div id="data_container">
                        <h3 class="main-text-h3">Users Data Table</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="inp-check" id="select_all_checkbox"
                                                onclick="handleSelectCheckboxAll(this)"></th>
                                        <th>Sr no.</th>

                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Address</th>
                                        <th>Sallery</th>
                                        <th>Profile img</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($view_Add as $item)
                                    <tbody>
                                        <tr>
                                            <td><input type="checkbox" class="single-checkbox"
                                                    data-id="{{ $item->id }}"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td>{{ $item->dob }}</td>
                                            <td>{{ $item->city }}</td>
                                            <td>{{ $item->state }}</td>
                                            <td>{{ $item->country }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->sallery }}</td>
                                            <td><img src="{{ url('public/storage/admin/form/profile_image/' . $item->profile_image) }}"
                                                    width="50px"></td>
                                            <td class="action-bar">

                                                <!-- Custom Dropdown -->

                                                <a href="javascript:void(0);" class="icon-btn" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" onclick="setEditData(this)"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                    data-email="{{ $item->email }}" data-phone="{{ $item->phone }}"
                                                    data-gender="{{ $item->gender }}" data-dob="{{ $item->dob }}"
                                                    data-city="{{ $item->city }}" data-state="{{ $item->state }}"
                                                    data-country="{{ $item->country }}"
                                                    data-address="{{ $item->address }}"
                                                    data-sallery="{{ $item->sallery ?? '' }}"
                                                    data-image="{{ asset('public/storage/admin/form/profile_image/' . $item->profile_image) }}"
                                                    title="Edit">
                                                    <i class="fa fa-edit text-success ll"></i>
                                                </a>

                                                <a href="{{ route('del.view', ['id' => $item->id]) }}"
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


                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- large and centered modal -->
                        <div class="modal-content">
                            <form id="editUserForm" action="{{ route('user.update') }}" method="post"
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
                                                <label for="editName" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="editName" name="name"
                                                    required>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6">
                                                <label for="editEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="editEmail" name="email"
                                                    required>
                                            </div>

                                            <!-- Phone -->
                                            <div class="col-md-6">
                                                <label for="editPhone" class="form-label">Phone</label>
                                                <input type="tel" class="form-control" id="editPhone" name="phone">
                                            </div>

                                            <!-- Gender -->
                                            <div class="col-md-6">
                                                <label for="editGender" class="form-label">Gender</label>
                                                <select class="form-select" id="editGender" name="gender">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>

                                            <!-- DOB -->
                                            <div class="col-md-6">
                                                <label for="editDob" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="editDob"
                                                    name="dob">
                                            </div>

                                            <!-- City -->
                                            <div class="col-md-6">
                                                <label for="editCity" class="form-label">City</label>
                                                <input type="text" class="form-control" id="editCity"
                                                    name="city">
                                            </div>

                                            <!-- State -->
                                            <div class="col-md-6">
                                                <label for="editState" class="form-label">State</label>
                                                <input type="text" class="form-control" id="editState"
                                                    name="state">
                                            </div>

                                            <!-- Country -->
                                            <div class="col-md-6">
                                                <label for="editCountry" class="form-label">Country</label>
                                                <input type="text" class="form-control" id="editCountry"
                                                    name="country">
                                            </div>

                                            <!-- Address -->
                                            <div class="col-12">
                                                <label for="editAddress" class="form-label">Address</label>
                                                <textarea class="form-control" id="editAddress" name="address" rows="2"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="editSallery" class="form-label">Sallery</label>
                                                <input type="number" class="form-control" id="editSallery"
                                                    name="sallery">
                                            </div>

                                            <!-- Profile Image -->
                                            <div class="col-12">
                                                <label for="editProfileImage" class="form-label">Profile Image</label>
                                                <input type="file" class="form-control" id="editProfileImage"
                                                    name="profile_image">
                                                <img id="editProfileImagePreview" src="" alt="Preview"
                                                    width="60" height="60" class="mt-2">
                                            </div>
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
                {{-- @endforeach --}}


                <!-- HEAD -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

                <!-- BODY के अंत में -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                <script>
                    function setEditData(button) {
                        const id = button.getAttribute('data-id');
                        const name = button.getAttribute('data-name');
                        const email = button.getAttribute('data-email');
                        const phone = button.getAttribute('data-phone');
                        const gender = button.getAttribute('data-gender');
                        const dob = button.getAttribute('data-dob');
                        const city = button.getAttribute('data-city');
                        const state = button.getAttribute('data-state');
                        const country = button.getAttribute('data-country');
                        const address = button.getAttribute('data-address');
                        const sallery = button.getAttribute('data-sallery');
                        const image = button.getAttribute('data-image');

                        // Set values in form
                        document.getElementById('editId').value = id;
                        document.getElementById('editName').value = name;
                        document.getElementById('editEmail').value = email;
                        document.getElementById('editPhone').value = phone;
                        document.getElementById('editGender').value = gender;
                        document.getElementById('editDob').value = dob;
                        document.getElementById('editCity').value = city;
                        document.getElementById('editState').value = state;
                        document.getElementById('editCountry').value = country;
                        document.getElementById('editAddress').value = address;
                        document.getElementById('editSallery').value = sallery;
                        document.getElementById('editProfileImagePreview').src = image;
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

                @include('tostar_msg.tostar');

            @endsection
