@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')

    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">


            <section id="add_data">
                <h2>
                    Add Project
                </h2>

                <div id="form_container">
                    <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf




                        <div class="form-input">
                            <label for="project_name" class="form-label">Project Name</label>
                            <input type="text" class="form-control" name="project_name" required="">
                        </div>

                        <!-- Email -->
                        <div class="form-input">
                            <label for="client_name" class="form-label">Client Name</label>
                            <input type="text" class="form-control" name="client_name" required="">
                        </div>

                        <div class="form-input">
                            <label for="start_time" class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_time" required="">
                        </div>
                        <div class="form-input">
                            <label for="end_time" class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_time" required="">
                        </div>
                        <div class="form-input">
                            <label for="project_remark" class="form-label">Project Remark</label>
                            <input type="text" class="form-control" name="project_remark" required="">
                        </div>




                        <!-- Gender -->

                        <div class="d-flex " style="margin-left: 400px">
                            <button type="submit" style="background-color: blue; color:white; text-decoration:none;"
                                class="btn btn-primary">Submit Project</button>

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


            @include('tostar_msg.tostar');



        @endsection
