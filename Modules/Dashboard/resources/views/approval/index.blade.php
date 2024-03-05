@extends('dashboard::layouts.main')

@section('breadcrumb', 'Approval Cuti')

@section('page_title', 'Approval Cuti')

@section('container')
    <div class="row">
      <div class="col-12">
        <div class="card border shadow-xs mb-4">

          @if(session()->has('success'))
            <div class="alert col-lg-8 text-white mt-3" style="background-color: #28a745; margin-left: 15px;" role="alert">
                {{ session('success') }} 
            </div>        
          @endif

          @if(session()->has('error'))
            <div class="alert col-lg-8 text-white mt-3" style="background-color: #ff1717; margin-left: 15px;" role="alert">
                {{ session('error') }} 
            </div>        
          @endif
          
          <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
              <form action="{{ route('cuti.search') }}" method="GET">
                <input type="text" name="search" class="form-control mb-3" value="{{ request('search') }}">
              </form>
              <div class="ms-auto">
                <a href="{{ route('cuti.create') }}" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
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
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Code</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Nama</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Tanggal Mulai</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Tanggal Berakhir</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Action</th>
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
                          <label class="text-dark">{{ $cuti->code ?? '-'}}</label>
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
                        <td class="align-middle text-center text-sm">
                            {{-- <a href="{{ route('cuti.edit', $cuti->id) }}" class="btn btn-warning text-dark py-2 px-3 mt-2">Edit</a>         --}}
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $cuti->id }}">
                              <i class="fas fa-eye"></i>
                            </button>
                            <form action="{{ route('approval-cuti.approve', $cuti->id) }}" method="post" class="d-inline" >
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-warning border-0 mt-2" onclick="return confirm('Apakah Anda Akan Terima Cuti Tersebut?')"><span data-feather="edit"></span><i class="fas fa-check"></i></button>
                            </form>
                            <form action="{{ route('approval-cuti.reject', $cuti->id) }}" method="post" class="d-inline">
                                @method('put')
                                @csrf
                                <button type="submit" class="btn btn-danger border-0 mt-2" onclick="return confirm('Apakah Anda Akan Tolak Cuti Tersebut?')"><span data-feather="x-circle"></span><i class="fas fa-times"></i></button>
                            </form>   
  
                            <div class="modal fade" id="exampleModal{{ $cuti->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content p-3">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="siswaModalLabel">Cuti Karyawan</h5>
                                  </div>
                                  <div>
                                      <div class="d-flex justify-content-start p-2 border-bottom">
                                        <div class="col-lg-3 d-flex justify-content-start">
                                          Nama 
                                        </div>
                                        <div class="col-lg-1">
                                          :
                                        </div>
                                        <div class="col-lg-8">
                                          {{ $cuti->employee->name ?? '-'}}
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-start p-2 border-bottom">
                                        <div class="col-lg-3 d-flex justify-content-start">
                                          Tanggal Mulai 
                                        </div>
                                        <div class="col-lg-1">
                                          :
                                        </div>
                                        <div class="col-lg-8">
                                          {{ $cuti->start_at ?? '-'}}
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-start p-2 border-bottom">
                                        <div class="col-lg-3 d-flex justify-content-start">
                                          Tanggal Berakhir 
                                        </div>
                                        <div class="col-lg-1">
                                          :
                                        </div>
                                        <div class="col-lg-8">
                                          {{ $cuti->end_at ?? '-'}}
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-start p-2 border-bottom">
                                        <div class="col-lg-3 d-flex justify-content-start">
                                          Kategori 
                                        </div>
                                        <div class="col-lg-1">
                                          :
                                        </div>
                                        <div class="col-lg-8">
                                          {{ $cuti->category ?? '-'}}
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-start p-2 border-bottom">
                                        <div class="col-lg-3 d-flex justify-content-start">
                                          Keterangan 
                                        </div>
                                        <div class="col-lg-1">
                                          :
                                        </div>
                                        <div class="col-lg-8">
                                          {{ $cuti->information ?? '-'}}
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-start p-2 border-bottom">
                                        <div class="col-lg-3 d-flex justify-content-start">
                                          Status 
                                        </div>
                                        <div class="col-lg-1">
                                          :
                                        </div>
                                        <div class="col-lg-8">
                                          @if($cuti->status == null)
                                            <span class="border p-1 text-white rounded-lg" style="background-color: grey">Pending</span>
                                          @elseif ($cuti->status == 1)
                                            <span class="border p-1 bg-success text-white rounded-lg">Approve</span>
                                          @elseif ($cuti->status == 2)
                                            <span class="border p-1 bg-danger text-white rounded-lg">Reject</span>
                                          @endif
                                        </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
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
                  Page {{ $cutis->currentPage() }} of {{ $cutis->lastPage() }} showing {{ $cutis->total() }} records
              </p>
              <div class="ms-auto">
                  @if ($cutis->previousPageUrl())
                      <a href="{{ $cutis->previousPageUrl() }}" class="btn btn-sm btn-white mb-0">Previous</a>
                  @else
                      <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                  @endif
          
                  @if ($cutis->nextPageUrl())
                      <a href="{{ $cutis->nextPageUrl() }}" class="btn btn-sm btn-white mb-0">Next</a>
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