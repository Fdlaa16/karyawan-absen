@extends('attendance::layouts.main')

@section('container')
<div class="container">   
    <div class="content mt-5">
        @if(session()->has('success'))
            <div class="d-flex alert text-white mt-3" style="background-color: #02c930;" role="alert">
                <strong>{{ session()->get('success') }}</strong>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        @endif
    
        @if(session()->has('gagal'))
            <div class="d-flex alert text-dark mt-3" style="background-color: #ffbb00;" role="alert">
                <strong>{{ session()->get('gagal') }}</strong>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        @endif
        
        <div class="d-flex">
            <div class="col-lg-5 card bg-white shadow rounded-3 p-4 border-0" style="display: flex; justify-content: center">

                <div class="wrapper">
                    <div class="scanner"></div>
                    <video id="preview"></video>
                </div>

                <form action="{{ route('attendance.store') }}" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="employee_id" id="employee_id">
                </form>
            </div>
            <div class="col-lg-7 mx-auto">
                <div class="card border shadow-xs mb-4 justify-content-center">

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                            @foreach ($absens as $absen)
                                <tr>
                                    <td>{{ $absen->code ?? '-' }}</td>
                                    <td>{{ $absen->employee->name ?? '-' }}</td>
                                    <td>{{ $absen->employee->employeeGroup->name ?? '-' }}</td>
                                    <td>{{ $absen->employee->status ?? '-' }}</td>
                                    <td>{{ $absen->date ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
