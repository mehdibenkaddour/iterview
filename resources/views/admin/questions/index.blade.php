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
    Add Question Type 1
    @endslot

    @slot('modalId')
    add-modal-1
    @endslot

    @slot('formId')
    add-form-1
    @endslot

    @slot('method')
    POST
    @endslot

    @slot('content')
      <div class="form-group">
          <label>Question</label>
          <input type="text" name="add-question-1" value="" class="form-control" id="add-question-1">
          <span class="text-danger">
              <strong id="add-question-error-1"></strong>
          </span>
      </div>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label>Topic</label>
            <select class="browser-default custom-select" name="add-topic-1" id="add-topic-1">
                <option selected disabled>Select Topic</option>
                @foreach($topics as $topic )
                <option value="{{$topic->id}}">{{$topic->label}}</option>
                @endforeach
            </select>
  
            <span class="text-danger">
                <strong id="add-topic-error-1"></strong>
            </span>
          </div>
        </div>

        <div class="col">
          <div class="form-group">
              <label>Section</label>
              <select class="browser-default custom-select" name="add-section-1" id="add-section-1">
                  <option selected disabled>Select Section</option>
              </select>
          </div>
        </div>
      </div>

      <div class="form-group">
          <label for="code">Enter code <small>(Optional)</small></label>
          <textarea class="form-control" id="code-1" rows="3" name="code-1"></textarea>
      </div>
      <div class="form-group" id="answers">
          <label>Answers</label>
          <div class="input-group">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                      <input type="radio" name="answer">
                  </div>
              </div>
              <input type="text" class="form-control" aria-label="Text input with radio button">
          </div>
          <br />
          <div class="input-group">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                      <input type="radio" name="answer">
                  </div>
              </div>
              <input type="text" class="form-control" aria-label="Text input with radio button">
          </div>
          <br />
          <div class="input-group">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                      <input type="radio" name="answer">
                  </div>
              </div>
              <input type="text" class="form-control" aria-label="Text input with radio button">
          </div>
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


<div class="modal fade" id="question-type">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Question Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="form-group">
       <label>Type</label>
       <select class="browser-default custom-select" name="add-type" id="add-type">
        <option selected disabled required>Select Type</option>
        <option value="1">Type 1</option>
        <option value="2">Type 2</option>
        <option value="3">Type 3</option>
      </select>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="step_1" data-id="">Next</button>
      </div>
    </div>
  </div>
</div>



<div class="card">
  <!-- Card header -->
  <div class="card-header border-0">
    <h3 class="mb-0">List of Questions</h3>
    <button class="btn btn-primary btn-sm float-right add">ADD</button>
  </div>
  <!-- Light table -->
  <div class="table-responsive">
    <table class="table align-items-center table-flush" id="questionsTable">
      <thead class="thead-light">
        <tr>
          <th scope="col">Question</th>
          <th scope="col">Type</th>
          <th scope="col">Topic</th>
          <th scope="col">Section</th>
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
 
  const myTextArea = document.getElementById("code-1");
  const myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
            mode: "javascript",
            theme: "material-darker",
            lineNumbers: true,
            indentUnit: 4
        }); 
  const table = handleQuestionsLoad();

  handleQuestionsDelete();

  handleQuestionsEdit();

  handleQuestionsAdd();

  function handleQuestionsLoad() {
    
    // Datatables config
    const table = $('#questionsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('ajax.questions') !!}',
        columns: [
            { data: 'question', name: 'question'},
            { data: 'type', name: 'type'},
            { data: 'section', name: 'section' },
            { data: 'topic', name: 'topic'},
            { data: 'actions', name: 'actions' }
        ]
    });

    return table;
  }

  function handleQuestionsDelete() {
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

  function handleQuestionsEdit() {
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

      $('#edit-form').unbind('submit').submit(function(e){
        // turn button into loading state
        iterview.handleButtonLoading(true, '#editBtn');

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

  function handleQuestionsAdd() {
    // ADD Question
    $('.add').on('click', function() {
        $('#add-type').get(0).selectedIndex = 0;
        $('#question-type').modal('show')
        $('#step_1').on('click',function(){
        // adding this line to keep scroll bar in the second modal
        $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
        $('#question-type').modal('hide');
        if($('#add-type').val()==1){
            $('#add-form-1').attr('action','{{url("/questions")}}');

            $( '#add-question-error-1' ).html( "" ); 
            // clear inputs
            $('#add-question-1').val('');
            myCodeMirror.setValue("");
            myCodeMirror.refresh();
            $("#answers input[type=text]").each(function() {
                    this.value='';
                });
            $("#answers input[type=radio]").each(function() {
                    this.checked=false;
                });
            $('#add-topic-1').get(0).selectedIndex = 0;

            
            // show the modal
            $('#add-modal-1').modal('show');
            

            $('#add-form-1').unbind('submit').submit(function(e){
                // turn button into loading state
                iterview.handleButtonLoading(true, '#addBtn');
                const dataAnswer= [];
                var correctAnswer= "";
                const urlForm= $(this).attr('action');
                e.preventDefault();

                $("#answers input[type=text]").each(function() {
                    dataAnswer.push(this.value);
                });

                const radioButtons = $("#answers input:radio[name='answer']");
                var selectedIndex = radioButtons.index(radioButtons.filter(':checked'));
                correctAnswer= dataAnswer[selectedIndex];
                dataAnswer.splice(selectedIndex,1);
                console.log($('#code-1').val());
                $('#add-question-error-1').html( "" );
                $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: urlForm,
                method: 'POST',
                data: {
                    content: $('#add-question-1').val(),
                    topic: $('#add-topic-1').val(),
                    section: $('#add-section-1').val(),
                    type:1,
                    correct_answer:correctAnswer,
                    wrong_answers:dataAnswer,
                    code:$('#code-1').val(),

                },
                success: function(result){
                    // turn button into default state
                    iterview.handleButtonLoading(false, '#addBtn');
                    /*if(result.errors)
                    {
                    if(result.errors.content && result.errors.topic){
                        $('#add-form-1').find('#add-content-error-1').html(result.errors.content[0]);
                    }else if(result.errors.topic){
                        $('#add-form-1').find('#add-topic-error-1').html(result.errors.topic[0]);
                    }else{
                        $('#add-form').find('#add-content-error-1').html(result.errors.content[0]);
                      }
                    }*/
                    iterview.handleSuccessResponse(table, result, '#add-modal')
                }});

            });
        }
    })
    });
    $('select[name="add-topic-1"]').on('change', function(){
        var topicId = $(this).val();
        if(topicId) {
            $.ajax({
                url: '/sections/get/'+topicId,
                type:"GET",
                dataType:"json",
                success:function(data) {

                    $('select[name="add-section-1"]').empty();

                    $.each(data, function(key, value){

                        $('select[name="add-section-1"]').append('<option value="'+ key +'">' + value + '</option>');

                    });
                },
            });
        } else {
            $('select[name="add-section-1"]').empty();
        }

    });
  }
    
});

</script>

@endsection