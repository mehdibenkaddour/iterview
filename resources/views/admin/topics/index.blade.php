@extends('layouts.master')

@section('section-title')
ITerview
@endsection

@section('content')
@component('admin.helpers.modal')
    @slot('title')
        Supprimer le sujet
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
    Voulez-vous vraiment supprimer ce sujet !
    @endslot

    @slot('cancel')
    Annuler
    @endslot

    @slot('confirm')
    Oui, supprimer
    @endslot

    @slot('submitId')
    deleteBtn
    @endslot
@endcomponent


<!-- Edit Modal Component -->

@component('admin.helpers.modal')
    @slot('title')
    Modifier le sujet
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
        <label>Le titre</label>
        <input type="text" name="label" value="" class="form-control" id="edit-label">
        <span class="text-danger">
            <strong id="edit-label-error"></strong>
        </span>
      </div>
      <div class="form-group">
       <label>L'image</label>
        <div class="custom-file">
            <input type="file" name="image" class="custom-file-input" id="edit-image">
            <label class="custom-file-label" for="image">Choisissez l'image</label>
        </div>
        <span class="text-danger">
              <strong id="edit-image-error"></strong>
        </span>
      </div>
    @endslot

    @slot('cancel')
        Annuler
    @endslot

    @slot('confirm')
        Modifier
    @endslot

    @slot('submitId')
    editBtn
    @endslot

@endcomponent

<!-- ADD Modal Component -->

@component('admin.helpers.modal')
    @slot('title')
    Ajouter un sujet
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
        <label>Le titre</label>
        <input type="text" name="label" value="" class="form-control" id="add-label">
        <span class="text-danger">
            <strong id="add-label-error"></strong>
        </span>
      </div>
      <div class="form-group">
       <label>L'image</label>
        <div class="custom-file">
            <input type="file" name="image" class="custom-file-input" id="add-image">
            <label class="custom-file-label" for="image">Choisissez l'image</label>
        </div>
        <span class="text-danger">
              <strong id="add-image-error"></strong>
        </span>
      </div>
    @endslot

    @slot('cancel')
        Annuler
    @endslot

    @slot('confirm')
        Ajouter
    @endslot

    @slot('submitId')
    addBtn
    @endslot

@endcomponent

<div class="card">
  <!-- Card header -->
  <div class="card-header border-0">
    <h3 class="mb-0">La list des sujets</h3>
    <button class="btn btn-primary btn-sm float-right add">Ajouter un sujet</button>
  </div>
  <!-- Light table -->
  <div class="table-responsive">
    <table class="table align-items-center table-flush" id="topicsTable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Le Sujet</th>
          <th scope="col">Le code d'accés</th>
          <th scope="col">Les actions</th>
        </tr>
      </thead>
      <tbody class="list table-hover">
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

  const table = handleTopicLoad();

  handleTopicDelete();
  handleTopicEdit();
  handleTopicAdd();

  function handleTopicLoad() {
    // Datatables config
    const table = $('#topicsTable').DataTable({
        processing: true,
        serverSide: true,
        language: {
            "lengthMenu": "Afficher _MENU_ éléments",
            "sInfo":"Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "zeroRecords": "Aucun sujets",
            "search": "Rechercher",
            "oPaginate": {
                "sNext":     "Suivant",
                "sPrevious": "Précédent"
    },
        },
        ajax: '{!! route('ajax.topics') !!}',
        columns: [
            { data: 'topic', name: 'topic' },
            { data: 'code', name: 'code' },
            { data: 'actions', name: 'actions' }
        ]
    });

    return table;
  }

  function handleTopicDelete() {
    // DELETE A Topic
    $('#topicsTable tbody').on('click', 'button.delete', function() {
      // get topic id
      const topicId = $(this).data('id');

      // set action
      $('#delete-form').attr('action', '{{url("/topics")}}'+ '/' + topicId)

      // show the modal
      $('#delete-modal').modal('show');
    });
  } 

  function handleTopicEdit() {
    // EDIT A topic
    $('#topicsTable tbody').on('click', 'button.edit', function() {
      // get topic id
      const topicId = $(this).data('id');

      // set action
      $('#edit-form').attr('action', '{{url("/topics")}}'+ '/' + topicId);

      // fill inputs with data
      const label = $(this).parents().eq(2).siblings('td').first().find('span')[0].innerHTML;

      $('#edit-label').val(label);
      $('#edit-label-error').html('');
      $('#edit-image-error').html('');

      // show the modal
      $('#edit-modal').modal('show');

      $('#edit-form').unbind('submit').submit(function(e) {

        // turn button into loading state
        iterview.handleButtonLoading(true, '#editBtn')      

        e.preventDefault();

        const urlForm= $(this).attr('action');

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

          success: function(result) {
            // turn button into default state
            iterview.handleButtonLoading(false, '#editBtn')  

            if(result.errors) {
              if(result.errors.label && result.errors.image) {
                $('#edit-form').find('#edit-label-error').html(result.errors.label[0]);
              } else if(result.errors.image){
                $('#edit-form').find('#edit-image-error').html(result.errors.image[0]);
              } else{
                $('#edit-form').find('#edit-label-error').html(result.errors.label[0]);
              }
            } else {
              iterview.handleSuccessResponse(table, result, '#edit-modal');
            }
          }});

      });

    });
  }
  
  function handleTopicAdd() {
    // ADD TOPIC
    $('.add').on('click', function() {
    // set action
    $('#add-form').attr('action', '{{url("/topics/")}}');

    $( '#add-label-error' ).html( "" );
    $( '#add-image-error' ).html( "" );

    // clear inputs
    $('#add-label').val('');
    $('#add-image').val('');
    
    // show the modal
    $('#add-modal').modal('show');

    $('#add-form').unbind('submit').submit(function(e){
      e.preventDefault();

      // turn button into loading state
      iterview.handleButtonLoading(true, '#addBtn')  

      const urlForm= $(this).attr('action');
      
      $('#add-label-error').html('');
      $('#add-image-error').html('');

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
          // turn button into default state
          iterview.handleButtonLoading(false, '#addBtn')  

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
            iterview.handleSuccessResponse(table, result, '#add-modal');
          }
        }});
        
      });
    });
  }
});

</script>

@endsection