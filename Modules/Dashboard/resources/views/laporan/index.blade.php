@extends('dashboard::layouts.main')

@section('breadcrumb', 'Employee')

@section('page_title', 'Employee')

@section('container')
    <div class="row">
      <div class="col-12">
        <div class="card border shadow-xs mb-4">

          @if(session()->has('success'))
            <div class="alert col-lg-8 text-white mt-3" style="background-color: #28a745; margin-left: 15px;" role="alert">
                {{ session('success') }} 
            </div>        
          @endif
          
        <div class="card-header border-bottom pb-0">
            <form action="{{ route('laporan.search') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-3">
                        <div class="mb-2">
                            <label for="perihal" class="form-label">Tahun</label>
                            <select name="year" id="year" class="form-control">
                                @for ($i = date("Y"); $i >= 1900; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('perihal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-2">
                            <label for="perihal" class="form-label">Bulan Awal</label>
                            <select name="startMonth" id="startMonth" class="form-control" >
                                <option value="" disabled>-- Pilih Bulan Awal --</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            @error('perihal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <span class="col-1 d-flex align-items-center justify-content-center">-</span>
                    <div class="col-3">
                        <div class="mb-2">
                            <label for="perihal" class="form-label">Bulan Akhir</label>
                            <select name="endMonth" id="endMonth" class="form-control">
                                <option value="" disabled>-- Pilih Bulan Akhir --</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            @error('perihal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div> 
                    <div class="col-2">
                        <div class="mt-1">
                            <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-search"></i> Cari</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        @if (isset($employees))
            <div class="card-body px-0 py-0">
                <div class="table-responsive p-3">
                    <form action="{{ route('laporan.download') }}" method="POST">
                        @csrf
                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                        <input type="hidden" name="startMonth" value="{{ $startMonth }}">
                        <input type="hidden" name="endMonth" value="{{ $endMonth }}">
                        <button class="btn btn-warning" style="margin-left: 2%" type="submit"><i class="fas fa-download" style="margin-right: 3px"></i>Download</button>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                ABSENSI KARYAWAN SHOPEE EXPRESS HUB CIKOKOL {{ $selectedYear }}
                            </div>

                            @for ($month = $startMonth; $month <= $endMonth; $month++)
                                @php
                                    $daysInMonth = \Carbon\Carbon::create($selectedYear, $month, 1)->daysInMonth;
                                @endphp

                                <table class="custom-table-data mb-3">
                                    <thead class="border">
                                        <div class="d-flex justify-content-center border">
                                            {{ \Carbon\Carbon::create($selectedYear, $month, 1)->format('F') }}
                                        </div>
                                        <tr class="text-center">
                                            <th class="border">Nama</th>
                                            <th class="border">Jabatan</th>
                                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                                <th class="border" style="width: calc(100% / {{ $daysInMonth }});">{{ $day }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody class="border">
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td class="border">{{ $employee->name }}</td>
                                                <td class="border">{{ $employee->employeeGroup->name }}</td>
                                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                                    <td class="border w-2 text-center
                                                        @php
                                                            $absenOnDate = $employee->absens()->whereDate('date', \Carbon\Carbon::create($selectedYear, $month, $day)->toDateString())->first();
                                                            $cutiOnDate = $employee->cuti()
                                                                            ->whereDate('start_at', '<=', \Carbon\Carbon::create($selectedYear, $month, $day)->toDateString())
                                                                            ->whereDate('end_at', '>=', \Carbon\Carbon::create($selectedYear, $month, $day)->toDateString())
                                                                            ->where('status', 1)
                                                                            ->first();
                                                        @endphp

                                                        @if ($absenOnDate)
                                                        bg-success
                                                        @elseif ($cutiOnDate)
                                                        bg-danger
                                                        @endif
                                                        ">
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endfor
                        </div>
                    </form>
                </div>
            </div>
        @endif
        </div>
      </div>
    </div>
    
@endsection

