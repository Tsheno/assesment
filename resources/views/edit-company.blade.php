@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Edit Company Details</h1>
        <hr>
        <form action="{{ route('update-company-details') }}" method="POST">
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
                    <label for="first_name">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $detail->name}}">
                    @error('first_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" name="id" value="{{ $detail->id}}">
                <div class="mb-3">
                    <label for="email">Last Name</label>
                    <input type="email" name="email"  class="form-control" placeholder="Email" value="{{ $detail->email}}">
                    @error('last_name')
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

