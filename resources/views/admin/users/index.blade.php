@extends('layouts.master')

@section('section-title')
ITerview
@endsection

@section('content')

@include('admin.helpers.modal')

<div class="card">
  <!-- Card header -->
  <div class="card-header border-0">
    <h3 class="mb-0">List of users</h3>
  </div>
  <!-- Light table -->
  <div class="table-responsive">
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col" class="sort" data-sort="name">ID</th>
          <th scope="col" class="sort" data-sort="budget">Full Name</th>
          <th scope="col" class="sort" data-sort="status">Email</th>
          <th scope="col">Role</th>
          <th scope="col" class="sort" data-sort="completion">Actions</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($users as $user)
        <tr>
          <th scope="row">
            {{ $user->id }}
          </th>
          <td>
            {{ $user->name }}
          </td>
          <td>
            {{ $user->email }}
          </td>
          <td>
            {{ $user->role }}
          </td>
          <td>
            <a href="{{ route('users.edit', ['id' => $user->id])}}" class="btn btn-success btn-sm">Edit</a>
            <a
              data-id="{{ $user->id }}"
              {{-- onclick="event.preventDefault(); document.getElementById('delete-form').submit();" --}}
              {{-- href="{{ route('users.delete', ['id' => $user->id]) }}"  --}}
              href="#"
              class="btn btn-danger btn-sm delete">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- Pagination -->
  <div class="card-footer py-4">
    <nav aria-label="...">
      {{$users->onEachSide(1)->links()}}
    </nav>
  </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
  $('.delete').on('click', function() {
    // get user id
    const userId = $(this).data('id');

    // set action
    $('#delete-form').attr('action', '/users/delete/' + userId)

    // show the modal
    $('#deleteModal').modal('show');
  })
});
</script>
@endsection