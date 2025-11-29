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
  <script src="{{ asset('assets/js/admin/cms/edit.js') }}"></script>
  <script src="{{ asset('assets/js/admin/cms/delete.js') }}"></script>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin') || Auth::user()->can('edit-pages'))
      <form id="createCmsForm" action="{{ route('dashboard.cms.update', ['cm' => $cms->id]) }}" method="POST" enctype="multipart/form-data">
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
                  <input type="text" class="form-control" id="title" placeholder="title" value="{{$cms->title}}" name="title" aria-label="Title">
                </div>
                <div class="mb-3">
                  <label class="form-label" for="slug">Slug</label>

                    <input type="text" readonly class="form-control" id="slug" placeholder="slug" value="{{$cms->slug}}" name="slug" aria-label="Slug">
                </div>
                <div class="mb-3">
                  <label class="form-label" for="subtitle">Sub Title</label>
                  <input type="text" class="form-control" id="subtitle" placeholder="subtitle" value="{{$cms->subtitle}}" name="subtitle" aria-label="Sub Title">
                </div>
                <!-- Description -->
                <div>
                  <label class="form-label">Description <span class="text-muted">(Optional)</span></label>
                  <div class="form-control p-0">
                    <div class="content border-0 pb-4" id="content">
                      {!! $cms->content !!}
                    </div>
                    <textarea name="content" class="hidden hide" style="display: none;">{{$cms->content}}</textarea>
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
                  Published On <b>{{Helper::dateFormat($cms->created_at, $cms->country_id)}}</b> <br/>
                  {!! $cms->created_at != $cms->updated_at ? 'Modified On <b>'.Helper::dateFormat($cms->updated_at, $cms->country_id).'</b> <br/>' : '' !!}
                  Status {{$cms->status_id == '1'?'Active':'Deactive'}}
                </div>
                <!-- <div class="mb-3">
                  <label class="form-label" for="menu_order">Menu Order</label>
                  <input type="number" class="form-control" id="menu_order" name="menu_order" min="0" value="{{$cms->menu_order}}" aria-label="Menu Order">
                </div> -->
                <input type="hidden" value="page" name="type"/>
                <!-- <div class="mb-3">
                  <label class="form-label" for="type">CMS Type</label>
                  <select type="text" class="form-control" id="type" name="type" aria-label="CMS Type">
                    <option {{$cms->type == 'page' ? 'selected="selected"' : '' }} value="page">Page</option>
                    <option {{$cms->type == 'service' ? 'selected="selected"' : '' }} value="service">Service</option>
                  </select>
                </div> -->
                <div class="mb-3">
                  <label class="form-label" for="status_id">Status</label>
                  <select type="text" class="form-control" id="status_id" name="status_id" aria-label="status_id">
                    <option {{$cms->status_id == '1' ? 'selected="selected"' : '' }} value="1">Active</option>
                    <option {{$cms->status_id == '2' ? 'selected="selected"' : '' }} value="2">Not Active</option>
                  </select>
                </div>
                @if($cms->parent == '0')
                  @if($cms_languages->isNotEmpty())
                      @foreach($cms_languages as $cms_language)
                          <a class="btn btn-xs btn-secondary" id="langSelect"
                            href="{{ route('dashboard.cms.edit', ['cm' => $cms_language['id']]) }}" data-langid="{{ $cms_language['lang_id'] }}">
                             Converted - {{ $cms_language['lang_slug'] }}
                          </a>
                      @endforeach
                  @else
                    <button type="button" class="btn btn-xs btn-primary" id="langSelect"
                            data-id="{{ $cms->country_id }}"
                            data-bs-toggle="modal"
                            data-bs-target="#LanguageSelection">
                        Copy in Another Language
                    </button>
                  @endif
                @else
                <style>
                    .form-control{
                      direction: rtl;
                    }
                  </style>
                @endif
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
            <!-- SEO Card -->
            <div class="card mb-4">
              <div class="card-header">
                <h5 class="card-title mb-0">SEO</h5>
              </div>
              <div class="card-body">
                <!-- Title -->
                <div class="mb-3">
                  <label class="form-label" for="metatitle">Meta Title</label>
                  <input type="text" class="form-control" id="metatitle" name="metatitle" value="{{$cmsseo ? $cmsseo->title : ''}}" aria-label="Meta title">
                </div>

                <div class="mb-3">
                  <label class="form-label" for="metadescription">Meta Description</label>
                  <textarea class="form-control" id="metadescription" name="metadescription" aria-label="Meta Description">{{$cmsseo ? $cmsseo->description : ''}}</textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="metakeywords">Meta Keywords</label>
                  <textarea class="form-control" id="metakeywords" name="metakeywords" aria-label="Meta Keywords">{{$cmsseo ? $cmsseo->keywords : ''}}</textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="canonical_url">Canonical Url</label>
                  <textarea class="form-control" id="canonical_url" name="canonical_url" aria-label="Canonical Url">{{$cmsseo ? $cmsseo->canonical_url : ''}}</textarea>
                </div>
              </div>
            </div>
            <!-- /SEO Card -->
          </div>
          <!-- /Second column -->
        </div>
        <div class="row">
          <div class="col-lg-8">
            <!-- Variants -->
            <div class="card mb-4">
              <div class="card-header">
                <h5 class="card-title mb-0">SEO Meta</h5>
              </div>
              <div class="card-body">
                <div class="list-seo-repeater">
                  <div data-repeater-list="seo_meta">
                    @if(!empty($seometa))
                      @forelse($seometa as $meta)
                        <div data-repeater-item id="seo_meta_{{$meta->id}}" mid="{{$meta->id}}">
                          <div class="row">
                            <div class="mb-3 col-4">
                              <input type="hidden" value="{{$meta->id}}" name="seo_meta[id][]" />
                              <label class="form-label" for="seo-meta-1-1">Key</label>
                              <input type="text" id="seo-meta-1-1" class="form-control" value="{{$meta->key}}" name="seo_meta[key][]" placeholder="Enter Key" />
                            </div>
                            <div class="mb-3 col-8">
                              <label class="form-label" for="seo-meta-1-2">Value</label>
                              <textarea id="seo-meta-1-2" class="form-control" name="seo_meta[value][]">{{$meta->value}}</textarea>
                            </div>
                            <div class="mb-3 col-12 text-end">
                              <button type="button" class="btn btn-danger" data-repeater-delete>Remove</button>
                            </div>
                          </div>
                        </div>
                      @empty
                        <div data-repeater-item>
                          <div class="row">
                            <div class="mb-3 col-4">
                              <label class="form-label" for="seo-meta-1-1">Key</label>
                              <input type="text" id="seo-meta-1-1" class="form-control" name="seo_meta[key][]" placeholder="Enter Key" />
                            </div>
                            <div class="mb-3 col-8">
                              <label class="form-label" for="seo-meta-1-2">Value</label>
                              <textarea id="seo-meta-1-2" class="form-control" name="seo_meta[value][]"></textarea>
                            </div>
                            <div class="mb-3 col-12 text-end">
                              <button type="button" class="btn btn-danger" data-repeater-delete>Remove</button>
                            </div>
                          </div>
                        </div>
                      @endforelse
                    @else
                      <div data-repeater-item>
                        <div class="row">
                          <div class="mb-3 col-4">
                            <label class="form-label" for="seo-meta-1-1">Key</label>
                            <input type="text" id="seo-meta-1-1" class="form-control" name="seo_meta[key][]" placeholder="Enter Key" />
                          </div>
                          <div class="mb-3 col-8">
                            <label class="form-label" for="seo-meta-1-2">Value</label>
                            <textarea id="seo-meta-1-2" class="form-control" name="seo_meta[value][]"></textarea>
                          </div>
                          <div class="mb-3 col-12 text-end">
                            <button type="button" class="btn btn-danger" data-repeater-delete>Remove</button>
                          </div>
                        </div>
                      </div>
                    @endif
                  </div>
                  <div>
                    <button type="button" class="btn btn-primary" data-repeater-create>
                      Add another option
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Variants -->
          </div>
          <div class="col-lg-4">

          </div>
        </div>
      </form>
    </div>
    <div class="modal fade" id="LanguageSelection" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Language Selection</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="add-new-general pt-0"
            id="updateStatusGeneralForm"
            action="{{ route('dashboard.cms.copy') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col mb-3">
                  <input name="general_id" type="hidden" value="{{$cms->id}}" />
                  <label for="language" class="form-label">Language</label>
                  <select name="language" class="form-select" id="language"></select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Copy</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @else
    @include('access-denied')
    @endif
  </div>
@endsection
