@extends('layout.master-mini')

@section('content')
    <div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"
        style="background-image: url({{ url('assets/images/auth/register.jpg') }}); background-size: cover;">
        <div class="row w-100">
            <div class="mx-auto col-lg-4">
                <h2 class="mb-4 text-center">Register</h2>
                <div class="auto-form-wrapper">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
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

                    <div class="mb-2 d-flex justify-content-center align-items-center" >
                        <div class="justify-content-between d-flex" style="width: 180px; align-items: center;">
                            <a href="{{ url('/auth/github/redirect') }}" class="p-2 border text-decoration-none" style="border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background-color: #0C83E2; color: white;">
                              <i class="fa-brands fa-github" style="font-size: 20px;"></i>
                            </a>
                            <a href="{{ url('/auth/{provider}/redirect') }}" class="p-2 border text-decoration-none" style="border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background-color: #0C83E2; color: white;">
                                <i class="fa-brands fa-facebook" style="font-size: 20px;"></i>
                            </a>
                            <a href="{{ url('/auth/google/redirect') }}" class="p-2 border text-decoration-none" style="border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background-color: #0C83E2; color: white;">
                                <i class="fa-brands fa-google" style="font-size: 20px;"></i>
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
