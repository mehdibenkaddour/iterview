<!-- Modal -->
<<<<<<< HEAD
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @yield('modal-content')
        <form id="{{ $formId }}" action="" method="POST">
            <input type="hidden" name="_method" value="{{ $method }}">
            @csrf
        
          <div class="modal-body">
            {{ $content }}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $cancel }}</button>
            <button type="submit" class="btn btn-danger">{{ $confirm }}</button>
          </div>
        </form>
      </div>
    </div>
=======
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
>>>>>>> 9415909b7c40454d0cad01eda7d853427eab6243
</div>