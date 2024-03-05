<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <style>
    body {
        font-size: 10px; /* Adjust the font size as needed */
        margin: 0;
        padding: 0;
    }

    .container-fluid {
        max-width: 100%;
        overflow-x: auto;
        margin: 0 auto; /* Add this line to center the container */
    }


    table {
        border-collapse: collapse;
        width: 100%;
        page-break-inside: avoid;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 6px; /* Adjust padding for better readability */
        text-align: center;
    }

    .custom-table-data {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 3%;
        margin-top: 5%;
        page-break-inside: avoid;
    }

    .custom-table-data th, .custom-table-data td {
        border: 1px solid black;
        padding: 6px; /* Adjust padding for better readability */
    }

    .month-header {
        font-size: 14px; /* Adjust font size for month header */
        font-weight: bold;
    }

    .employee-name {
        font-weight: bold;
    }

    @media print {
        body {
            width: 100%;
        }

        .custom-table-data,
        table {
            page-break-inside: auto;
        }
    }
</style>

</head>
<body class="g-sidenav-show bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center month-header">
                        ABSENSI KARYAWAN SHOPEE EXPRESS HUB CIKOKOL {{ $selectedYear }}
                    </div>
                    
                    @for ($month = $startMonth; $month <= $endMonth; $month++)
                        @php
                            $daysInMonth = \Carbon\Carbon::create($selectedYear, $month, 1)->daysInMonth;
                        @endphp
                
                        <table class="custom-table-data mb-3">
                            <colgroup>
                                <col style="width: auto;"> <!-- Kolom untuk Nama -->
                                <col style="width: auto;"> <!-- Kolom untuk Jabatan -->
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    <col style="width: 4%;"> <!-- Kolom untuk setiap hari -->
                                @endfor
                            </colgroup>
                            <thead class="border">
                                <div class="d-flex justify-content-center" style="font-size: 12px">
                                    {{ \Carbon\Carbon::create($selectedYear, $month, 1)->format('F') }}
                                </div>
                                <tr class="text-center">
                                    <th class="border">Nama</th>
                                    <th class="border">Jabatan</th>
                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                        <th class="border">{{ $day }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody class="border">
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td class="border employee-name">{{ $employee->name }}</td>
                                        <td class="border">{{ $employee->employeeGroup->name }}</td>
                                        @for ($day = 1; $day <= $daysInMonth; $day++)
                                            <td class="border w-2 text-center"
                                                @php
                                                    $absenOnDate = $employee->absens()->whereDate('date', \Carbon\Carbon::create($selectedYear, $month, $day)->toDateString())->first();
                                                    $cutiOnDate = $employee->cuti()
                                                            ->whereDate('start_at', '<=', \Carbon\Carbon::create($selectedYear, $month, $day)->toDateString())
                                                            ->whereDate('end_at', '>=', \Carbon\Carbon::create($selectedYear, $month, $day)->toDateString())
                                                            ->first();
                                                @endphp

                                                @if ($absenOnDate)
                                                    style="background-color: green"
                                                @elseif ($cutiOnDate)
                                                    style="background-color: red"
                                                @endif>

                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endfor
                </div>
            </div>
        </div>
    </main>
</body>
</html>
