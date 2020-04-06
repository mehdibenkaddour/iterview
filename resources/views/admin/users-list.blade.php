@extends('layouts.master');

@section('title')
Admin-Panel
@stop

@section('content')
<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                              <form action="" method="POST" id="deleteForm">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                 <div class="modal-body">
                                     Are you sure you want to delete the user !
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                  </div>
                              </form>
                              </div>
                            </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    // For A Delete Record Popup
    $('.delete-user').click(function () {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');

        $("#deleteForm", 'input').val(id);
        $("#deleteForm").attr("action", url);
    });
});
</script>
-->
<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Users-list</h4>
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                      {{session('status')}}
                    </div>
                @endif
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        ID
                      </th>
                      <th>
                        Name
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Role
                      </th>
                      <th>
                        Edit
                      </th>
                      <th class="text-right">
                        Delete
                      </th>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                     @if($user->id != 1)
                        <tr>
                        <td>
                          {{$user->id}}
                        </td>
                        <td>
                          {{$user->name}}
                        </td>
                        <td>
                          {{$user->email}}
                        </td>
                        <td>
                          {{$user->role}}
                        </td>
                        <td>
                          <a href="/user-edit/{{ $user->id}}" class="btn btn-success">EDIT</a>
                        </td>
                        <td class="text-right">
                          <button type="button" class="btn btn-danger delete-user" data-toggle="modal" data-target="#exampleModal" data-id="{{$user->id}}" data-url="{{url('user-delete',$user->id)}}">DELETE</button>
                        </td>
                      </tr>

                      @else
                      <tr>
                        <td>
                          {{$user->id}}
                        </td>
                        <td>
                          {{$user->name}}
                        </td>
                        <td>
                          {{$user->email}}
                        </td>
                        <td>
                          {{$user->role}}
                        </td>
                        <td>
                          <a href="/user-edit/{{ $user->id}}" class="btn btn-success">EDIT</a>
                        </td>
                        <td class="text-right">
                        </td>
                        @endif
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
@stop

@section('scripts')
@stop