@php($noSidebar = true)
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    @if($errors->any())
    <div class="alert alert-danger">
         {{ $errors->first() }}
    </div>
    @endif
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-blue-dark login-form py-3 px-5">
            <div class="align-items-center text-center">
                <img src="{{asset('image/icon/Logo2.png')}}" alt="Logo Dimas Diajeng" class="navbar-logo">
                <h4 class="fw-bold text-warning">ADMIN PANEL</h4>
            </div>
            <div class="mx-5">
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="text-white mb-1">Email</label><br>
                        <input type="email"
                        class="form-control"
                        name="email"
                        required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="text-white mb-1">Password</label><br>
                        <input type="password"
                        class="form-control"
                        name="password"
                        required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-submit" aria-label="Login">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
