@extends('dashboard::layouts.main')

@section('container')
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0">
      <div class="card border shadow-xs mb-4">
        <div class="card-body text-start p-3 w-100">
          <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
            <i class="fas fa-user"></i>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="w-100">
                <p class="text-sm text-secondary mb-1"><a href="?employees" class="text-dark" style="text-decoration: none">Karyawan</a></p>
                <h4 class="mb-2 font-weight-bold">{{ $employees->count() }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0">
      <div class="card border shadow-xs mb-4">
        <div class="card-body text-start p-3 w-100">
          <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
           <i class="fas fa-check"></i>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="w-100">
                <p class="text-sm text-secondary mb-1"><a href="?absens" class="text-dark" style="text-decoration: none">Absensi</a></p>
                <h4 class="mb-2 font-weight-bold">{{ $absens->count() }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0">
      <div class="card border shadow-xs mb-4">
        <div class="card-body text-start p-3 w-100">
          <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
            <i class="fas fa-clock"></i>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="w-100">
                <p class="text-sm text-secondary mb-1"><a href="?cutis" class="text-dark" style="text-decoration: none">Cuti</a></p>
                <h4 class="mb-2 font-weight-bold">{{ $cutis->count() }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(isset($_GET["employees"]))
  <div class="card-body px-0 py-0">
    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">ID</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Code</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Name</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Group</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Shift</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
            </tr>
        </thead>
        @if($employees->count() > 0)
          <tbody>
              @foreach ($employees as $employee)
              <tr>                    
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $employee->id ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $employee->code ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $employee->name ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $employee->employeeGroup->name ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $employee->shift->name ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $employee->status ?? '-'}}</label>
                </td>
              </tr>
              @endforeach
          </tbody>
        @else
          <tbody>
              <tr>
                  <td colspan="8" class="text-center text-sm">
                      <label class="text-dark">
                          Tidak ada data
                      </label>
                  </td>
              </tr>
          </tbody>
        @endif
      </table>
    </div>
  </div>

  @elseif(isset($_GET["absens"]))
  <div class="card-body px-0 py-0">
    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">ID</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Code</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Name</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Date</th>
            </tr>
        </thead>
        @if($employees->count() > 0)
          <tbody>
              @foreach ($absens as $absen)
              <tr>                    
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $absen->id ?? '-'}}</label>
                </td>                   
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $absen->code ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $absen->employee->name ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $absen->date ?? '-'}}</label>
                </td>
              </tr>
              @endforeach
          </tbody>
        @else
          <tbody>
              <tr>
                  <td colspan="8" class="text-center text-sm">
                      <label class="text-dark">
                          Tidak ada data
                      </label>
                  </td>
              </tr>
          </tbody>
        @endif
      </table>
    </div>
  </div>

  @elseif(isset($_GET["cutis"]))
  <div class="card-body px-0 py-0">
    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">ID</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Name</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Tanggal Mulai</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Tanggal Berakhir</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Keterangan</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Kategori</th>
                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
            </tr>
        </thead>
        @if($cutis->count() > 0)
          <tbody>
              @foreach ($cutis as $cuti)
              <tr>                    
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $cuti->id ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $cuti->employee->name ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $cuti->start_at ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $cuti->end_at ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $cuti->information ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">{{ $cuti->category ?? '-'}}</label>
                </td>
                <td class="align-middle text-center text-sm">
                  <label class="text-dark">
                    @if($cuti->status == null)
                      <span class="border p-1 text-white rounded-lg" style="background-color: grey">Pending</span>
                    @elseif ($cuti->status == 1)
                      <span class="border p-1 bg-success text-white rounded-lg">Approve</span>
                    @elseif ($cuti->status == 2)
                      <span class="border p-1 bg-danger text-white rounded-lg">Reject</span>
                    @endif
                  </label>
                </td>
              </tr>
              @endforeach
          </tbody>
        @else
          <tbody>
              <tr>
                  <td colspan="8" class="text-center text-sm">
                      <label class="text-dark">
                          Tidak ada data
                      </label>
                  </td>
              </tr>
          </tbody>
        @endif
      </table>
    </div>
  </div>
@endisset
@endsection