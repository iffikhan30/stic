@extends('layouts/layoutMaster')

@section('title', 'Tickets')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/admin/general/index.css') }}">
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/admin/tickets/table.js') }}"></script>
<script src="{{ asset('assets/js/admin/tickets/delete.js') }}"></script>
<script src="{{ asset('assets/js/admin/tickets/view.js') }}"></script>
@endsection

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center pb-1">
    <h5 class="">@lang('TICKETS')</h5>
    <a href="{{ route('dashboard.tickets.create') }}" class="btn btn-sm btn-primary"><i
        class="bx bx-plus me-0 me-sm-2"></i>@lang('Add Ticket')</a>
  </div>
  <div class="card-body pb-0">
    <form class="dt_adv_search rentalcar-filter-form" id="dt_adv_search">

      {{-- title --}}
      <input type="text" name="sTitle" id="sTitle" class="form-control form-control-sm search-key"
        placeholder="Search by Title" value="{{ old('sTitle', request('sTitle')) }}">

      {{-- id --}}
      <input type="number" name="sId" id="sId" class="form-control form-control-sm search-key"
        placeholder="Search by Id"
        value="{{ old('sId', request('sId')) }}">

      {{-- status --}}
      <select name="sStatus" id="sStatus" class="form-select form-select-sm">
        <option value="">Select Status</option>
        <option value="1" {{ old('sStatus', request('sStatus')) == '1' ? 'Selected' : '' }}>Active</option>
        <option value="2" {{ old('sStatus', request('sStatus')) == '2' ? 'Selected' : '' }}>Deactive</option>
        </option>
      </select>

      {{-- buttons --}}
      <div class="button-container">
        <button class="btn btn-sm btn-success">@lang('Search')</button>
        <a href="{{ route('dashboard.tickets.index') }}" class="btn btn-xs btn-primary">
          <i class="bx bx-recycle"></i></a>
      </div>
    </form>
  </div>

  <div class="card-body">
    <div class="card-datatable text-nowrap">
      <table id="ticketTable" class="table table-bordered custom-table-style">
        <thead>
          <tr>
            <th>@lang('Title')</th>
            <th>@lang('Slug')</th>
            <th>@lang('Status')</th>
            <th>@lang('Created Date')</th>
            <th>@lang('Action')</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $general)
          <tr>
            <td data-id="{{ $general->id }}">
              <spna class="badge bg-info">{{$general->lang_slug}}</spna>
              {{ $general->title }}
            </td>
            <td>{{ $general->slug }}</td>
            <td>
              <span class="badge d-block me-1" style="background-color: {!! Helper::getStatusById($general->status_id)->color !!} !important;">
                {{ Helper::getStatusById($general->status_id)->title }}
              </span>
            </td>
            <td>{{ Helper::dateFormat($general->created_at) }}</td>
            <td>
              <div class="d-flex justify-content-center">
                @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin') || Auth::user()->can('edit-pages'))
                <a href="{{ route('dashboard.tickets.edit', ['ticket' => $general->id]) }}"
                  class="cursor-pointer text-primary bx bx-edit editOperatingCountry">
                </a>
                @endif
                <!-- <a href="javascript:;" class="cursor-pointer text-primary fa-regular fa-eye"
                      onclick="viewTickets(`{{$general->id}}`)">
                    </a> -->
                @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin') || Auth::user()->can('delete-pages'))
                <a href="javascript:;" class="cursor-pointer text-danger bx bx-trash-alt"
                  onclick="deleteTicket(`{{$general->id}}`)">
                </a>
                @endif
              </div>
            </td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection