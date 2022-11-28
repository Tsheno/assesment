@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Create User</h1>
        <hr>

        <form action="{{ route('create-user') }}" method="POST">
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
                    <label for="first_name"> First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="First Name">
                    @error('first_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name"  class="form-control" placeholder="Last Name">
                    @error('last_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email"  class="form-control" placeholder="Email">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if(checkPermission(['superadmin']))
                <div class="mb-3">
                    <label for="user">Assign User To Company</label>
                    <select name="user" class="form-control">
                        @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                    </select>
                    @error('user')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @endif
                <div class="mb-3">
                    <label for="email">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
@endsection

