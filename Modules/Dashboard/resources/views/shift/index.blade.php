@extends('dashboard::layouts.main')

@section('breadcrumb', 'Shift')

@section('page_title', 'Shift')

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
              <form action="{{ route('shift.search') }}" method="GET">
                <input type="text" name="search" class="form-control mb-3" value="{{ request('search') }}">
              </form>
              <div class="ms-auto">
                <a href="{{ route('shift.create') }}" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
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
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Name</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Action</th>
                    </tr>
                </thead>
                @if($shifts->count() > 0)
                  <tbody>
                      @foreach ($shifts as $shift)
                      <tr>                    
                        <td class="align-middle text-center text-sm">
                          <label class="text-dark">{{ $shift->id ?? '-'}}</label>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <label class="text-dark">{{ $shift->name ?? '-'}}</label>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <a href="{{ route('shift.edit', $shift->id) }}" class="btn btn-warning text-dark py-2 px-3 mt-2">Edit</a>        
                            <form action="{{ route('shift.destroy', $shift->id) }}" method="post" class="btn btn-danger py-2 px-3 mt-2">
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
                          <td colspan="7" class="text-center text-sm">
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
                  Page {{ $shifts->currentPage() }} of {{ $shifts->lastPage() }} showing {{ $shifts->total() }} records
              </p>
              <div class="ms-auto">
                  @if ($shifts->previousPageUrl())
                      <a href="{{ $shifts->previousPageUrl() }}" class="btn btn-sm btn-white mb-0">Previous</a>
                  @else
                      <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                  @endif
          
                  @if ($shifts->nextPageUrl())
                      <a href="{{ $shifts->nextPageUrl() }}" class="btn btn-sm btn-white mb-0">Next</a>
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