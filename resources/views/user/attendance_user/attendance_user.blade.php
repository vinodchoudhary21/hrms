@extends('user.layout.usercontact')


@section('page', 'page title')


@section('usercontact')


        <link rel="stylesheet" href="{{ url('/') }}/public/admin/css/style.css">

       
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">
            <div id="include_all_data_wrapper">
                <div id="table_data_page">
                    <h3 class="main-text-h3">Dashboard</h3>




                    <section class="section dashboard">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                        <div class="card info-card sales-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Date <span>| Today</span></h5>
                                                <p id="currentDate" class="mb-3">{{ $todayDate }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        @if (!$hasAttendance)
                                                            <form method="POST" action="{{ route('check.in') }}">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-primary border-2 text-white"
                                                                    style="background-color: green;">
                                                                    Check-In
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('check.out') }}">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-danger border-2 text-white"
                                                                    style="background-color: red;">
                                                                    Check-out
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class=" container">

                                        <form method="GET" action="{{ route('attendance.user') }}">
                                            @csrf
                                            <div class="row g-2 align-items-end">
                                                <div class="col-md-4">
                                                    <label class="form-label">From Date</label>
                                                    <input type="date" name="from_date" class="form-control"
                                                        value="{{ request('from_date') }}">
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">To Date</label>
                                                    <input type="date" name="to_date" class="form-control"
                                                        value="{{ request('to_date') }}">
                                                </div>

                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div id="data_container" class="containerx">
                                        <h3 class="main-text-h3"> Attendance </h3>
                                        <div id="table_container">
                                            <table id="data_table" class="shadow-table">
                                                <thead>
                                                    <tr>
                                                        <th>Sr no.</th>
                                                        <th>User Name</th>
                                                        <th>Date</th>
                                                        <th>Check In</th>
                                                        <th>Check Out</th>
                                                        <th>Working Hours</th>
                                                        <th>Sallery</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($attend as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $item->check_in }}</td>
                                                            <td>{{ $item->check_out }}</td>
                                                            <td>{{ $item->working_hours }}</td>
                                                            <td>{{ $item->earning_salary }}</td>
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







                                {{-- <form method="GET" action="{{ route('attendance.index') }}">
                    <label for="date">Filter by Date:</label>
                    <input type="date" name="date" value="{{ request('date') }}">
                    <button type="submit">Filter</button>
                </form> --}}

                                {{--                 
                $query = Attendance::query();

                if ($request->has('date') && $request->date) {
                $query->whereDate('date', $request->date);
                }

                $records = $query->with('employee')->get(); --}}





                            @endsection
