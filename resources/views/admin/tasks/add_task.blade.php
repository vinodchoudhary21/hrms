@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')

    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">


            <section id="add_data">
                <h2>
                    Add Data
                </h2>

                <div id="form_container">
                    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf



                        <div class="form-input" style="margin-bottom: 15px;">
                            <label for="project_id" style="font-weight: bold;">Project Task:</label>
                            <select class="inp" id="project_id" name="project_id" required
                                style="width: 30%; height: 45px; padding: 8px 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 6px;">
                                <option value="" disabled selected>Select Project</option>
                                @foreach ($projectsh as $items)
                                    <option value="{{ $items->id }}">{{ $items->project_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-input" style="margin-bottom: 15px;">
                            <label for="user_id" style="font-weight: bold;"> Employes Name:</label>
                            <select class="inp" id="user_id" name="user_id" required
                                style="width: 30%; height: 45px; padding: 8px 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 6px;">
                                <option value="" disabled selected>Select Project</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Email -->

                        <div class="form-input">
                            <label for="task_name" class="form-label">Tasks Name</label>
                            <input type="text" class="form-control" name="task_name" required="">
                        </div>

                        <div class="form-input">
                            <label for="start_time" class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_time" required="">
                        </div>
                        <div class="form-input">
                            <label for="end_time" class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_time" required="">
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
