@extends('user.layout.usercontact')


@section('page', 'page title')


@section('usercontact')


    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

            <!-- Edit Popup (single edit) -->
            <div class="popup-overlay" onclick="removePopupEdit(event)" id="popupEdit">
                <div class="popup-content" id="popupUpInnerEdit">
                    <h3 class="popup-heading">Edit User</h3>
                    <button class="close-btn" onclick="handleEditClose()" type="button">&times;</button>
                    <div id="form_container" style="padding: 0;">
                        <form id="editUserForm" action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="editId" name="id">

                            <div class="form-input">
                                <label>Name:</label>
                                <input type="text" class="inp" id="editName" name="name" />
                            </div>

                            <div class="form-input">
                                <label>Email:</label>
                                <input type="email" class="inp" id="editEmail" name="email" />
                            </div>

                            <div class="form-input">
                                <label>Phone:</label>
                                <input type="tel" class="inp" id="editPhone" name="phone" />
                            </div>

                            <div class="form-input">
                                <label>Gender:</label>
                                <select id="editGender" name="gender" class="data-selectt">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-input">
                                <label>Date of Birth:</label>
                                <input type="date" class="inp" id="editDob" name="dob" />
                            </div>

                            <div class="form-input">
                                <label>City:</label>
                                <input type="text" class="inp" id="editCity" name="city" />
                            </div>

                            <div class="form-input">
                                <label>State:</label>
                                <input type="text" class="inp" id="editState" name="state" />
                            </div>

                            <div class="form-input">
                                <label>Country:</label>
                                <input type="text" class="inp" id="editCountry" name="country" />
                            </div>

                            <div class="form-input">
                                <label>Address:</label>
                                <textarea id="editAddress" name="address" class="data-text" rows="2"></textarea>
                            </div>

                            <div class="form-input">
                                <label>Profile Image:</label>
                                <input type="file" class="inp" id="editProfileImage" name="profile_image" />
                                <div>
                                    <img class="profile_img" id="editProfileImagePreview" src="" alt="Preview"
                                        width="60px" height="60px">
                                </div>
                            </div>

                            <div class="form-submit-container">
                                <button class="btn success" type="submit"><i class="fa fa-check"></i> Submit</button>
                                <button class="btn danger" type="button" onclick="handleEditClose()"><i
                                        class="fa fa-times"></i> Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- edit poup  ends (single edit)  -->



            <!-- delete popup ends  -->






            <div id="include_all_data_wrapper">
                <div id="table_data_page">



                    <br>
                    <br>
                    <br>

                    <div id="data_container">
                        <h3 class="main-text-h3">Users Holiday Table</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="inp-check" id="select_all_checkbox"
                                                onclick="handleSelectCheckboxAll(this)"></th>
                                        <th>Sr no.</th>

                                        <th>Holiday Name</th>
                                        <th>Holiday Date</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($holiday as $item)
                                    <tbody>
                                        <tr>
                                            <td><input type="checkbox" class="single-checkbox"
                                                    data-id="{{ $item->id }}"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->holiday_name }}</td>
                                            <td>{{ $item->holiday_date }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                @if ($item->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>



                                        </tr>
                                    </tbody>
                                @endforeach

                            </table>
                        </div>
                    </div>


                   

                </div>

                <script>
                    function handleTableSideEdit(element) {
                        const form = document.getElementById("editUserForm");
                        const popupEdit = document.getElementById("popupEdit");
                        const popupUpInnerEdit = document.getElementById("popupUpInnerEdit");

                        // Extract data attributes
                        const userId = element.dataset.id;
                        const userName = element.dataset.name;
                        const userEmail = element.dataset.email;
                        const userPhone = element.dataset.phone;
                        const userGender = element.dataset.gender;
                        const userDob = element.dataset.dob;
                        const userCity = element.dataset.city;
                        const userState = element.dataset.state;
                        const userCountry = element.dataset.country;
                        const userAddress = element.dataset.address;
                        const userImage = element.dataset.image;

                        // Fill values
                        document.getElementById("editId").value = userId;
                        document.getElementById("editName").value = userName;
                        document.getElementById("editEmail").value = userEmail;
                        document.getElementById("editPhone").value = userPhone;
                        document.getElementById("editGender").value = userGender;
                        document.getElementById("editDob").value = userDob;
                        document.getElementById("editCity").value = userCity;
                        document.getElementById("editState").value = userState;
                        document.getElementById("editCountry").value = userCountry;
                        document.getElementById("editAddress").value = userAddress;

                        if (userImage) {
                            document.getElementById("editProfileImagePreview").src = userImage;
                        }

                        // Set dynamic form action
                        form.action = `/admin/user/${userId}`;

                        // Show popup
                        popupEdit.classList.add("active");
                        setTimeout(() => popupUpInnerEdit.classList.add("active"), 300);
                    }

                    function handleEditClose() {
                        document.getElementById("popupUpInnerEdit").classList.remove("active");
                        setTimeout(() => {
                            document.getElementById("popupEdit").classList.remove("active");
                        }, 300);
                    }

                    function removePopupEdit(event) {
                        if (event.target.id === "popupEdit") handleEditClose();
                    }

                    function handleTableDelete(element) {
                        const userId = element.dataset.id;
                        const form = document.getElementById("deleteUserForm");
                        form.action = `/admin/user/${userId}`;
                        document.getElementById("popupDelete").classList.add("active");
                        setTimeout(() => {
                            document.getElementById("popupUpInnerDelete").classList.add("active");
                        }, 300);
                    }

                    function handleDeleteClose() {
                        document.getElementById("popupUpInnerDelete").classList.remove("active");
                        setTimeout(() => {
                            document.getElementById("popupDelete").classList.remove("active");
                        }, 300);
                    }

                    function removePopupDelete(e) {
                        if (e.target.id === "popupDelete") handleDeleteClose();
                    }

                    function handleSelectCheckboxAll(source) {
                        const checkboxes = document.querySelectorAll('.single-checkbox');
                        checkboxes.forEach(cb => cb.checked = source.checked);
                    }
                </script>




                <script src="https://cdn.tailwindcss.com"></script>

            @endsection
