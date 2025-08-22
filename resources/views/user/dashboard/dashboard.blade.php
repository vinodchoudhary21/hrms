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

        th {
            font-weight: bold;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">
            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <h3 class="main-text-h3">Dashboard</h3>


                {{-- <a href="{{ route('forgets.user') }}">forgrt</a> --}}

                    <section class="section dashboard">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">
                                    <!-- Sales Card -->
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="card info-card sales-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Date <span>| Today</span></h5>
                                                <p id="currentDate" class="mb-3">{{ $todayDate }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Attendance Card -->
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="card info-card revenue-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Attendance Total <span>| This Month</span></h5>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-calendar-check"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>{{ $thismonthAttendance }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Paid Leave Card -->
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="card info-card revenue-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Paid Leave Total <span>| This Month</span></h5>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-calendar-check"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>{{ $thismonthLeaves }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End Left side columns -->
                        </div>
                    </section>



                    <div id="data_container">
                        <h3 class="main-text-h3">Tasks</h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>

                                        <th>Sr no.</th>

                                        <th>Project Taks</th>
                                        <th>Employes</th>
                                        <th>Task Name</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @foreach ($Tasksh as $item)
                                    <tbody>
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->project->project_name ?? 'n/a' }}</td>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td>{{ $item->task_name }}</td>
                                            <td>{{ $item->start_time }}</td>
                                            <td>{{ $item->end_time }}</td>
                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span class="status-badge status-pending">Pending</span>
                                                @elseif ($item->status == 'In Processing')
                                                    <span class="status-badge status-processing">In Processing</span>
                                                @elseif ($item->status == 'Completed')
                                                    <span class="status-badge status-completed">Completed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach

                            </table>
                        </div>
                    </div>
                    <br>
                    <div id="data_container">
                        <h3 class="main-text-h3">Birthday</h3>
                        <div id="table_container">
                            <table id="data_table"class="shadow-table ">
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
                                            <td>{{ $item->dob }}</td>

                                        </tr>
                                    </tbody>
                                @endforeach

                            </table>
                        </div>
                    </div>
                    <br>

                    <div id="data_container">
                        <h3 class="main-text-h3">Holidays</h3>
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
                                                    <span class="status-badge status-accept">Active</span>
                                                @else
                                                    <span class="status-badge status-reject">Inactive</span>
                                                @endif
                                            </td>

                                        </tr>
                                    </tbody>
                                @endforeach

                            </table>
                        </div>
                    </div>
                    <br>

                    <div id="data_container">
                        <h3 class="main-text-h3">Attendance </h3>
                        <div id="table_container">
                            <table id="data_table" class="shadow-table ">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>User Name</th>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Working Hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attend as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') ?? 'N/A' }}
                                            <td>{{ $item->check_in }}</td>
                                            <td>{{ $item->check_out }}</td>
                                            <td>{{ $item->working_hours }}</td>
                                            <td>
                                                @if ($item->status == 'Present')
                                                    <span class="status-badge status-accept">Present</span>
                                                @elseif($item->status == 'Absent')
                                                    <span class="status-badge status-reject">Absent</span>
                                                @else
                                                    <span
                                                        class="status-badge status-pending">{{ ucfirst($item->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>


                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




























            @endsection
