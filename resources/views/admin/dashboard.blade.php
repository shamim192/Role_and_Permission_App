@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ auth()->user()->name }}!</h4>
                    <p>Your roles:
                        @foreach(auth()->user()->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </p>

                    <div class="mt-4">
                        <h5>Quick Links:</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @can('manage users')
                                <a href="{{ route('admin.users') }}" class="btn btn-primary">Manage Users</a>
                            @endcan

                            @can('manage roles')
                                <a href="{{ route('admin.roles') }}" class="btn btn-success">Manage Roles</a>
                            @endcan

                            @can('manage permissions')
                                <a href="{{ route('admin.permissions') }}" class="btn btn-info">Manage Permissions</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
