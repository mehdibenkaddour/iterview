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
    @slot('submitId')
    deleteBtn
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
        <input type="text" name="name" value="" class="form-control" id="name">
        <span class="text-danger">
                                <strong id="name-error"></strong>
                            </span>
      </div>
      
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="" class="form-control" id="email">
        <span class="text-danger">
                                <strong id="email-error"></strong>
                            </span>
        
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

    @slot('submitId')
      editBtn
    @endslot

@endcomponent


<div class="card">
  <!-- Card header -->
  <div class="card-header border-0">
    <h3 class="mb-0">List of users</h3>
  </div>
  <!-- Light table -->
  <div class="table-responsive">
    <table class="table align-items-center table-flush" id="myTable">
      <thead class="thead-light">
        <tr>
          <th scope="col" class="sort" >ID</th>
          <th scope="col" class="sort">Full Name</th>
          <th scope="col" class="sort">Email</th>
          <th scope="col">Role</th>
          <th scope="col" class="sort">Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        {{-- @foreach ($users as $user)
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
        @endforeach --}}
      </tbody>
    </table>
  </div>
  <!-- Pagination -->
  {{-- <div class="card-footer py-4">
    <nav aria-label="...">
      {{$users->onEachSide(1)->links()}}
    </nav>
  </div> --}}
</div>

@endsection

@section('scripts')
<script>
/* Show the modal */
$(document).ready(function() {

  // Datatables config
  const table = $('#myTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('ajax.users') !!}',
      columns: [
          { data: 'id', name: 'id' },
          { data: 'name', name: 'name' },
          { data: 'email', name: 'email' },
          { data: 'role', name: 'role' },
          { data: 'actions', name: 'actions' }
      ]
  });

  handleUserDelete();
  handleUserEdit();

  function handleUserDelete() {
    // DELETE A USER
    $('#myTable tbody').on('click', 'button.delete', function() {
      // get user id
      const userId = $(this).data('id');

      // set action
      $('#delete-form').attr('action', '/users/' + userId)

      // show the modal
      $('#delete-modal').modal('show');
    });
  }

  function handleUserEdit() {
    // EDIT A USER
    $('#myTable tbody').on('click', 'button.edit', function() {
        // get user id
        const userId = $(this).data('id');

        // set action
        $('#edit-form').attr('action', '{{url("/users")}}'+ "/" + userId);

        // fill inputs with data
        const name = $(this).parent().siblings('td')[1].innerText;
        const email = $(this).parent().siblings('td')[2].innerText;
        const role = $(this).parent().siblings('td')[3].innerText;

        $('#name').val(name);
        $('#email').val(email);
        $( '#name-error' ).html( "" );
        $( '#email-error' ).html( "" );

        $('#role').get(0).selectedIndex = (role === 'admin' ? 1 : 0)

        // show the modal
        $('#edit-modal').modal('show');

        $('#edit-form').submit(function(e) {
          // turn button into loading state
          $('#editBtn').prop('disabled', true);
          $('#editBtn').html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
          );
          
          const urlForm= $(this).attr('action');
          e.preventDefault();
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: urlForm,
            method: 'POST',
            data: {
                name: jQuery('#name').val(),
                email: jQuery('#email').val(),
                usertype: jQuery('#role').val(),
                _method:'PUT',
            },
            success: function(result){
              if(result.errors)
              {
                if(result.errors.name && result.errors.email){
                    $('#edit-form').find('#name-error').html(result.errors.name[0]);
                  }else if(result.errors.email){
                    $('#edit-form').find('#email-error').html(result.errors.email[0]);
                  }else{
                    $('#edit-form').find('#name-error').html(result.errors.name[0]);
                  }
              }
              else
              {
                // hide the modal
                $('#edit-modal').modal('hide');
        
                // turn button into default state
                $('#editBtn').prop('disabled', false);
                $('#editBtn').html(
                  `Update`
                );

                // show success message
                $('.alert-text').html(result.alert)
                $('#alert-message').fadeIn();

                // refresh the table
                table.ajax.reload();

                // hide success message after 4 seconds
                setTimeout(function() {
                  $('#alert-message').fadeOut();
                  $('.alert-text').html('');
                }, 4000);
              }
            }});
        })

      });
  }

});

</script>

@endsection