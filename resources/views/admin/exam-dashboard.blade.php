@extends('layout.admin-layout')
@section('space-works')
    <h2 class="mb-4">Exams</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddexamModal">
        Add Exam
    </button>
    @if(session('success'))
    <div class="alert alert-success append mt-3
     alert-dismissible fade show"  role="alert">
      <strong>{{ session('success') }}  </strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    {{-- show exam --}}

    <table class="table mt-5">
        <thead>
            <tr>
                <th scope="col">#</th>
                    <th scope="col">Exam Name</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Total Attempt</th>
                    <th scope="col">Plan</th>
                    <th scope="col">Prices</th>
                    <th scope="col">Add Questions</th>
                    <th scope="col">Show Questions</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Action</th> 
            </tr>
        </thead>
        <tbody>
            @php
            $count = 0;
        @endphp

          @if (count($exams) > 0)
          @foreach ($exams as $exam)
          <tr>
              <td>{{ $count++ }}</td>
              <td style="display: none">{{ $exam->id }}</td>
              <td>{{ $exam->exam_name }}</td>
              <td>{{ $exam->subjects[0]['subject'] }}</td>
              <td>{{ $exam->attempt }} Time</td>
              <td>
                  @if ($exam->plan == 0)
                  @php
                //   print_r($exam->package);
                  $package=  json_decode(json_encode($exam->package),true);
                          $expiry='';
                          foreach ($package as $data) {
                              $expiry=$data['exapire'];
                          }
                  @endphp
                      @if ($exam->is_package_exam && date('Y-m-d')<=$expiry)
                          <span class="badge bg-success">Package Exam (Free)</span>
                      @else

                          <span style="color: green">Free</span>
                      @endif
                  @else
                      <span style="color: red">Paid</span>
                  @endif
              </td>
              <td>
                  @if($exam->prices != null) 
                      @php
                          $prices = json_decode($exam->prices, true);
                       

                      @endphp
                      
                      @foreach ($prices as $key => $price)
                          <span>{{ $key }}: {{ $price }}</span>
                      @endforeach
                  @else
                      <span>No Prices</span>
                  @endif
              </td>
              <td>
                  <a href="#" class="addquestion" data-id="{{ $exam->id }}" data-bs-toggle="modal"
                     data-bs-target="#addqnaModal" style="text-decoration: none">Add Questions</a>
              </td>
              <td>
                  <a href="#" class="seequestion" data-id="{{ $exam->id }}" data-bs-toggle="modal"
                     data-bs-target="#seeqnaModal" style="text-decoration: none">See Questions</a>
              </td>
              <td>{{ $exam->date }}</td>
              <td>{{ $exam->time }}</td>
              <td>
                  <button class="editbtn btn btn-primary w-2" data-id="{{ $exam->id }}" data-disable="
                      
                      @if ($exam->is_package_exam && date('Y-m-d')<=$expiry)
                      1
                      @else
                      0
                      @endif

                      
                      " data-bs-toggle="modal"
                          data-bs-target="#editexamModal">Edit</button>


                  <button class="deletebtn btn btn-danger" data-id="{{ $exam->id }}" data-bs-toggle="modal"
                          data-bs-target="#deleteexamModal">Delete</button>
              </td>
          </tr>
      @endforeach
          @else
          <tr>
            <td colspan="11" class="text-center">Exam Not Found!</td>
        </tr>
          @endif
        </tbody>

    </table>
    

    {{-- end show exam --}}

    <!-- add-exam-Modal -->
    <div class="modal fade" id="AddexamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addexam">
                        @csrf
                        <input type="text" name="exam_name" id="" class="form-control"
                            placeholder="Enter exam name" required>
                        <br>
                        <select class="form-select" id="subject_id" name="subject_id" aria-label="Default select example">
                            <option selected>Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                            @endforeach
                        </select>
                        <br>
                        <input type="date" name="date" class="form-control" required
                            min="@php
                        echo date("Y-m-d"); @endphp" >
                        <br>
                        <input type="time" name="time" class="form-control" step="60">
                        <br>
                        <input type="number" name="attempt" id="attempt" required class="form-control" min="1" placeholder="Enter Attempt Time">
                        <br>
                        <select name="plan" class="plan form-control w-100 mb-4">
                            <option value="">Select Plan</option>
                            <option value="0">Free</option>
                            <option value="1">Paid</option>
                        </select>
                        <input type="number" name="pkr" class="form-control"  id="" placeholder="In Pkr" disabled>
                        
                        {{-- <input type="number" name="usd"  id="" class="form-control mt-2"   placeholder="In Usd" disabled> --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary addexm">Add</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end-add-exam-modal-->


    {{-- start-add-Question-modal --}}

    <div class="modal fade" id="addqnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Q&A</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addqna">
                        @csrf
                  <input type="hidden" name="exam_id" id="addexamid">
                  <br>
                <input type="search" name="search" id="search" placeholder="Search Here"  onkeyup="searhtable()" w-100 class="form-control">
                <br>
                <br>
                <table class="table" id="questiontable">
                    <thead>
                        <th>Select</th>
                        <th>Question</th>
                    </thead>
                    <tbody class="addbodyy" id="body">
                          
                    </tbody>
                </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary addq">Add</button>
                </div>
                </form>

            </div>
        </div>
    </div>


    {{-- end-add-Question-modal --}}

        {{-- start-see-Question-modal --}}

        <div class="modal fade" id="seeqnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">See Q&A</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>#</th>
                            <th>Question</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="addbody" id="seequestiontable">
                              
                        </tbody>
                    </table>
    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="submit" class="btn btn-primary">Add</button> --}}
                    </div>
                    
    
                </div>
            </div>
        </div>
    
    
        {{-- end-see-Question-modal --}}
    




    {{-- edit-exam-modal-start --}}
    <div class="modal fade" id="editexamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editexam">
                        @csrf
                        <input type="hidden" name="id" id="exam_id">
                        <input type="text" name="exam_name" id="exam_name" class="form-control"
                            placeholder="Enter exam name" required>
                        <br>
                        <select class="form-select" id="subject_id_of_edit_modal" name="subject_id"
                            aria-label="Default select example">
                            <option selected>Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                            @endforeach
                        </select>
                        <br>
                        <input type="date" name="date" id="date" class="form-control" required
                            min="@php echo date("Y-m-d"); @endphp">
                        <br>
                        <input type="time" name="time" id="time" class="form-control" step="60">
                        <br>
                        <input type="number" name="attempt" id="edit_attempt" required class="form-control"
                            min="1">

                            <br>

                            <select name="plan"  id="plan" class="plan form-control w-100 mb-4">
                                <option value="">Select Plan</option>
                                <option value="0">Free</option>
                                <option value="1">Paid</option>
                            </select>
                            <input type="number" name="pkr" id="pkr" class="form-control"  id="" placeholder="In Pkr" disabled>
                            
                            {{-- <input type="number" name="usd"  id="usd" class="form-control mt-2"   placeholder="In Usd" disabled> --}}
    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary editexm">Update</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    {{-- edit-exam-modal-ends --}}



    {{-- delete-Question-modal-start --}}
    <div class="modal fade" id="deleteqnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteqnaform">
                        @csrf
                       <p>Are you Sure you want to delete this Q&A! </p>
                        <input type="hidden"  name="delete_qna_id" id="delete_qna_id"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger delq">Delete</button>
                </div>
                </form>

            </div>
        </div>
    </div>



    

    {{-- delete-exam-modal-start --}}
    <div class="modal fade" id="deleteexamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteexam">
                        @csrf
                        <p>Are you Sure you want to delete this Exam! </p>
                        <input type="hidden" name="delete_exam_id" id="delete_exam_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger delexm">Delete</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    {{-- delete-exam-modal-ends --}}

    <script>
        $(document).ready(function() {
            var globaldata=false;
            $("#addexam").submit(function(e) {
                e.preventDefault();
                $(".addexm").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('addexam') }}",
                    data: data,
                    // dataType: "dataType",
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            })
            // get exam  detail
            $(".editbtn").click(function() {
                var isdisbaled=parseInt($(this).attr('data-disable'));
                if(isdisbaled==1){
                    $("#plan").css('pointer-events','none').addClass('disabled');
                }else{
                    $("#plan").css('pointer-events','all');
                }
                var id = $(this).attr('data-id');
                $("#exam_id").val(id);
                var url = "{{ route('getexamdetail', 'id') }}";
                url = url.replace('id', id);
                $("#pkr").val('');
                 $("#usd").val('');
                $.ajax({
                    url: url,
                    success: function(response) {
                        if (response.success == true) {
                            var exam = response.data;
                            $("#exam_name").val(exam[0].exam_name);
                            $("#subject_id_of_edit_modal").val(exam[0].subject_id);
                            $("#edit_attempt").val(exam[0].attempt);
                            $("#date").val(exam[0].date);
                            $("#time").val(exam[0].time);
                            $("#plan").val(exam[0].plan);

                            if (exam[0].plan==1) {
                                var prices=JSON.parse(exam[0].prices);
                                $("#pkr").val(prices.PKR);
                                $("#usd").val(prices.USD);
                                $("#pkr").prop('disabled',false);
                                $("#usd").prop('disabled',false);
                                
                                $("#pkr").attr('required');
                                $("#usd").attr('required');

                            } else {
                              
                                
                                $("#pkr").prop('disabled',true);
                                $("#usd").prop('disabled',true);
                                

                                $("#pkr").removeAttr('required');
                                $("#usd").removeAttr('required');
                            }
                        } else {
                            alert(response.msg);
                        }
                    }
                })
            })
            
            // update exam
            $("#editexam").submit(function(e) {
                e.preventDefault();
                $(".editexm").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('updateexam') }}",
                    data: data,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            })

            // delete exam
            $(".deletebtn").click(function() {
                var id = $(this).attr("data-id");
                $("#delete_exam_id").val(id);
            });

            $("#deleteexam").submit(function(e) {
                e.preventDefault();
                $(".delexm").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('deleteexam') }}",
                    data: data,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //add qestion art start
            $(".addquestion").click(function(){
                var id=$(this).attr('data-id');
                $("#addexamid").val(id);
                     $.ajax({
            type: "GET",
            url: "{{ route('getquestion') }}",
            data: {exam_id:id},
            success: function (data) {
                console.log(data);
                if(data.success == true){
                   var questions=data.data;
                   var html='';
                   if(questions.length>0){
                     for(var i=0;i<questions.length;i++){
                        html+=`
                        <tr>
                            <td><input type="checkbox" value="`+ questions[i]['id']+`"  name="questions_ids[]"></td>
                            <td>`+ questions[i]['questions']+`</td>

                        </tr>
                        `

                     }
                     $(".addbodyy").html(html);
                   }

                   else{
                   }
                }else{
                    html+=`
                    <tr>
                      <td colspan="2">Questions Not Available!</td>  
                </tr>
                    `;
                    $('.addbodyy').html(html);
                    // alert(html);
                    globaldata=true;
                    // alert(data.msg);    

                }
                
            }
          });
        });

        $("#addqna").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                
                console.log($(this).questions);
                
                     if(globaldata!=true){
                        $(".addq").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')
                        $.ajax({
                    type: "POST",
                    url: "{{ route('addquestion') }}",
                    data: data,
                    success: function(data) {
                        location.reload();

                        if (data.success == true) {
                        } else {
                          
                             
                        }
                    }
                });
                     }else{
                        // var html='';
                        //     html+=`<span>  Questions not found </span>`;
                        //     $("#addqna").html(html);
                        // alert();
                     }
             
                });
 
                // get-exam-assigned question
                     $(".seequestion").click(function(){
                        var id=$(this).attr('data-id');
                        $.ajax({
                            type: "GET",
                            url: "{{ route('getexamquestion') }}",
                            data: {exam_id:id},
                            success: function (data) {
                                console.log(data);
                                var html='';
                                var question=data.data;
                                if(question.length>0){
                                    html+=``;
                                    for(var i=0;i<question.length;i++){
                                        html+=`
                                        <tr>
                                        <td>`+(i+1)+`</td>    
                                        <td>`+question[i]['question'][0]['questions']+`</td>   
                                        <td> <button class="btn btn-danger deletequestion" data-id="`+question[i]['id']+`">Delete</button></td>
 
                                        </tr>
                                        `; 
                                    }
                                }else{
                                    html+=`
                                    <tr>
                                        <td colspan="3">
                                            No Questions Assigned Yet!
                                        </td>
                                    </tr>
                                    `
                                }
                                $("#seequestiontable").html(html);
                            }
                        });
                     });

                     //  delete questions
    $(document).on('click','.deletequestion',function(){
        // alert("success");
        var obj=$(this);
        var id=$(this).attr('data-id');

        $.ajax({
            type: "GET",
         url: "{{ route('deleteexamquestion') }}",
            data: {id:id},
            success: function (data) {
                console.log(data.Success);
                if(data.success==true){
                   obj.parent().parent().remove();
                }else{
                    alert(data.msg);
                }
            }
        });
        });

     // plan js
     
     $(".plan").click(function(){
        var plan=$(this).val();
        if(plan == 1){
            $(this).next().attr('required','required'); 
            $(this).next().next().attr('required','required'); 
            $(this).next().prop('disabled',false); 
            $(this).next().next().prop('disabled',false); 
        }else{
            
            $(this).next().removeAttr('required','required'); 
            $(this).next().next().removeAttr('required','required'); 
            $(this).next().prop('disabled',true); 
            $(this).next().next().prop('disabled',true);
        }


     })
        });
    </script>

{{-- javascript --}}
<script>
    var input,filter,table,tr,td,i,textval;
    function searhtable(){
        input=document.getElementById("search");
        filter=input.value.toUpperCase();
        table=document.getElementById("questiontable");
        tr=table.getElementsByTagName("tr");
        for(i=0;i<tr.length;i++){
            td=tr[i].getElementsByTagName("td")[1];
            // console.log(t);    
            if(td){
                textval=td.textContent ||  td.innerText;
                if(textval.toUpperCase().indexOf(filter)> -1){
                    tr[i].style.display="";
                    }else{
                    tr[i].style.display="none";
            }
        }
     }
    




    };
</script>
{{-- javascript --}}
@endsection
