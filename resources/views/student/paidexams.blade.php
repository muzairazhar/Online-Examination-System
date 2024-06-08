@extends('layout.studentlayout')
@section('space-works')

    <h1>Paid Exams</h1>
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess</strong>         {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    
@endif

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>error</strong>         {{ session('error') }}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

@endif



@if(session()->has('error'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sucess</strong>         {{ session('error') }}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

@endif

    <table class="table">
        <thead>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Total Attempt</th>
            <th>Available Attempt</th>
            <th>Copy Link</th>
        </thead>
        <p>Click <span onclick="alert('Hello!');">here</span> to greet.</p>

        <tbody>
            @if (count($exams) > 0)
                @php
                    $count = 1;
                @endphp
                @foreach ($exams as $exam)
                    <tr>
                        <td style="display: none">{{ $exam->id }}</td>
                        <td>{{ $count++ }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects['0']['subject'] }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->time }} Hrs</td>
                        <td>{{ $exam->attempt }} Time</td>
                        <td>{{ $exam->attempt_counter }}</td>
                       
                                     @if (count($exam->getpaidinfo)>0 && $exam->getpaidinfo[0]['user_id']==auth()->user()->id)
                                     <td><a href="#"  data-code="{{ $exam->enterance_id }}"><i class="fa fa-copy "></i></a></td>
                                         @else
                                         <td> <b><a href="#" style="color: red;text-decoration:none" class="buynow"
                                            data-prices="{{ $exam->prices }}" data-id="{{ $exam->id }}"  data-bs-toggle="modal" data-bs-target="#buymodel"> Buy
                                            Now</a></b>
                                        </td>
                                     @endif


                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8"> No Exams Available</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="modal fade" id="buymodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Buy Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="buyform"  action="{{ route('paymentpkr') }}" method="POST">
                        @csrf
                        <input type="hidden" name="exam_id" id="exam_id">
                        <select name="price" class="form-control" id="price" required >
                        </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning submitbtn">Buy now</button>
                </div>
                </form>

            </div>
         
        </div>
    </div>
    <script>
    var ispkr=false;
        $(document).ready(function() {

            $(".buynow").click(function() {
                var prices = JSON.parse($(this).attr('data-prices'));
                var html = '';
                html += `
              
              <option value="">Select  Currency(Price)</option>
              <option value="` + prices.PKR + `">PKR: ` + prices.PKR + `</option>
              `;

                $("#price").html(html);
                
            });
            $(".buynow").click(function(){
              var id=  $(this).attr('data-id');
              $("#exam_id").val(id);
            });

            $('.fa-copy').click(function(){
            $(this).parent().append('<span class="copytext">Copied</span>');
            var code=$(this).parent().attr('data-code');
            console.log(code)
            var url="{{URL::to('/')}}/exam/"+code;
           var $temp=$("<input>");
           $("body").append($temp);

           $temp.val(url).select();
           document.execCommand('copy');
           $temp.remove();



            setTimeout(() => {
               $(".copytext").remove(); 
            }, 1000);
        });
 
            
               
            

            
            $("#price").change(function() { 

                var price = $("#price").val();
                if(price.includes('PKR')){
                    ispkr=true;

                }else{
                    ispkr=false;
                }
            });







        })

    </script>

   
@endsection
