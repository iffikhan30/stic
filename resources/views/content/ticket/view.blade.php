@extends('layouts/layoutMaster')

@section('title', 'Edit Ticket')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/quill/katex.js')}}"></script>
<script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/admin/tickets/edit.js') }}"></script>
<script src="{{ asset('assets/js/admin/tickets/delete.js') }}"></script>
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <form id="createCmsForm" action="{{ route('dashboard.tickets.update', ['ticket' => $data->id.'-'.$db]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
          @if (session('status'))
          <div class="mb-1 text-success">
            {{ session('status') }}
          </div>
          @endif
        </div>
        <div class="d-flex align-content-center flex-wrap gap-2">
          <button type="submit" class="btn btn-primary" name="status_id" value="1">Update</button>
        </div>
      </div>
      <div class="row">
        <!-- First column-->
        <div class="col-12 col-lg-8">
          <!-- Information -->
          <div class="card mb-4">
            <div class="card-header">
              <h5 class="card-tile mb-0">General information</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <p>{{$data->name}}</p>
              </div>

              <div class="mb-3">
                <p>{{$data->email}}</p>
              </div>

              <div class="mb-3">
                <p>{{$data->phone}}</p>
              </div>

              <div class="mb-3">
                <p>{{$data->name}}</p>
              </div>
              <!-- Description -->
              <div class="mb-3">
                <div>{{$data->message}}</div>
              </div>
            </div>
          </div>
          <!-- /Information -->

        </div>
        <!-- /Second column -->
        <!-- Second column -->
        <div class="col-12 col-lg-4">
          <!-- Media -->
          <div class="card mb-4">
            <div class="card-header">
              <h5 class="card-title mb-0">Capabilities</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label for="status_id" class="form-label">Status</label>
                <select class="form-control" id="status_id" name="status_id" required>
                  <option value="1">Progress</option>
                  <option value="2">Open</option>
                  <option value="3">Resolved</option>
                  <option value="4">Closed</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection