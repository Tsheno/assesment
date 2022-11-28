@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Edit User Details</h1>
        <hr>

        <form action="{{ route('update-user-details') }}" method="POST">
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
                        <?php #var_dump($user[0]['cid']);exit;?>
                    <input type="hidden" name="id"  value="{{$user[0]['id']}}">

                    <div class="mb-3">
                    <label for="first_name"> First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{$user[0]['first_name']}}">
                    @error('first_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name"  class="form-control" placeholder="Last Name" value="{{$user[0]['last_name']}}">
                    @error('last_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email"  class="form-control" placeholder="Email" value="{{$user[0]['email']}}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if(checkPermission(['superadmin']))
                    <div class="mb-3">
                        <label for="user">Assign User To Company</label>
                        <select name="user" class="form-control">
                            <option value="0">Deallocate</option>
                            @foreach($user['companies'] as $company)
                            <option <?php  if($user[0]['company_id'] == $company['id']) echo 'selected' ?>  value="{{$company['id']}}">{{$company['name']}}</option>
                            @endforeach
                        </select>
                        @error('user')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>

            <div class="card-footer">
                <button class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
@endsection


