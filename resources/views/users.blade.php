@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Users</h1>
        <hr>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        &nbsp;<a class="btn btn-info mb-2" href="/createUser/" role="button">Create New User</a>
        <section style="background-color: #eee;">
            <div class="container py-5">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                                <li class="breadcrumb-item"><a href="/users">Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                @if(count($users) > 0)
                <div class="row">
                    @foreach($users as $user)
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                     class="rounded-circle img-fluid" style="width: 150px;">
                                <h5 class="my-3">{{$user['first_name']}} {{$user['last_name']}}</h5>
                                <p class="text-muted mb-4">{{$user['email']}} </p>
                                <div class="d-flex justify-content-center mb-2">
                                    <a href="/editUser/{{$user['id']}}"  class="btn btn-primary">Edit</a>
                                    <a href="/deleteUser/{{$user['id']}}" class="btn btn-outline-primary ms-1">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <h3>No results found</h3>
                @endif
            </div>
        </section>
    </div>
@endsection
