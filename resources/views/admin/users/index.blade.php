@extends('layouts.master')

@section('section-title')
ITerview
@endsection

@section('content')

<!-- Delete Modal Component -->

@component('admin.helpers.modal')
    @slot('title')
        Delete alert
    @endslot
    
    @slot('modalId')
        delete-modal
    @endslot

    @slot('formId')
        delete-form
    @endslot

    @slot('method')
        DELETE
    @endslot

    @slot('content')
    Are you sure you wan't to delete this user
    @endslot

    @slot('cancel')
        Cancel
    @endslot

    @slot('confirm')
        Yes, delete
    @endslot
@endcomponent


<!-- Edit Modal Component -->

@component('admin.helpers.modal')
    @slot('title')
    Edit user
    @endslot

    @slot('modalId')
    edit-modal
    @endslot

    @slot('formId')
        edit-form
    @endslot

    @slot('method')
        PUT
    @endslot

    @slot('content')
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="username" value="" class="form-control" id="name">
      </div>
      
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="" class="form-control" id="email">
        <div class="col-md-6">
        </div>
      </div>
      
      <div class="form-group">
        <label>Role</label>
        <select name="usertype" class="form-control" id="role">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
    @endslot

    @slot('cancel')
        Cancel
    @endslot

    @slot('confirm')
        Update
    @endslot

@endcomponent
{{-- @section('modal-form-title', 'Edit user')

@section('modal-form-id', 'edit-form')

@section('modal-form-method', 'PUT')

@section('modal-form-content')

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
  <label>Name</label>
  <input type="text" name="username" value="" class="form-control">
</div>

<div class="form-group">
  <label>Email</label>
  <input type="email" name="email" value="" class="form-control">
  <div class="col-md-6">
  </div>
</div>

<div class="form-group">
  <label>Role</label>
  <select name="usertype" class="form-control">
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select>
</div>
@endsection

@section('modal-form-cancel', 'Cancel')

@section('modal-form-confirm', 'Update') --}}
<!-- End Edit User Modal -->


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
            <button
              data-id="{{ $user->id }}"
              class="btn btn-success btn-sm edit">Edit</button>
            <button
              data-id="{{ $user->id }}"
              class="btn btn-danger btn-sm delete">Delete</button>
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
  // DELETE A USER
  $('.delete').on('click', function() {
    // get user id
    const userId = $(this).data('id');

    // set action
    $('#delete-form').attr('action', '/users/delete/' + userId)

    // show the modal
    $('#delete-modal').modal('show');
  });

  // EDIT A USER
  $('.edit').on('click', function() {
    // get user id
    const userId = $(this).data('id');

    // set action
    $('#edit-form').attr('action', '/users/edit/' + userId);

    // fill inputs with data
    const name = $(this).parent().siblings('td')[0].innerText;
    const email = $(this).parent().siblings('td')[1].innerText;
    const role = $(this).parent().siblings('td')[2].innerText;

    $('#name').val(name);
    $('#email').val(email);

    $('#role').get(0).selectedIndex = (role === 'admin' ? 1 : 0)

    // show the modal
    $('#edit-modal').modal('show');

  });
});
</script>
@endsection