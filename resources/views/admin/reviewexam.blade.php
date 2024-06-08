@extends('layout.admin-layout')
@section('space-works')

    <h2 class="mb-4"> Review Exams</h2>
    @if(session('success'))

<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
    <strong>Success</strong>  {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
    <div class="table-responsive mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Exam Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Review</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count=1;
                @endphp
                @if (count($attempt) > 0)
                    @foreach ($attempt as $attempt)
                
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $attempt->user[0]['name'] }}</td>
                        <td>{{ $attempt->exam[0]['exam_name'] }}</td>
                        <td>
                            @if ($attempt->status ==0)
                                <span style="color: red">Pending</span>
                            @else
                            <span style="color: darkgreen">Approved</span>
                                
                            @endif
                        </td>
                        <td>
                            @if ($attempt->status == 0)
                            <a href="#"  style="text-decoration: none" data-id="{{ $attempt->id }}"  class="reviewbtn" data-bs-toggle="modal" data-bs-target="#reviewexammodal">Review & Approved</a>
                            @else
                               Completed                                
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">Students Not Attempt Exams!</td>
                    </tr>
                @endif

            </tbody>
        </table>

<!-- Modal -->
<div class="modal fade" id="reviewexammodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form  id="reviewform">
            @csrf
            <input type="hidden" id="attempt_id" name="attempt_id">
        <div class="modal-body review-exam">
          loading....
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary  approvedbtn" >Approved</button>
        </div>
    </form>
      </div>
    </div>
  </div>


  <script>
   $(document).ready(function(){
    $(".reviewbtn").click(function(){
        var id=$(this).attr('data-id');
        $("#attempt_id").val(id);
        $.ajax({
            type: "GET",
            url: "{{ route('reviewqnaa') }}",
            data: {attempt_id:id},
            success: function (data) {
                // console.log(data.data);
                   
                var html='';
                if(data.success==true){
                    // console.log(data.data);
                    var data=data.data;
                    if(data.length>0){
                        for(var i=0; i < data.length; i++){

                         var iscorrect='<span  style="color:red;" class="fa fa-close"></span>';

                              if(data[i]['answer']['is_correct']==1){
                              iscorrect='<span  style="color:green;" class="fa fa-check"></span>';

                              }

                              var answer=data[i]['answer']['answer']; 
                              html+=`
                                          <div class="row">
                                             <div class="col-sm-12">
                                                 <h6>Q(`+(i+1)+`).`+data[i]['question']['questions']+`</h6>
                                                 <p>Ans:-`+answer+` `+iscorrect+`  <p>
                                             </div>
                                             </div>
                                   
                                          `;
                                            
                        }
                    } else{
                            html+=`<h6>Student not attempt any Question!</h6>
                                    <p>if you approve this exam student will fail</p>
                            `;

                        }
 
                }else{
                 html+=`<p>Having Some Server Issue!</p>`

                }

                $('.review-exam').html(html);


            }
        });

    });

    $("#reviewform").submit(function(e){
           e.preventDefault();
           $(".approvedbtn").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

            var formdata=$(this).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('approvedqna') }}",
                data: formdata,
                success: function (data) {
                    location.reload();

                    console.log(data.data);
                    // if(data.success==true){
                    // }
                }
            });
    })  

   })
  </script>
        @endsection