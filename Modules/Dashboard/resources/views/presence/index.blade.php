@extends('dashboard::layouts.main')

@section('container')
    <div class="row">
      <div class="col-12">
        <div class="card border shadow-xs mb-4">
          <div class="container col-lg-4 py-5">
            <div class="card bg-white shadow rounded-3 p-3 border-0">
                <video id="preview"></video>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection