@extends('layouts.master');

@section('title')
Admin-Panel
@stop

@section('content')

<div class="container">
 <div class="row">
   <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h3>Edit user information</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('users.update', ['id' => $user->id])}}" method="POST">
          {{csrf_field()}}
          {{method_field('PUT')}}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>Name</label>
                <input type="text" name="username" value="{{$user->name}}" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{$user->email}}" class="form-control">
                <div class="col-md-6">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                </div>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="usertype" class="form-control">
                @if($user->role=="admin")
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                @else
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                @endif
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/users" class="btn btn-danger">Cancel</a>
          </form>
        </div>
      </div>
   </div>
 </div>

</div>

@stop

@section('scripts')
@stop