@extends('dashboard::layouts.main')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <label>Create Absen</label>
                </div>
                <div class="card-body">
                    <form action="{{ route('absen.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal Absen</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" required autofocus>
                            @error('date')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="shift" class="form-label">Shift</label>
                            <select name="shift" id="shift" class="form-control @error('shift') is-invalid @enderror" required>
                              <option value="" disabled selected>-- Pilih Tingkat Kelas --</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                            </select>
                            @error('shift')
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