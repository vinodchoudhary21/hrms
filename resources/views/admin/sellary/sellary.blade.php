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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">
            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <h3 class="main-text-h3">Sallery</h3>



                    <div class="table-functionality">
                        <div class="page-select">

                        </div>

                        <div class="pagination-container">


                        </div>

                        <div class="search-bar">
                            <a href="{{ route('admin.addsallery') }}"
                                style="background-color: blue; color:white; text-decoration:none" class="btn btn-primary">+
                                Add Sallery</a>
                        </div>

                    </div>

                    <div id="data_container">
                        <h3 class="main-text-h3">Users Data Table</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>

                                        <th>Sr no.</th>

                                        <th>Employes</th>
                                        <th>Month</th>
                                        <th>Sellery</th>
                                        <th>Sellery Clip</th>
                                    </tr>
                                </thead>
                                @foreach ($sellarys as $item)
                                    <tbody>
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->month)->format('m-Y') ?? 'N/A' }}
                                            <td>{{ $item->earned_salary ?? '' }}</td>
                                            <td><a href="{{ route('salary.slip.pdf', $item->id) }}"
                                                    class="btn btn-success btn-sm">Download PDF</a>
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
                        const id = element.dataset.id;
                        const status = element.dataset.status;

                        document.getElementById("editId").value = id;
                        document.getElementById("editStatus").value = status;

                        form.action = `/admin/work/update/${element.dataset.id}`;
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
                </script>

                <script>
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



                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
                </script>
            @endsection
