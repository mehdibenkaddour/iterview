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

    @slot('submitId')
      deleteBtn
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

    @slot('submitId')
      editBtn
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

    @slot('submitId')
      addBtn
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
    <table class="table align-items-center table-flush" id="sectionsTable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Section</th>
          <th scope="col">Topic</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        {{-- Magic happens here ssi l7aj ! no data !! but there is ! thanks to ajax ;-) --}}
      </tbody>
    </table>
  </div>
</div>

@endsection

@section('scripts')

{{-- import iterview utilities --}}
<script src="{{ asset('js/iterview.js') }}"></script>

<script>

$(document).ready(function() {

  const table = handleSectionsLoad();

  handleSectionsDelete();

  handleSectionsEdit();

  handleSectionsAdd();

  function handleSectionsLoad() {
    // Datatables config
    const table = $('#sectionsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{route('ajax.sections')}}",
          type:'GET',
          data: function (d) {
          d.topic_id = get('topic_id');
          }

        },
        columns: [
            { data: 'section', name: 'section' },
            { data: 'topic', name: 'topic'},
            { data: 'actions', name: 'actions' }
        ]
    });

    return table;
  }

  function handleSectionsDelete() {
    // DELETE A Topic
    $('#sectionsTable tbody').on('click', 'button.delete', function() {
      // get topic id
      const sectionId = $(this).data('id');

      // set action
      $('#delete-form').attr('action', '{{url("/sections")}}'+"/" + sectionId)

      // show the modal
      $('#delete-modal').modal('show');
    });
  }

  function handleSectionsEdit() {
    // EDIT A topic
    $('#sectionsTable tbody').on('click', 'button.edit', function() {
      // get topic id
      const sectioncId = $(this).data('id');

      // set action
      $('#edit-form').attr('action', '{{url("/sections")}}'+"/"+ sectioncId);

      // reset selected option for each clicon edit
      $('#edit-topic > option').each(function(){
        $(this).attr('selected', false);
      });

      // fill inputs with data
      const label = $(this).parents().eq(2).siblings('td').first()[0].innerText;
      const topic = $(this).parents().eq(2).siblings('td')[1].innerText;

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

      $('#edit-form').unbind('submit').submit(function(e){
        // turn button into loading state
        iterview.handleButtonLoading(true, '#editBtn');

        const urlForm= $(this).attr('action');
        e.preventDefault();
        $( '#edit-label-error' ).html( "" );
        $( '#edit-image-error' ).html( "" );

        var label= $('#edit-label').val();
        var image=$('#edit-image')[0].files[0];
        var topic=$('#edit-topic').val();
        var form = new FormData();

        form.append('label', label);
        form.append('image', image);
        form.append('topic', topic);
        form.append('_method','PUT');
        $.ajax({    
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: urlForm,
          method: 'POST',
          data: form,
          contentType: false,
          processData: false,

          success: function(result){
            // turn button into default state
            iterview.handleButtonLoading(false, '#editBtn');

            if(result.errors)
            {
              $('#edit-form').find('#edit-label-error').html(result.errors.label[0]);
            }
            else
            {
              iterview.handleSuccessResponse(table, result, '#edit-modal');
            }
          }});

      });

    });
  }

  function handleSectionsAdd() {
    // ADD TOPIC
    $('.add').on('click', function() {
      // set action
      $('#add-form').attr('action','{{url("/sections")}}');

      $( '#add-label-error' ).html( "" );

      // clear inputs
      $('#add-label').val('');
      $('#add-topic').get(0).selectedIndex = 0;

      // show the modal
      $('#add-modal').modal('show');

      $('#add-form').unbind('submit').submit(function(e){
        // turn button into loading state
        iterview.handleButtonLoading(true, '#addBtn');

        const urlForm= $(this).attr('action');
        e.preventDefault();
        $( '#add-label-error' ).html( "" );
        $('#add-image-error').html('');

        var label = $('#add-label').val();
        var image = $('#add-image')[0].files[0];
        var topic = $('#add-topic').val();
        var form = new FormData();
        form.append('label', label);
        form.append('image', image);
        form.append('topic', topic);
        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: urlForm,
          method: 'POST',
          data: form,
          contentType: false,
          processData: false,

          success: function(result){
            // turn button into default state
            iterview.handleButtonLoading(false, '#addBtn');
            if(result.errors)
            {
              if(result.errors.label && result.errors.topic && result.errors.image){
                $('#add-form').find('#add-label-error').html(result.errors.label[0]);
              }else if(result.errors.topic){
                $('#add-form').find('#add-topic-error').html(result.errors.topic[0]);
              }else if(result.errors.image){
                $('#add-form').find('#add-image-error').html(result.errors.image[0]);
              }else{
                $('#add-form').find('#add-label-error').html(result.errors.label[0]);
              }
            }
            else
            {
              iterview.handleSuccessResponse(table, result, '#add-modal');
            }
          }});

      });

    });
  }
    
});
function get(name){
   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
}
</script>

@endsection