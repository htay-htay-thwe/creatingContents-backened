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
    <form method="POST" enctype="multipart/form-data" action="{{ route('update#adminInfo') }}" class="p-5 mx-auto shadow-sm row w-50">
        @csrf
        <input type="hidden" name="userId" value="{{ old('userId', $user->id) }}"/>
        <div class="mt-3 mb-5 text-center font-weight-bold">
            <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></span>
            Update Information of Admin</div>
        <div class="mb-3">
            <label for="image" class="form-label font-weight-bold">Upload Image</label>
            <input type="file" class="form-control  @error('image') is-invalid @enderror" id="image" name="image"
                onchange="previewImage(event)">
            @error('image')
                <div class="text-small text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <img id="imagePreview" style="max-width: 200px; display: none;" alt="Image Preview" />
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">UserName</label>
            <input value="{{ old('userName', $user->name) }}" placeholder="Enter userName" type="text" name="userName"
                class="form-control @error('userName') is-invalid @enderror" id="exampleInputEmail1"
                aria-describedby="emailHelp">
            @error('userName')
                <div class="text-small text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="p-2 mt-3 btn btn-danger font-weight-bold">Update</button>
    </form>
@endsection

@push('plugin-scripts')
    {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
    {!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}
@endpush

@push('custom-scripts')
    {!! Html::script('/assets/js/dashboard.js') !!}
@endpush

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('imagePreview');
            preview.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
