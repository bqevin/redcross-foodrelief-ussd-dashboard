@extends('sbadmin.layouts.app')
<!-- Custom styles for this page -->
<link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@section('sbadmin.content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Relief Food Distribution - Feedback</h1>
        <p class="mb-4"> Mombasa residents feedback/complains or suggestions in relation to the ongoing relief food
            distribution process</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Feedback
                    on {{\Carbon\Carbon::today()->isoFormat('MMM, Do YYYY')}}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>TrackingID</th>
                            <th>Feedback</th>
                            <th>Location</th>
                            <th>Village Elder</th>
                            <th>Occurrence</th>
                            <th>Reported</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($feedback as $feed)
                            <tr>
                                <td>{{$feed->id}}</td>
                                <td>{{$feed->description}}</td>
                                <td>{{$feed->geoLocation ? $feed->geoLocation->location_description : 'N/A'}}</td>
                                <td>{{$feed->official}}</td>
                                <td>{{$feed->occurrence_date}}</td>
                                <td>{{$feed->created_at->toDayDateTimeString()}}</td>
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
