@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>My Account</h1>
        <hr>
        <h3>Update Account Details</h3>

        <form action="{{ route('update-details') }}" method="POST">
            @csrf
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mb-3">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ $userDetails->first_name}}">
                    @error('first_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name"  class="form-control" placeholder="Last Name" value="{{ $userDetails->last_name}}">
                    @error('last_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ $userDetails->email}}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                           placeholder="Old Password">
                    @error('old_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                           placeholder="New Password">
                    @error('new_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cornfirm_password" class="form-label">Confirm New Password</label>
                    <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                           placeholder="Confirm New Password">
                </div>

            </div>
            <div class="card-footer">
                <button class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

@endsection


