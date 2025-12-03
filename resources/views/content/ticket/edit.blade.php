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
    <form id="createCmsForm" action="{{ route('dashboard.tickets.update', ['ticket' => $data->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
          <h4 class="mb-1 mt-3">Edit Page</h4>
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
          @endif
          @if (session('status'))
          <div class="mb-1 text-success">
            {{ session('status') }}
          </div>
          @endif
        </div>
        <div class="d-flex align-content-center flex-wrap gap-2">
          <button type="submit" class="btn btn-primary">Update</button>
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
                <label class="form-label" for="title">Title</label>
                <input type="text" class="form-control" id="title" placeholder="title" value="{{$data->title}}" name="title" aria-label="Title">
              </div>
              <div class="mb-3">
                <label class="form-label" for="slug">Slug</label>

                <input type="text" readonly class="form-control" id="slug" placeholder="slug" value="{{$data->slug}}" name="slug" aria-label="Slug">
              </div>
              <div class="mb-3">
                <label class="form-label" for="subtitle">Sub Title</label>
                <input type="text" class="form-control" id="subtitle" placeholder="subtitle" value="{{$data->subtitle}}" name="subtitle" aria-label="Sub Title">
              </div>
              <!-- Description -->
              <div>
                <label class="form-label">Description <span class="text-muted">(Optional)</span></label>
                <div class="form-control p-0">
                  <div class="content border-0 pb-4" id="content">
                    {!! $data->content !!}
                  </div>
                  <textarea name="content" class="hidden hide" style="display: none;">{{$data->content}}</textarea>
                </div>
              </div>
            </div>
          </div>
          <!-- /Information -->
        </div>
        <!-- /Second column -->
        <!-- Second column -->
        <div class="col-12 col-lg-4">
          <!-- CAPABILITIES Card -->
          <div class="card mb-4">
            <div class="card-header">
              <h5 class="card-title mb-0">Capabilities</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                Published On <b>{{Helper::dateFormat($data->created_at, $data->country_id)}}</b> <br />
                {!! $data->created_at != $data->updated_at ? 'Modified On <b>'.Helper::dateFormat($data->updated_at, $data->country_id).'</b> <br />' : '' !!}
                Status {{$data->status_id == '1'?'Active':'Deactive'}}
              </div>
              <div class="mb-3">
                <label class="form-label" for="status_id">Status</label>
                <select type="text" class="form-control" id="status_id" name="status_id" aria-label="status_id">
                  <option {{$data->status_id == '1' ? 'selected="selected"' : '' }} value="1">Active</option>
                  <option {{$data->status_id == '2' ? 'selected="selected"' : '' }} value="2">Not Active</option>
                </select>
              </div>
            </div>
          </div>
          <!-- /CAPABILITIES Card -->
          <!-- Media -->
          <div class="card mb-4">
            <div class="card-header">
              <h5 class="card-title mb-0">Image Section</h5>
            </div>
            <div class="card-body">
              @if(!empty($media))
              @foreach($media as $medi)
              @if($medi->featured==='N')
              <figure class="position-relative custom-option" id="media_id_{{ $medi->id }}">
                <img src="{{ Storage::url("{$medi->path}") }}" alt="{{ $medi->title }}" width="100%" />
              </figure>
              @endif
              @endforeach
              @endif
              <div class="mb-3">
                <label for="banner_image" class="form-label">Banner Image</label>
                <input class="form-control" type="file" name="banner_image" id="banner_image">
              </div>
              @if(!empty($media))
              @foreach($media as $medi)
              @if($medi->featured==='Y')
              <figure class="position-relative custom-option" id="media_id_{{ $medi->id }}">
                <img src="{{ Storage::url("{$medi->path}") }}" alt="{{ $medi->title }}" width="100%" />
              </figure>
              @endif
              @endforeach
              @endif
              <div class="mb-3">
                <label for="featured_image" class="form-label">Featured Image</label>
                <input class="form-control" type="file" name="featured_image" id="featured_image">
              </div>
            </div>
          </div>
          <!-- /Media -->

        </div>
        <!-- /Second column -->
      </div>
    </form>
  </div>
</div>
@endsection