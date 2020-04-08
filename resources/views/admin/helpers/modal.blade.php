<!-- Modal -->
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
</div>