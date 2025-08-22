@extends('user.layout.usercontact')


@section('page', 'page title')


@section('usercontact')



    <style>
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            display: inline-block;
            text-align: center;
            min-width: 80px;
        }

        .status-pending {
            background-color: #ffc107;
            /* Yellow */
            color: #212529;
        }

        .status-accept {
            background-color: #007bff;
            /* Blue */
        }

        .status-reject {
            background-color: #dc3545;
            /* Red */
        }
    </style>




    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">


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
                    <h3 class="main-text-h3">Users Leaves</h3>



                    <div class="table-functionality">
                        <div class="page-select">

                        </div>

                        <div class="pagination-container">


                        </div>

                        <div class="search-bar" style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                            <a href="{{ route('user.addleaves') }}"
                                style="background: linear-gradient(to right, #520ff0, #043bd4);
              color: white;
              padding: 10px 25px;
              font-size: 15px;
              border: none;
              border-radius: 50px;
              text-decoration: none;
              box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
              display: inline-flex;
              align-items: center;
              gap: 8px;">
                                <i class="bi bi-plus-circle" style="font-size: 18px;"></i>+ Add Leaves
                            </a>
                        </div>


                    </div>

                    <div id="data_container">
                        <h3 class="main-text-h3">Users Leaves Table</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>
                                        <th>SR</th>
                                        <th>Employee Name</th>
                                        <th>Leave Type</th>
                                        <th>Start Date</th>
                                        <th>End Date </th>
                                        <th>Rejection Reason</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                @foreach ($leaves as $item)
                                    <tbody>
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td>{{ $item->leave_type_id }}</td>
                                            <td>{{ $item->start_at }}</td>
                                            <td>{{ $item->end_at }}</td>
                                            <td>{{ $item->reason }}</td>
                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span class="status-badge status-pending">Pending</span>
                                                @elseif ($item->status == 'accept')
                                                    <span class="status-badge status-accept">Accepted</span>
                                                @elseif ($item->status == 'reject')
                                                    <span class="status-badge status-reject">Rejected</span>
                                                @endif

                                            </td>

                                            <td class="action-bar">
                                                @if ($item->status != 'accept')
                                                    <a href="{{ route('leaves.delect', ['id' => $item->id]) }}">
                                                        <i class="fa fa-trash delect"></i>
                                                    </a>
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





            @endsection
