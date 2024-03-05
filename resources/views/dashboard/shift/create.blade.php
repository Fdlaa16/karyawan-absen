@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              @if(session()->has('errors'))
                  <div class="alert col-lg-8 text-white mt-3" style="background-color: #dc3545; margin-left: 15px;" role="alert">
                      <ul>
                          @foreach (session('errors') as $error)
                              <li>{{ $error[0] }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
                <div class="card-header">
                  <label>{{ isset($shift) ? 'Edit Shift' : 'Create Shift' }}</label>
                </div>
                <div class="card-body">
                    <form action="{{ isset($shift) ? route('shift.update', ['shift' => $shift->id]) : route('shift.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @if(isset($shift))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ isset($shift) ? old('name', $shift->name) : '' }}" autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="py-2">
                            <div class="text-end">
                              <button class="btn btn-primary profile-button text-white" type="submit">Buat</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection