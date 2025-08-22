@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')


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
            background-color: #a72828;
            /* Green */
        }
    </style>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">
            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <h3 class="main-text-h3">Users Data</h3>



                  

                    <div id="data_container">
                        <h3 class="main-text-h3">Holidays </h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>

                                        <th>Sr no.</th>

                                        <th>Holiday Name</th>
                                        <th>Holiday Date</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @foreach ($holidays as $item)
                                    <tbody>
                                        <tr>

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

                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div id="data_container">
                        <h3 class="main-text-h3">Birthdays</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>

                                        <th>Sr no.</th>

                                        <th><b>Employee Name</b></th>
                                        <th><b>date of Brith</b></th>

                                    </tr>
                                </thead>
                                @foreach ($birthdays as $item)
                                    <tbody>
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->dob)->format('d - m  - Y') }}</td>

                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div id="data_container">
                        <h3 class="main-text-h3">Leaves</h3>
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
                                    </tr>
                                </thead>
                                @foreach ($leaves as $item)
                                    <tbody>
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td>{{ $item->leave_type_id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->start_at)->format('d - m  - Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->end_at)->format('d - m  - Y') }}</td>
                                            <td>{{ $item->reason }}</td>
                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span class="status-badge status-pending">Pending</span>
                                                @elseif ($item->status == 'accept')
                                                    <span class="status-badge status-processing">Accepted</span>
                                                @elseif ($item->status == 'reject')
                                                    <span class="status-badge status-completed">Rejected</span>
                                                @endif
                                            </td>



                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

@include('tostar_msg.tostar');

            @endsection
