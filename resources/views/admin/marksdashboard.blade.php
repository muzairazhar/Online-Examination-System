@extends('layout.admin-layout')
@section('space-works')
    <h2 class="mb-4">Marks</h2>
    <!-- Button trigger modal -->

    @if(session('success'))
    <div class="alert alert-success append mt-3
     alert-dismissible fade show"  role="alert">
      <strong>{{ session('success') }}  </strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="loader" id="loader" style="display: none"></div>



    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Marks/Q</th>
                <th scope="col">Total Marks</th>
                <th scope="col">Passing Marks</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
<tbody>
@if (count($data)>0)
@php
    $x=1;
@endphp
    @foreach ($data as $data )
    <tr>
        <td>{{ $x++ }}</td>
        <td>{{ $data->exam_name }}</td>
        <td>{{ $data->marks }}</td>
        <td>{{ count($data->getqnaexam) * $data->marks }}</td>
        <td>{{ $data->pass_marks }}</td>
        <td>
            <button class="btn btn-primary editbtn"  data-id="{{ $data->id }}" data-pass-marks="{{ $data->pass_marks }}" data-marks="{{ $data->marks }}" data-totalq="{{  count($data->getqnaexam) }}"  data-bs-toggle="modal" data-bs-target="#editmarksmodal">Edit</button>
        </td>
    </tr>
        
    @endforeach
@else
    <tr>
        <td colspan="5">
            Exams Not Added!

        </td>
    </tr>
@endif
</tbody>
    </table>



       <div class="modal fade" id="editmarksmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Marks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="editmarks">
                        @csrf
                 <div class="row mt-2">
                      <div class="col-sm-4">
                        <label for="">Marks/Q</label>
                      </div>
                      
                      <div class="col-sm-6">
                        <input type="text"  onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46"
                        id="marks"    name="marks" placeholder="Enter Marks/Q" required>
                        <input type="hidden" name="exam_id" id="exam_id" >
                      </div>
                 </div>

                 
                 <div class="row mt-2">
                    <div class="col-sm-4">
                      <label for="">Total Marks</label>
                    </div>

                    <div class="col-sm-6">
                        <input type="text"  disabled placeholder="Total Marks" id="tmarks">
                      </div>
                 </div>

                    <div class="row mt-2">
                        <div class="col-sm-4">
                          <label for="">Passing Marks</label>
                        </div>

                     <div class="col-sm-6">
                        <input type="text"  onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46"
                        id="pass_marks"    name="pass_marks" placeholder="Enter passing Marks/Q" required>
                    </div>
                   
               </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary editq">edit</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            var totalqna=0;
            $('.editbtn').click(function(){
                var exam_id=$(this).attr('data-id');
                var marks=$(this).attr('data-marks');
                var totalq=$(this).attr('data-totalq');
                var passmarks=$(this).attr('data-pass-marks')
                totalqna=totalq;

                $('#exam_id').val(exam_id);
                $('#marks').val(marks);
                $('#tmarks').val((marks*totalq).toFixed(1));
                $("#pass_marks").val(passmarks);
            });

            $("#marks").keyup(function(){
                $('#tmarks').val(($(this).val()* totalqna).toFixed(1));
            });
            $("#pass_marks").keyup(function(){
                var tmarks=$('#tmarks').val();
                var pmarks=$(this).val();
                $('.pass-error').remove();

                if(parseFloat(pmarks) >= tmarks){
                    $(this).parent().append('<p style="color:red" class="pass-error">Passing Marks will be less than total marks!</p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);
                }

            });

            $('#editmarks').submit(function(event){
                event.preventDefault();
                $(".editq").html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                var tmarks=$('#tmarks').val();
                var pmarks=$("#pass_marks").val();
                $('.pass-error').remove();

                if(parseFloat(pmarks) >= tmarks){
                    $("#pass_marks").parent().append('<p style="color:red" class="pass-error">Passing Marks will be less than total marks!</p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);

                    return false;
                }


          var formdata=$(this).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('updatemarks') }}",
                data: formdata,
                // dataType: "dat/aType",
                success: function (data) {
                    location.reload();
                }
            });

            })
        })
    </script>

@endsection
