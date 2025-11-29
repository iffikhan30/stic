@extends('layouts/layoutMaster')

@section('title', 'CMS')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
@endsection
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/quill/katex.js')}}"></script>
<script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/admin/tickets/add.js') }}"></script>
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <form id="createTicketForm" action="{{ route('dashboard.tickets.store') }}" enctype="multipart/form-data" method="POST">
      @csrf
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
          <h4 class="mb-1 mt-3">Add a New Ticket</h4>
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          @if (session('status'))
          <div class="mb-1 text-success">
            {{ session('status') }}
          </div>
          @endif
        </div>
        <div class="d-flex align-content-center flex-wrap gap-2">
          <button type="submit" class="btn btn-primary" name="status_id" value="1">Publish</button>
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
                <label class="form-label">Name</label>
                <input name="name" class="form-control" value="{{ old('name') }}" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" value="{{ old('email') }}" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input name="phone" class="form-control" value="{{ old('phone') }}">
              </div>

              <div class="mb-3">
                <label class="form-label">Subject</label>
                <input name="subject" class="form-control" value="{{ old('subject') }}" required>
              </div>
              <!-- Description -->
              <div>
                <label class="form-label">Description</label>
                <div class="form-control p-0">
                  <div class="content border-0 pb-4" id="content">
                  </div>
                  <textarea name="content" class="hidden hide" style="display: none;"></textarea>
                </div>
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
                <label for="type" class="form-label">Ticket Type</label>
                <select class="form-control" id="type" name="type" required>
                  <option value="">Select Department</option>
                  @foreach ($departments as $dKey => $department)
                  <option value="{{ $dKey }}" {{ old('type') === $dKey ? 'selected' : '' }}>{{ $department }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="status_id" class="form-label">Status</label>
                <select class="form-control" id="status_id" name="status_id" required>
                  <option value="0">Progress</option>
                  <option value="1">Open</option>
                  <option value="2">Resolved</option>
                  <option value="3">Closed</option>
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