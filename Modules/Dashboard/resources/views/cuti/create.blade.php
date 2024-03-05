@extends('dashboard::layouts.main')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <label>{{ isset($cuti) ? 'Edit cuti' : 'Create cuti' }}</label>
                </div>
                @if($errors->any())
                    <div class="alert col-lg-8 text-white mt-3" style="background-color: red; margin-left: 15px;" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <div class="card-body">
                  <form action="{{ isset($cuti) ? route('cuti.update', ['cuti' => $cuti->id]) : route('cuti.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @if(isset($cuti))
                        @method('PUT')
                    @endif
                        <div class="form-group">
                            <label for="employee">Karyawan</label>
                            <select name="employee_id" id="employee_id" class="form-control">
                                <option value="" {{ !isset($cuti) ? 'selected' : '' }} disabled>-- Pilih Karyawan --</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ (isset($cuti) && $cuti->employee->id == $employee->id) ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>                      
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select name="category" id="category" class="form-control">
                                <option value="" {{ !isset($cuti) ? 'selected' : '' }} disabled>-- Pilih Kategori --</option>
                                <option value="sakit" {{ (isset($cuti) && $cuti->category == 'kontrak') ? 'selected' : '' }}>Kontrak</option>
                                <option value="hamil" {{ (isset($cuti) && $cuti->category == 'hamil') ? 'selected' : '' }}>hamil</option>
                                <option value="liburan" {{ (isset($cuti) && $cuti->category == 'liburan') ? 'selected' : '' }}>liburan</option>
                                <option value="kompensasi" {{ (isset($cuti) && $cuti->category == 'kompensasi') ? 'selected' : '' }}>kompensasi</option>
                                <option value="tahunan" {{ (isset($cuti) && $cuti->category == 'tahunan') ? 'selected' : '' }}>tahunan</option>
                            </select>
                        </div>           
                        <div class="mb-3">
                            <label for="start_at" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('name') is-invalid @enderror" id="start_at" name="start_at" required value="{{ isset($cuti) ? old('start_at', $cuti->start_at) : '' }}" placeholder="dd/mm/yy" autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="end_at" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control @error('name') is-invalid @enderror" id="end_at" name="end_at" required value="{{ isset($cuti) ? old('end_at', $cuti->end_at) : '' }}" placeholder="dd/mm/yy" autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                        </div>                       
                        <div class="mb-3">
                            <label for="information" class="form-label">Keterangan</label>
                            <div>
                                <textarea name="information" id="information" cols="30" rows="10"></textarea>
                            </div>
                            @error('information')
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