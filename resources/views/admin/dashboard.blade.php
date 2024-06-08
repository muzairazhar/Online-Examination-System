@extends('layout.admin-layout')
@section('space-works')
    <h2 class="mb-4">Subjects</h2>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddsubjectModal">
  Add Subject
</button>
@if(session('success'))
<div class="alert alert-success append mt-3 alert-dismissible fade show"  role="alert">
  <strong>{{ session('success') }}  </strong> 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<table class="table mt-3">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Subject</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
  @if (count($subjects)>0)
@foreach ($subjects as $subject )
    <tr>
        <td>{{ $subject->id }}</td>
        <td>{{ $subject->subject }}</td>
        <td>
          <button class="btn btn-primary editbutton" data-id="{{ $subject->id }}" data-subject="{{ $subject->subject }}" data-bs-toggle="modal" data-bs-target="#editsubjectModal">Edit</button>

        </td>

        <td>
          <button class="btn btn-danger deletebutton" data-id="{{ $subject->id }}" data-subject="{{ $subject->subject }}" data-bs-toggle="modal" data-bs-target="#deletesubjectModal">Delete</button>
        </td>
    </tr>
@endforeach
      @else
      <tr><td colspan="4">Subject Not Found!</td></tr>
  @endif
    </tbody>
  </table>

<!-- add-subject-Modal -->
<div class="modal fade" id="AddsubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addsubject">
            @csrf
            <input type="text" name="subject" id="" class="form-control" placeholder="Enter Subject Name" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary addsub">Add Subject</button>
      </div>
    </form>

    </div>
  </div>
</div><!-- end-add-subject-modal-->

<!-- edit-subject-Modal -->
<div class="modal fade" id="editsubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editsubject">
            @csrf
            <label for="" class="form label">Subject</label>
            <input type="text" name="subject" id="edit-subject" class="form-control" id="edit_subject" placeholder="Enter subject name" required>
            <input type="hidden"  name="id" id="edit_sub_id"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary editsub">Update</button>
      </div>
    </form>

    </div>
  </div>
</div><!-- end-edit-subject-modal-->


<!-- Delete-subject-Modal -->
<div class="modal fade" id="deletesubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="deletesubject">
            @csrf
           <p>Are you Sure you want to delete this Subject! </p>
            <input type="hidden"  name="id" id="delete_sub_id"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger delsub">Delete</button>
      </div>
    </form>

    </div>
  </div>
</div><!-- end-delete-subject-modal-->

    <script>
        $(document).ready(function() {
            $("#addsubject").submit(function(e) {
                e.preventDefault();
                $(".addsub").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('addsubject') }}",
                    data: formdata,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            // edit subject

            $(".editbutton").click(function(){
               var subject_id=$(this).attr("data-id");
              var subject_name=$(this).attr("data-subject");
              $("#edit-subject").val(subject_name);
              $("#edit_sub_id").val(subject_id);
              
            })
            $("#editsubject").submit(function(e) {
                e.preventDefault();
                $(".editsub").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('editsubject') }}",
                    data: formdata,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            // Delete subject
            $(".deletebutton").click(function(){
              var subject_id=$(this).attr("data-id");
              $("#delete_sub_id").val(subject_id);
            });

            $("#deletesubject").submit(function(e) {
                e.preventDefault();
                $(".delsub").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('deletesubject') }}",
                    data: formdata,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

        })
    </script>
@endsection
