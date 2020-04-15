@extends('layouts.master')

@section('section-title')
ITerview
@endsection

@section('content')
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
    Are you sure you wan't to delete this topic
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
    Edit topic
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
        <label>Label</label>
        <input type="text" name="label" value="" class="form-control" id="edit-label">
        <span class="text-danger">
            <strong id="edit-label-error"></strong>
        </span>
      </div>
      <div class="form-group">
       <label>Image</label>
        <div class="custom-file">
            <input type="file" name="image" class="custom-file-input" id="edit-image">
            <label class="custom-file-label" for="image">Choose Image</label>
        </div>
        <span class="text-danger">
              <strong id="edit-image-error"></strong>
        </span>
      </div>
    @endslot

    @slot('cancel')
        Cancel
    @endslot

    @slot('confirm')
        Update
    @endslot

@endcomponent

<!-- ADD Modal Component -->

@component('admin.helpers.modal')
    @slot('title')
    Add topic
    @endslot

    @slot('modalId')
    add-modal
    @endslot

    @slot('formId')
    add-form
    @endslot

    @slot('method')
    POST
    @endslot

    @slot('content')
      <div class="form-group">
        <label>Label</label>
        <input type="text" name="label" value="" class="form-control" id="add-label">
        <span class="text-danger">
            <strong id="add-label-error"></strong>
        </span>
      </div>
      <div class="form-group">
       <label>Image</label>
        <div class="custom-file">
            <input type="file" name="image" class="custom-file-input" id="add-image">
            <label class="custom-file-label" for="image">Choose Image</label>
        </div>
        <span class="text-danger">
              <strong id="add-image-error"></strong>
        </span>
      </div>
    @endslot

    @slot('cancel')
        Cancel
    @endslot

    @slot('confirm')
        Add
    @endslot

@endcomponent

<div class="card">
  <!-- Card header -->
  <div class="card-header border-0">
    <h3 class="mb-0">List of Topics</h3>
    <button class="btn btn-primary btn-sm float-right add">ADD</button>
  </div>
  <!-- Light table -->
  <div class="table-responsive">
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col" class="sort" data-sort="name">ID</th>
          <th scope="col" class="sort" data-sort="budget">TOPIC</th>
          <th scope="col" class="sort" data-sort="completion">Actions</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($topics as $topic)
        <tr>
          <th scope="row">
            {{ $topic->id }}
          </th>
          <td>
            <div class="media align-items-center">
                <a href="#" class="avatar rounded-circle mr-3">
                    <img alt="Image placeholder" src="/uploads/topics/{{$topic->image}}">
                </a>
                <div class="media-body">
                  <span class="name mb-0 text-sm" id="TopicLabel">{{$topic->label}}</span>
                </div>
            </div>
          </td>
          <td>
            <button
              data-id="{{ $topic->id }}"
              class="btn btn-success btn-sm edit">Edit</button>
            <button
              data-id="{{ $topic->id }}"
              class="btn btn-danger btn-sm delete">Delete</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- Pagination -->
  <div class="card-footer py-4">
    <nav aria-label="...">
      {{$topics->onEachSide(1)->links()}}
    </nav>
  </div>
</div>

@endsection

@section('scripts')
<script>
/* Show the modal */
$(document).ready(function() {
  // DELETE A Topic
  $('.delete').on('click', function() {
    // get topic id
    const topicId = $(this).data('id');

    // set action
    $('#delete-form').attr('action', '/topics/' + topicId)

    // show the modal
    $('#delete-modal').modal('show');
  });

  // EDIT A topic
  $('.edit').on('click', function() {
    // get topic id
    const topicId = $(this).data('id');

    // set action
    $('#edit-form').attr('action', '{{ url("/topics/update") }}' + "/" + topicId);

    // fill inputs with data
    const label = $(this).parent().siblings('td').first().find('span')[0].innerHTML;

    $('#edit-label').val(label);
    $( '#edit-label-error' ).html( "" );
    $( '#edit-image-error' ).html( "" );

    // show the modal
    $('#edit-modal').modal('show');

    $('#edit-form').submit(function(e){
      const urlForm= $(this).attr('action');
      e.preventDefault();
      $( '#edit-label-error' ).html( "" );
      $( '#edit-image-error' ).html( "" );
      var label = $('#edit-label').val();
      var image = $('#edit-image')[0].files[0];
      var form = new FormData();
      form.append('label', label);
      form.append('image', image);
      form.append('_method','PUT');
      $.ajax({
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url: urlForm,
                  method: 'POST',
                  data: form,
                  contentType: false,
                  processData: false,
                  success: function(result){
                  	if(result.errors)
                  	{
                      if(result.errors.label && result.errors.image){
                          $('#edit-form').find('#edit-label-error').html(result.errors.label[0]);
                        }else if(result.errors.image){
                          $('#edit-form').find('#edit-image-error').html(result.errors.image[0]);
                        }else{
                          $('#edit-form').find('#edit-label-error').html(result.errors.label[0]);
                        }
                  	}
                  	else
                  	{
                  		$('#edit-modal').modal('hide');
                      $('#alert-message').removeClass('d-none').html(result.alert);
                      setTimeout(location.reload.bind(location), 500);
                  	}
                  }});

    });

  });
  // ADD TOPIC
    $('.add').on('click', function() {
    // set action
    $('#add-form').attr('action', '{{ route("topics.store") }}');

    $( '#add-label-error' ).html( "" );
    $( '#add-image-error' ).html( "" );

    // show the modal
    $('#add-modal').modal('show');

    $('#add-form').submit(function(e){
      const urlForm= $(this).attr('action');
      e.preventDefault();
      $( '#add-label-error' ).html( "" );
      $( '#add-image-error' ).html( "" );
      var label = $('#add-label').val();
      var image = $('#add-image')[0].files[0];
      var form = new FormData();
      form.append('label', label);
      form.append('image', image);
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: urlForm,
        method: 'POST',
        data: form,
        contentType: false,
        processData: false,
        success: function(result){
          if(result.errors)
          {
            if(result.errors.label && result.errors.image){
                $('#add-form').find('#add-label-error').html(result.errors.label[0]);
              }else if(result.errors.image){
                $('#add-form').find('#add-image-error').html(result.errors.image[0]);
              }else{
                $('#add-form').find('#add-label-error').html(result.errors.label[0]);
              }
          }
          else
          {
            $('#add-modal').modal('hide');
            $('#alert-message').removeClass('d-none').html(result.alert);
            setTimeout(location.reload.bind(location), 500);
          }
        }});

    });

  });
});

</script>

@endsection