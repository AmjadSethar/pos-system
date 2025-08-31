@extends('layouts.app')
@section('title', 'Customer History')

@section('css')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
@endsection
		@section('content')
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
					<x-breadcrumb :langArray="[
                                            'Customer ',
                                            'Customer History',
                                        ]"/>

                    <div class="card">

					<div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
					    <!-- Other content on the left side -->
					    <div>
					    	<h5 class="mb-0 text-uppercase">Customer History</h5>
					    </div>
					   
					</div>
					<div class="card-body">
						<div class="row">
                       <div class="col-md-12">
							<x-label for="party_id" name="{{ __('customer.customer') }}" />
							<a tabindex="0" class="text-primary" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Search by name, mobile, phone, whatsApp, email"><i class="fadeIn animated bx bx-info-circle"></i></a>
							<div class="input-group">
								
								<select class="form-select single-select-clear-field" id="party_id" name="party_id" data-placeholder="Choose Customer">
									<option></option>
									@foreach ($customers as $customer)
										<option value="{{ $customer->id }}">{{ $customer->first_name }} {{$customer->last_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
					</div>
				</div>
				<!--end row-->
			</div>


		@endsection
@section('js')
<script src="{{ asset('custom/js/common/common.js') }}"></script>
<script src="{{ asset('custom/js/party/party-history.js') }}"></script>
@endsection
