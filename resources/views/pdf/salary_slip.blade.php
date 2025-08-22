<!DOCTYPE html>
<html>

<head>
    <title>Salary Slip</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Salary Slip - {{ $month }}</h2>

    <p><strong>Employee Name:</strong> {{ $employee->name }}</p>
    <p><strong>Salary (Monthly):</strong> ₹{{ number_format($employee->sallery, 2) }}</p>
    <p><strong>Total Working Days:</strong> {{ $total_days }}</p>

    <table class="table">
        <tr>
            <th>Description</th>
            <th>Days/Amount</th>
        </tr>
        <tr>
            <td>Total Working Days</td>
            <td>{{ $workingDaysCount }} days</td>
        </tr>

        <tr>
            <td>Working Days Salary</td>
            <td>₹{{ number_format($total_earning_salary, 2) }}</td>
        </tr>
        <tr>
            <td>Working Days Salary</td>
            <td>₹{{ number_format($total_earning_salary, 2) }}</td>
        </tr>
        <tr>
            <td>Week Offs (Sun + Odd Sat)</td>
            <td>{{ $weekoff }} Days (₹{{ number_format($weekoffSalary, 2) }})</td>
        </tr>
        <tr>
            <td>Holidays (Paid)</td>
            <td>{{ $holidaysCount }} Days (₹{{ number_format($holidaysSalary, 2) }})</td>
        </tr>
        <tr>
            <td>Unpaid Leaves</td>
            <td>{{ $unpaidLeaves }} Days (₹{{ number_format($leaveDeduction, 2) }})</td>
        </tr>
        <tr>
            <td><strong>Total Earned Salary</strong></td>
            <td><strong>₹{{ number_format($finalSalary, 2) }}</strong></td>
        </tr>
    </table>

</body>

</html>
