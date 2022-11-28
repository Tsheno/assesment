@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Create Company</h1>
        <hr>

        <form action="{{ route('create-company') }}" method="POST">
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
                    <label for="first_name">Company Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Company Name">
                    @error('name')
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

                <div class="mb-3">
                    <label for="email">Assign Admin To Company</label>
                    <select name="admin" class="form-control">
                        @foreach($admins as $admin)
                            <option value="{{$admin->id}}">{{$admin->first_name}}</option>
                        @endforeach
                    </select>
                    @error('admin')
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

