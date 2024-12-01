@extends('layout.master-mini')
@push('plugin-styles')
    <!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush
@section('content')
    <div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"
        style="background-image: url({{ url('assets/images/auth/login_1.jpg') }}); background-size: cover;">
        <div class="row w-100">
            <div class="mx-auto col-lg-4">
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <div class="auto-form-wrapper">
                    <form action="{{ route('login#account') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="label">Email</label>
                            <div class="">
                                <input type="text" name="email"
                                    class="form-control p-4 rounded @error('email') is-invalid @enderror" placeholder="Email">
                                @error('email')
                                    <div class="text-small text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label">Password</label>
                            <div class="">
                                <input type="password" name="password"
                                    class="form-control p-4 rounded @error('password') is-invalid @enderror" placeholder="*********">
                                @error('password')
                                    <div class="text-small text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary submit-btn btn-block">Login</button>
                        </div>
                        <div class="my-3 text-center text-block">
                            <span class="text-small font-weight-semibold">Not a member ?</span>
                            <a href="{{ route('register#accountPage') }}" class="text-black text-small">Create new
                                account /</a>
                            <a href="{{ route('register#accountPage') }}" class="text-black text-small " style="text-decoration: underline;">Login with Google</a>
                        </div>
                    </form>
                </div>
                <ul class="auth-footer">
                    <li>
                        <a href="#">Conditions</a>
                    </li>
                    <li>
                        <a href="#">Help</a>
                    </li>
                    <li>
                        <a href="#">Terms</a>
                    </li>
                </ul>
                <p class="text-center footer-text">copyright © 2018 Bootstrapdash. All rights reserved.</p>
            </div>
        </div>
    </div>
@endsection
@push('plugin-scripts')
    {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
    {!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}
@endpush

@push('custom-scripts')
    {!! Html::script('/assets/js/dashboard.js') !!}
@endpush
