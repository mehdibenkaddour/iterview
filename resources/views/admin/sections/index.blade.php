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
    Edit Section
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
        <label>Topic</label>
        <select class="browser-default custom-select" name="edit-topic" id="edit-topic">
        @foreach($topics as $topic )
        <option value="{{$topic->id}}">{{$topic->label}}</option>
        @endforeach
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

<!-- ADD Modal Component -->

@component('admin.helpers.modal')
    @slot('title')
    Add Section
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
        <input type="text" name="add-label" value="" class="form-control" id="add-label">
        <span class="text-danger">
            <strong id="add-label-error"></strong>
        </span>
      </div>
      <div class="form-group">
       <label>Topic</label>
       <select class="browser-default custom-select" name="add-topic" id="add-topic">
        <option selected disabled>Select Topic</option>
        @foreach($topics as $topic )
        <option value="{{$topic->id}}">{{$topic->label}}</option>
        @endforeach
      </select>
      <span class="text-danger">
            <strong id="add-topic-error"></strong>
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
    <h3 class="mb-0">List of Sections</h3>
    <button class="btn btn-primary btn-sm float-right add">ADD</button>
  </div>
  <!-- Light table -->
  <div class="table-responsive">
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col" class="sort" data-sort="name">ID</th>
          <th scope="col" class="sort" data-sort="budget">Section</th>
          <th scope="col" class="sort" data-sort="budget">Topic</th>
          <th scope="col" class="sort" data-sort="completion">Actions</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($sections as $section)
        <tr>
          <th scope="row">
            {{ $section->id }}
          </th>
          <td>
            {{$section->label}}
          </td>
          <td>
            {{$section->topic->label}}
          </td>
          <td>
            <button
              data-id="{{ $section->id }}"
              class="btn btn-success btn-sm edit">Edit</button>
            <button
              data-id="{{ $section->id }}"
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
      {{$sections->onEachSide(1)->links()}}
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
    const sectionId = $(this).data('id');

    // set action
    $('#delete-form').attr('action', '{{url("/sections")}}'+"/" + sectionId)

    // show the modal
    $('#delete-modal').modal('show');
  });

  // EDIT A topic
  $('.edit').on('click', function() {
    // get topic id
    const sectioncId = $(this).data('id');

    // set action
    $('#edit-form').attr('action', '{{url("/sections")}}'+"/"+ sectioncId);

    //reset selected option for each clicon edit
    $('#edit-topic > option').each(function(){
      $(this).attr('selected', false);
    });

    // fill inputs with data
    const label = $(this).parent().siblings('td').first()[0].innerText;
    const topic = $(this).parent().siblings('td')[1].innerText;

    $('#edit-label').val(label);
    $( '#edit-label-error' ).html( "" );
    $( '#edit-image-error' ).html( "" );

    // selected option for topic
    $('#edit-topic > option').each(function(){
      if($(this).text()==topic){
        $(this).attr('selected', true);
      }
    });

    // show the modal
    $('#edit-modal').modal('show');

    $('#edit-form').submit(function(e){
      const urlForm= $(this).attr('action');
      e.preventDefault();
      $( '#edit-label-error' ).html( "" );
      $( '#edit-image-error' ).html( "" );
      $.ajax({    
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url: urlForm,
                  method: 'POST',
                  data: {
                    label : $('#edit-label').val(),
                    topic:$('#edit-topic').val(),
                    _method:"PUT",
                  },
                  success: function(result){
                  	if(result.errors)
                  	{
                      $('#edit-form').find('#edit-label-error').html(result.errors.label[0]);
                  	}
                  	else
                  	{
                  		$('#edit-modal').modal('hide');
                      $('#alert-message').removeClass('d-none').html(result.alert);
                      location.reload();
                  	}
                  }});

    });

  });
  // ADD TOPIC
    $('.add').on('click', function() {
    // set action
    $('#add-form').attr('action','{{url("/sections")}}');

    $( '#add-label-error' ).html( "" );

    // show the modal
    $('#add-modal').modal('show');

    $('#add-form').submit(function(e){
      const urlForm= $(this).attr('action');
      e.preventDefault();
      $( '#add-label-error' ).html( "" );
      $.ajax({
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url: urlForm,
                  method: 'POST',
                  data: {
                    label:$('#add-label').val(),
                    topic:$('#add-topic').val(),
                  },
                  success: function(result){
                  	if(result.errors)
                  	{
                      if(result.errors.label && result.errors.topic){
                        $('#add-form').find('#add-label-error').html(result.errors.label[0]);
                      }else if(result.errors.topic){
                        $('#add-form').find('#add-topic-error').html(result.errors.topic[0]);
                      }else{
                        $('#add-form').find('#add-label-error').html(result.errors.label[0]);
                      }
                  	}
                  	else
                  	{
                  		$('#add-modal').modal('hide');
                      $('#alert-message').removeClass('d-none').html(result.alert);
                      location.reload();
                  	}
                  }});

    });

  });
});

</script>

@endsection