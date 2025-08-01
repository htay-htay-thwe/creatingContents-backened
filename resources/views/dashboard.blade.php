@extends('layout.master')

@push('plugin-styles')
    <!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div
                        class="flex-wrap d-flex flex-md-column flex-xl-row justify-content-between align-items-md-center justify-content-xl-between">
                        <div class="float-left">
                            <i class="mdi mdi-cube text-danger icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total Posts</p>
                            <div class="fluid-container">
                                <h3 class="mb-0 text-right font-weight-medium">{{ $posts }}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-left text-muted text-md-center text-xl-left">
                        <i class="mr-1 mdi mdi-alert-octagon" aria-hidden="true"></i> 65% lower growth
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div
                        class="flex-wrap d-flex flex-md-column flex-xl-row justify-content-between align-items-md-center justify-content-xl-between">
                        <div class="float-left">
                            <i class="mdi mdi-receipt text-warning icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Popular Posts</p>
                            <div class="fluid-container">
                                <h3 class="mb-0 text-right font-weight-medium">{{ $popular }}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-left text-muted text-md-center text-xl-left">
                        <i class="mr-1 mdi mdi-bookmark-outline" aria-hidden="true"></i> The most viewer's posts
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div
                        class="flex-wrap d-flex flex-md-column flex-xl-row justify-content-between align-items-md-center justify-content-xl-between">
                        <div class="float-left">
                            <i class="mdi mdi-account-box-multiple text-info icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Users</p>
                            <div class="fluid-container">
                                <h3 class="mb-0 text-right font-weight-medium">{{ $users }}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-left text-muted text-md-center text-xl-left">
                        <i class="mr-1 mdi mdi-reload" aria-hidden="true"></i> Product-wise sales
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="mb-0 card-title">Line Chart</h4>
            </div>
            <div class="card-body">
                <div class="pb-4 d-sm-flex justify-content-between align-items-center">
                    <h4 class="mb-0 card-title">Users</h4>
                    <div id="line-traffic-legend"></div>
                </div>
                <canvas id="lineChart" style="height:150px"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Posts table</h4>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> writerName </th>
                                <th> Genre </th>
                                <th> Title </th>
                                <th> Email </th>
                                <th> PostId </th>
                                <th> Views </th>
                                <th> Like </th>
                                <th> * </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paginator as $index => $postData)
                                <tr>
                                    <td> {{ $index + 1 }} </td>
                                    <td> {{ $postData['userName'] }} </td>
                                    <td>
                                        {{ $postData['genre'] }}
                                    </td>
                                    <td> {{ $postData['title'] }} </td>
                                    <td> {{ $postData['email'] }} </td>
                                    <td> {{ $postData['id'] }} </td>
                                    <td> {{ $postData['views'] }} </td>
                                    <td> {{ $postData['likeCount'] }} </td>

                                    <td><a class="text-danger" href="{{ route('delete#post', $postData['id']) }}"><svg
                                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                                width="24px" fill="#FC0000">
                                                <path
                                                    d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                            </svg></a> </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 d-flex justify-content-end pagination-container">
                    {{ $paginator->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
@endpush

@push('custom-scripts')
    {!! Html::script('/assets/js/chart.js') !!}
@endpush
