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
            <div class="d-sm-flex align-items-center">
              <form action="{{ route('employee.search') }}" method="GET">
                <input type="text" name="search" class="form-control mb-3" value="{{ request('search') }}">
              </form>
              <div class="ms-auto">
                <a href="{{ route('employee.create') }}" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                  <i class="fas fa-plus" style="margin-right: 8%"></i>
                  <span>Create</span>
                </a>
              </div>
            </div>
          </div>
          <div class="card-body px-0 py-0">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">ID</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">QR</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Code</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Name</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Group</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Shift</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Action</th>
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
                            <label class="text-dark">{!! $employeeQR[$employee->id] !!}</label>
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
                        <td class="align-middle text-center text-sm">
                            <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-warning text-dark py-2 px-3 mt-2">Edit</a>        
                            <form action="{{ route('employee.sendEmail', $employee->id) }}" method="post" class="btn btn-primary py-2 px-3 mt-2">
                                @csrf
                                @method('put')
                                <button type="submit" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda Akan mengirim QR Tersebut?')"><span data-feather="edit"></span>Kirim</button>
                            </form>
                            <form action="{{ route('employee.destroy', $employee->id) }}" method="post" class="btn btn-danger py-2 px-3 mt-2">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda Yakin?')"><span data-feather="x-circle"></span>Hapus</button>
                            </form>      
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
            <div class="border-top py-3 px-3 d-flex align-items-center">
              <p class="font-weight-semibold mb-0 text-dark text-sm">
                  Page {{ $employees->currentPage() }} of {{ $employees->lastPage() }} showing {{ $employees->total() }} records
              </p>
              <div class="ms-auto">
                  @if ($employees->previousPageUrl())
                      <a href="{{ $employees->previousPageUrl() }}" class="btn btn-sm btn-white mb-0">Previous</a>
                  @else
                      <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                  @endif
          
                  @if ($employees->nextPageUrl())
                      <a href="{{ $employees->nextPageUrl() }}" class="btn btn-sm btn-white mb-0">Next</a>
                  @else
                      <button class="btn btn-sm btn-white mb-0" disabled>Next</button>
                  @endif
              </div>
          </div>
          
          </div>
        </div>
      </div>
    </div>
    
@endsection