@extends('layouts.app')
@section('content')
        <div class="container">
            <h1>List Of Companies</h1>
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
            &nbsp;<a class="btn btn-info mb-2" href="/createCompany/" role="button">Create New Company</a>
           @if(count($compDetails) > 0)
               @foreach($compDetails as $compDetail)
                   <?php #var_dump($compDetail); ?>
                <ul class="list-group list-group-light">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold"><span class="font-weight-bolder">Name: </span>{{$compDetail->name}}</div>
                            <div class="text-muted mb-3"><span class="font-weight-bolder">Email: </span>{{$compDetail->name}}</div>
                             <a class="btn btn-primary" href="/editCompany/{{$compDetail->id}}" role="button">Edit</a>
                            &nbsp;<a class="btn btn-danger" href="/deleteCompany/{{$compDetail->id}}" role="button">Delete</a>
                        </div>
                    </li>
                </ul>
                @endforeach
            @else
                <h3>No results found</h3>
           @endif
        </div>
@endsection
