@extends('layouts.master')

@section('section-title')
ITerview
@endsection

@section('content')

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete alert</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="delete-form" action="" method="POST">
          @method('DELETE')
          @csrf
      
        <div class="modal-body">
        Are you sure you wan't to delete this user
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

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
  <!-- Card footer -->
  <div class="card-footer py-4">
    <nav aria-label="...">
      <ul class="pagination justify-content-end mb-0">
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">
            <i class="fas fa-angle-left"></i>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item active">
          <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">
            <i class="fas fa-angle-right"></i>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
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