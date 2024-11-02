@extends('layout.master-mini')

@section('content')
    <div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"
        style="background-image: url({{ url('assets/images/auth/register.jpg') }}); background-size: cover;">
        <div class="row w-100">
            <div class="mx-auto col-lg-4">
                <h2 class="mb-4 text-center">Register</h2>
                <div class="auto-form-wrapper">
                    <form action="{{ route('register#account') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="">
                                <input name="userName" type="text"
                                    class="p-4 rounded form-control @error('userName') is-invalid @enderror"
                                    placeholder="Username">
                                @error('userName')
                                    <div class="text-small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <input name="email" type="text"
                                    class="p-4 rounded form-control @error('email') is-invalid @enderror"
                                    placeholder="123@gmail.com">
                                @error('email')
                                    <div class="text-small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <input name="password" type="text"
                                    class="p-4 rounded form-control @error('password') is-invalid @enderror"
                                    placeholder="Password">
                                @error('password')
                                    <div class="text-small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary submit-btn btn-block">Register</button>
                        </div>
                        <div class="my-3 text-center text-block">
                            <span class="text-small font-weight-semibold">Already have and account ?</span>
                            <a href="{{ route('login#accountPage') }}" class="text-black text-small">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
