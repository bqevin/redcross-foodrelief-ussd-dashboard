@extends('sbadmin.layouts.app')
<!-- Custom styles for this page -->
<link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@section('sbadmin.content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Old Town Services Request</h1>
        <p class="mb-4"> Old Town residents service requests in response to the lockdown </p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Service Requests</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>TrackingID</th>
                            <th>Details</th>
                            <th>Contact Info</th>
                            <th>Village Elder</th>
                            <th>Type</th>
                            <th>Reported</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>TrackingID</th>
                            <th>Details</th>
                            <th>Contact Info</th>
                            <th>Village Elder</th>
                            <th>Type</th>
                            <th>Reported</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($serviceRequests as $serviceRequest)
                            <tr>
                                <td>{{$serviceRequest->id}}</td>
                                <td>{{$serviceRequest->details}}</td>
                                <td>{{$serviceRequest->contact_info}}</td>
                                <td>{{$serviceRequest->official}}</td>
                                <td>{{$serviceRequest->getServiceName($serviceRequest->type)}}</td>
                                <td>{{$serviceRequest->created_at->toDayDateTimeString()}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- Page level plugins -->
    <script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('sbadmin/js/demo/datatables-demo.js') }}"></script>
@endsection
