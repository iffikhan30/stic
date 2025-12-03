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
    <form class="dt_adv_search general-filter-form" id="dt_adv_search">

      {{-- department --}}
      <select class="form-control form-select-sm" id="sType" name="sType">
        <option value="">Select Department</option>
        @foreach ($departments as $dKey => $department)
        <option value="{{ $dKey }}" {{ old('sType') === $dKey ? 'selected' : '' }}>{{ $department }}</option>
        @endforeach
      </select>

      {{-- title --}}
      <input type="text" name="sEmail" id="sEmail" class="form-control form-control-sm search-key"
        placeholder="Search by Email" value="{{ old('sEmail', request('sEmail')) }}">

      {{-- ticket no. --}}
      <input type="text" name="sTicketno" id="sTicketno" class="form-control form-control-sm search-key"
        placeholder="Search by BT-0000000"
        value="{{ old('sTicketno', request('sTicketno')) }}">

      {{-- status --}}
      <select name="sStatus" id="sStatus" class="form-select form-select-sm">
        <option value="">Select Status</option>
        <option value="1" {{ old('sStatus', request('sStatus')) == '1' ? 'Selected' : '' }}>Progress</option>
        <option value="2" {{ old('sStatus', request('sStatus')) == '2' ? 'Selected' : '' }}>Open</option>
        <option value="3" {{ old('sStatus', request('sStatus')) == '3' ? 'Selected' : '' }}>Resolved</option>
        <option value="4" {{ old('sStatus', request('sStatus')) == '4' ? 'Selected' : '' }}>Closed</option>
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
            <th>@lang('Sr.')</th>
            <th>@lang('Database')</th>
            <th>@lang('Ticket No.')</th>
            <th>@lang('Contact')</th>
            <th>@lang('Status')</th>
            <th>@lang('Created Date')</th>
            <th>@lang('Action')</th>
          </tr>
        </thead>
        <tbody>
          @php
          $i=0;
          @endphp
          @foreach ($data as $general)
          @php
          $i++;
          @endphp
          <tr>
            <td data-id="{{ $general->id }}">{{$i}}</td>
            <td>
              <spna class="badge bg-success">{{$general->db}}</spna>
            </td>
            <td>
              <spna class="badge bg-info">{{$general->ticket_no}}</spna>
            </td>
            <td>
              <i class="fa fa-user"></i> : {{ $general->name }}<br>
              <a href="mailto:{{ $general->email }}" class="mb-1"><i class="fa fa-envelope"></i> {{ $general->email }}</a><br>
              <a href="tel:{{ $general->phone }}"><span class="badge bg-dark"><i class="fa fa-phone"></i> {{ $general->phone }}</span></a>
            </td>
            <td>
              @php $st = Helper::getStatusById($general->status_id); @endphp
              <span class="badge d-block me-1" style="background-color: {{ $st->color }} !important;">
                {{ $st->title }}
              </span>
            </td>
            <td>
              {{ Helper::dateFormat($general->created_at) }}
            </td>
            <td>
              <div class="d-flex justify-content-center">
                <!-- <a href="{{ route('dashboard.tickets.edit', ['ticket' => $general->id]) }}"
                class="cursor-pointer text-primary bx bx-edit">
                </a>
                <a href="javascript:;" class="cursor-pointer text-danger bx bx-trash-alt"
                  onclick="deleteTicket(`{{$general->db}}`,`{{$general->id}}`)">
                </a>-->
                <a href="{{ route('dashboard.tickets.show', ['ticket' => $general->id.'-'.$general->db]) }}"
                  class="cursor-pointer text-primary"><i class="fa fa-eye"></i>
                </a>
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