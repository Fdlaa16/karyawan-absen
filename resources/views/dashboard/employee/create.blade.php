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
                  <label>{{ isset($employee) ? 'Edit Employee' : 'Create Employee' }}</label>
                </div>
                <div class="card-body">
                  <form action="{{ isset($employee) ? route('employee.update', ['employee' => $employee->id]) : route('employee.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @if(isset($employee))
                        @method('PUT')
                    @endif

                        @if(isset($employee) )
                            <div class="visible-print text-center">
                                <div class="col-md-4 mb-3">
                                    {{ $employeeQr }}
                                </div>
                            </div>
                        @endif


                        @if(!isset($employee))
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                                @error('email')
                                <div class="invalid-feedback">
                                {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">
                                {{ $message }}
                                </div>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ isset($employee) ? old('name', $employee->name) : '' }}" autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" required value="{{ isset($employee) ? old('date_of_birth', $employee->date_of_birth) : '' }}">
                            @error('date_of_birth')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" required value="{{ isset($employee) ? old('place_of_birth', $employee->place_of_birth) : '' }}">
                            @error('place_of_birth')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" required value="{{ isset($employee) ? old('address', $employee->address) : '' }}">
                            @error('address')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="shift">Shift</label>
                            <select name="shift" id="shift" class="form-control">
                                <option value="" {{ !isset($employee) ? 'selected' : '' }} disabled>-- Pilih Shift --</option>
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}" {{ (isset($employee) && $employee->shift->id == $shift->id) ? 'selected' : '' }}>
                                        {{ $shift->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>                      
                        <div class="form-group">
                            <label for="employeeGroup">Group</label>
                            <select name="employeeGroup" id="employeeGroup" class="form-control">
                                <option value="" {{ !isset($employee) ? 'selected' : '' }} disabled>-- Pilih Group --</option>
                                @foreach ($employeeGroups as $employeeGroup)
                                    <option value="{{ $employeeGroup->id }}" {{ (isset($employee) && $employee->employeeGroup->id == $employeeGroup->id) ? 'selected' : '' }}>
                                        {{ $employeeGroup->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>           
                        <div class="form-group">
                            <label for="status">Group</label>
                            <select name="status" id="status" class="form-control">
                                <option value="" {{ !isset($employee) ? 'selected' : '' }} disabled>-- Pilih Group --</option>
                                <option value="magang" {{ (isset($employee) && $employee->status == 'magang') ? 'selected' : '' }}>Magang</option>
                                <option value="kontrak" {{ (isset($employee) && $employee->status == 'kontrak') ? 'selected' : '' }}>Kontrak</option>
                                <option value="tetap" {{ (isset($employee) && $employee->status == 'tetap') ? 'selected' : '' }}>Tetap</option>
                            </select>
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