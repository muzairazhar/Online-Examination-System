@extends('layout.studentlayout')

@section('space-works')

    <h2>Results</h2>

    <table class="table ">
        <thead>
            <tr>
                <th>#</th>
                <th>Exam</th>
                <th>Result</th>
                <th>Status</th>
            </tr>
        <tbody>
            @if (count($attempts) > 0)
                @php
                    $x = 1;
                @endphp
                @foreach ($attempts as $attempt)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $attempt->exam[0]['exam_name'] }}</td>
                        <td>

                            @if ($attempt->status == 0)
                                Not Declared
                            @else
                                @if ($attempt->marks >= $attempt->exam[0]['pass_marks'])
                                    <span style="color: green">Passed</span>
                                @else
                                    <span style="color: red">Fail</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($attempt->status == 0)
                                <span style="color: red">Pending</span>
                            @else
                                <a href="#" style="text-decoration: none" data-id="{{ $attempt->id }}" class="reviewexam"
                                    data-bs-toggle="modal" data-bs-target="#reviewqna">Review Q&A</a>
                            @endif
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">You Not attempt any exam!</td>
                </tr>
            @endif
        </tbody>
        </thead>

    </table>

    <!-- Modal -->
    <div class="modal fade" id="reviewqna" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body review-qna">
                    loading....
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="explanationmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Explanation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                <p id="explanation"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".reviewexam").click(function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('review-student-qna') }}",
                    data: {
                        attempt_id: id
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.success == true) {
                            var html = '';
                            var data = data.data;
                            if (data.length > 0) {
                                for (var i = 0; i < data.length; i++) {
                                    var is_correct='<span style="color:red" class="fa fa-close"></span>';
                                    if(data[i]['answer']['is_correct']==1){
                                        is_correct='<span style="color:green" class="fa fa-check"></span>';

                                    }

                                    html += `
                             
                             <div class="row">
                        <div class="col-sm-12">
                            <h6>Q(`+(i+1 )+`).`+ data[i]['question']['questions']+` </h6>
                                   <p >Ans:-` + data[i]['answer']['answer']+` `+ is_correct+`</p>`;
                                   if( data[i]['question']['explanation']!= null){
                                            html+=` <p><a  href="#"  style="text-decoration:none" class="explanation" data-explanation="`+ data[i]['question']['explanation'] +`"    data-bs-toggle="modal" data-bs-target="#explanationmodel">Explanation</a></p>`;
                                   }
                                   html+=`

                                  </div>
               
                                </div>         
                             `;

                                }
                            } else {
                                html += `<h6>You didn't attempt any Question!</h6>`;

                            }


                        } else {

                        }
                        $(".review-qna").html(html);
                    }
                });


            });
            $(document).on('click','.explanation',function(){
              var data=$(this).attr('data-explanation');
              $("#explanation").text(data);
            });
        });
    </script>


    {{-- 
console.log(data); 
var html='';
if(data.success == true){
       var data=data.data;
       if(data.length>0){
         
            for(var 1=0;  i < data.length; i++){
             html+=`
               
             <div class="row">
               <div class="col-sm-12">
                   <h6>Q(`+i+1+`).`+ data[i]['question']['questions']+` </h6>
                   <p >Ans:-`+ +`</p>
                   
                   </div>
               
               </div>
             
             `;
            }




       }else{
           html+=`<h6>You didn't attempt any Question!</h6>`
       }
}else{
   html+=`<p>Having Some issue on Server Side!</p>`
}

$('.review-qna').html(html);
} --}}


@endsection
