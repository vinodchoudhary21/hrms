@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-qmG6aYYa3OJ6ApSKVrA4JX+QkRHKAtUbE+uR9ke6qTruU6XvXQ3PEvJhTTQYCM05" crossorigin="anonymous">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pQn5oytR/kGNTX3HfAgKTT6a3kzCvFfL3fY+HOiOqOEgL33WITyDXDGoos5L3Afz" crossorigin="anonymous">
    </script>


    <style>
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            color: white;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }

        .status-active {
            background-color: #28a745;
            /* Green */
        }

        .status-inactive {
            background-color: #dc3545;
            /* Red */
        }
    </style>





    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">

            <!-- Edit Popup (single edit) -->
            <div class="popup-overlay" onclick="removePopupEdit(event)" id="popupEdit">
                <div class="popup-content" id="popupUpInnerEdit">
                    <h3 class="popup-heading">Edit Holiday</h3>
                    <button class="close-btn" onclick="handleEditClose()" type="button">&times;</button>
                    <div id="form_container" style="padding: 0;">
                        <form id="editHolidayForm" method="POST"
                            data-base-url="{{ url('http://localhost/ecommerce/admin/holiday/update') }}/"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="editHolidayId">

                            <div class="form-input">
                                <label for="editHolidayName">Holiday Name</label>
                                <input type="text" name="holiday_name" id="editHolidayName" class="form-control"
                                    required>
                            </div>

                            <div class="form-input">
                                <label for="editHolidayDate">Holiday Date</label>
                                <input type="date" name="holiday_date" id="editHolidayDate" class="form-control"
                                    required>
                            </div>

                            <div class="form-input">
                                <label for="editHolidayDescription">Description</label>
                                <textarea name="description" id="editHolidayDescription" class="form-control"></textarea>
                            </div>

                            <div class="form-input">
                                <label for="editHolidayStatus">Status</label>
                                <select name="status" id="editHolidayStatus" class="form-control" required>
                                    <option value="" disabled>Select status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="form-submit-container">
                                <button type="submit" style="background-color: blue; color:azure"
                                    class="btn btn-success">Save</button>
                                <br>
                                <button type="button" style="background-color: blue; color:azure"
                                    onclick="handleEditClose()" class="btn btn-danger">Cancel</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- edit poup  ends (single edit)  -->



            <!-- delete popup -->









            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <h3 class="main-text-h3">Holiday</h3>



                    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                        <a href="{{ route('add.holiday') }}"
                            style="background: linear-gradient(to right, #0056b3, #007bff);
              color: #fff;
              padding: 10px 25px;
              font-size: 15px;
              border: none;
              border-radius: 50px;
              text-decoration: none;
              box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
              display: inline-flex;
              align-items: center;
              gap: 8px;">
                            <i class="bi bi-plus-circle" style="font-size: 18px;"></i>+ Add Holiday
                        </a>
                    </div>


                    <div id="data_container">
                        <h3 class="main-text-h3">Holiday Table</h3>
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($holidays as $item)
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
                                                    <span class="status-badge status-active">Active</span>
                                                @else
                                                    <span class="status-badge status-inactive">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="action-bar">

                                                <i class="fa fa-edit  ll" onclick="handleHolidayEdit(this)"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->holiday_name }}"
                                                    data-date="{{ $item->holiday_date }}"
                                                    data-description="{{ $item->description }}"
                                                    data-status="{{ $item->status }}" title="Edit"
                                                    ></i>

                                                <a href="{{ route('holidays.delects', ['id' => $item->id]) }}"
                                                    style="color: white">
                                                    <i class="fa fa-trash kk"></i> Delete
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
                    function handleHolidayEdit(element) {
                        const popupEdit = document.getElementById("popupEdit");
                        const popupUpInnerEdit = document.getElementById("popupUpInnerEdit");
                        const form = document.getElementById("editHolidayForm");

                        // Set values
                        document.getElementById("editHolidayId").value = element.dataset.id;
                        document.getElementById("editHolidayName").value = element.dataset.name;
                        document.getElementById("editHolidayDate").value = element.dataset.date;
                        document.getElementById("editHolidayDescription").value = element.dataset.description;
                        document.getElementById("editHolidayStatus").value = element.dataset.status;

                        form.action = `http://localhost/ecommerce/admin/holiday/update/${element.dataset.id}`;

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
