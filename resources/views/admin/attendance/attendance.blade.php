@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')

    <link rel="stylesheet" href="{{ url('/') }}/public/admin/css/style.css">

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
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">
            <div id="include_all_data_wrapper">
                <div id="table_data_page">


                    <div id="data_container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="text-dark m-0">Attendance List</h3>

                        </div>
                        <br>
                        <br>
                        <section class="section dashboard">
                            <div class="">
                                <div id="data_container">
                                    <div class="row g-3">

                                        <form method="GET" action="{{ route('admin.attendance') }}">
                                            <div class="mb-3">
                                                <select class="form-select" name="employee_id" style="min-width: 200px;">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($employes as $items)
                                                        <option value="{{ $items->id }}"
                                                            {{ request('employee_id') == $items->id ? 'selected' : '' }}>
                                                            {{ $items->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
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


                                    </form>
                                    <br>
                                    <br>
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
                            @include('tostar_msg.tostar');

                        @endsection
