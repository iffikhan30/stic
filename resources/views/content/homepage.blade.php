@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Home Page')

@section('vendor-style')
<!-- Vendor -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages-auth.js')}}"></script>
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo1 demo1">@include('_partials.macros')</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Welcome to {{config('variables.templateName')}}! 👋</h4>
          @if (session('error'))
          <div class="alert alert-danger mb-1 rounded-0" role="alert">
            <div class="alert-body">
              {{ session('error') }}
            </div>
          </div>
          @endif
          @if (session('status'))
          <div class="alert alert-success mb-1 rounded-0" role="alert">
            <div class="alert-body">
              {{ session('status') }}
            </div>
          </div>
          @endif

          <form id="formAuthentication" class="mb-3" action="{{ route('admin.login') }}" method="POST">
            @csrf
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
              <div class="mb-3">
                <label class="form-label">Description</label>
                <div class="form-control p-0">
                  <div class="content border-0 pb-4" id="content">
                  </div>
                  <textarea name="content" class="hidden hide" style="display: none;"></textarea>
                </div>
              </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>
          {{-- <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{url('admin/register')}}">
              <span>Create an account</span>
            </a>
          </p>--}}

        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
@endsection
