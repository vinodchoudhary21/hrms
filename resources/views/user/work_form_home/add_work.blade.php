@extends('user.layout.usercontact')


@section('page', 'page title')


@section('usercontact')








    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">


            <section id="add_data">
                <h2>
                    Add Work Form Home
                </h2>

                <div id="form_container">
                    <form action="{{ route('work.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-input">
                            <label for="work_date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="work_date" required="">
                        </div>

                        <!-- Email -->
                        <div class="form-input">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" name="start_time" required="">
                        </div>

                        <div class="form-input">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" name="end_time" required="">
                        </div>

                        <div class="form-input">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                        </div>

                        <div class="form-input">
                            <label for="location" class="form-label">Location</label>
                            <textarea class="form-control" id="location" name="location" rows="3"></textarea>
                        </div>
                        <div class="form-input" style="display: none;">
                            <select name="status" id="editStatus" class="form-select form-control"
                                style="width: 320px; height: 45px;">
                                <option value="pending">Pending</option>
                                <option value="accept">Accept</option>
                                <option value="reject">Reject</option>
                            </select>
                        </div>




                        <!-- Gender -->

                        <div class="d-flex " style="margin-left: 400px">
                            <button type="submit" style="background-color: blue; color:white; text-decoration:none;"
                                class="btn btn-primary">Submit Work From Home</button>

                        </div>
                        <!-- DOB -->

                        <br>
                        <br>
                        <br>
                        <br>
                    </form>
                </div>
            </section>












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





        @endsection
