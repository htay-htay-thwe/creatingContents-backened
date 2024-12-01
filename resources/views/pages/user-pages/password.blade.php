@extends('layout.master')

@push('plugin-styles')
    <!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
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
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('conFail'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('conFail') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h3 class="m-3 text-center"><span><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960"
                width="30px" fill="#5f6368">
                <path
                    d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480h80q0 66 25 124.5t68.5 102q43.5 43.5 102 69T480-159q134 0 227-93t93-227q0-134-93-227t-227-93q-89 0-161.5 43.5T204-640h116v80H80v-240h80v80q55-73 138-116.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-80-240q-17 0-28.5-11.5T360-360v-120q0-17 11.5-28.5T400-520v-40q0-33 23.5-56.5T480-640q33 0 56.5 23.5T560-560v40q17 0 28.5 11.5T600-480v120q0 17-11.5 28.5T560-320H400Zm40-200h80v-40q0-17-11.5-28.5T480-600q-17 0-28.5 11.5T440-560v40Z" />
            </svg></span>Change Password</h3>
    <div class="p-5 mx-auto shadow-sm row w-50 rounded-xl">
        <form method="POST" action="{{ route('change#passwordForm') }}">
            @csrf
            <input type='hidden' name="userId" value="{{ old('userId', Auth::id()) }}" />
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label" style="color:#00DC82">Old Password</label>
                <input placeholder="Enter Old Password" type="password" name="oldPassword"
                    class="form-control @error('oldPassword') is-invalid @enderror" id="exampleInputEmail1"
                    aria-describedby="emailHelp">
                @error('oldPassword')
                    <div class="text-small text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label" style="color:#00DC82">New Password</label>
                <input placeholder="Enter New Password" type="password" name="newPassword"
                    class="form-control @error('newPassword') is-invalid @enderror" id="exampleInputPassword1">
                @error('oldPassword')
                    <div class="text-small text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label" style="color:black">Comfirmed Password</label>
                <input placeholder="Enter Confirmed Password" type="password" name="confirmedPassword"
                    class="form-control @error('confirmedPassword') is-invalid @enderror" id="exampleInputPassword1">
                @error('confirmedPassword')
                    <div class="text-small text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="p-2 text-black btn btn-success font-weight-bold">Update</button>
        </form>
    </div>
@endsection
@push('plugin-scripts')
    {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
    {!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}
@endpush

@push('custom-scripts')
    {!! Html::script('/assets/js/dashboard.js') !!}
@endpush
