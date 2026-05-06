@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header text-center bg-dark text-white">
                    <h4>Login Admin</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Username Admin</label>
                            <input type="text" name="adm_username" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="adm_password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">Login Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection