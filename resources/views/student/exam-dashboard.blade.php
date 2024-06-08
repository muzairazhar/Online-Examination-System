@extends('layout.layout-common')
@section('space-work')
    @php
        $time = explode(':', $exam[0]['time']);
    @endphp
    <div class="container">
        {{-- {{ $qna }} --}}
        <p style="color:black"><span>Welcome, {{ Auth::user()->name }}</span></p>
        <h1 class="text-center ">{{ $exam[0]['exam_name'] }}</h1>
        <h4 class="text-end time" >{{ $exam[0]['time'] }}</h4>
         @php
            $qcount = 1;
        @endphp
        
        @if ($success == true)
           @if (count($qna) > 0)
                <form action="{{ url('/exam-submit')}}" method="post" class="mb-5"  id="exam_form"  >
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam[0]['id'] }}">

                    @foreach ($qna as $data)
                        <div>
                            <h5>Q.{{ $qcount++ }} {{ $data['question'][0]['questions'] }} </h5>
                            <input type="hidden" name="q[]" value="{{ $data['question'][0]['id'] }}" id="">
                            <input type="hidden" name="ans_{{ $qcount - 1 }}" id="ans_{{ $qcount - 1 }}"
                                class="sans">

                            @php
                                $acount = 1;
                            @endphp
                            @foreach ($data['question'][0]['answer'] as $answer)
                                <p><b> {{ $acount++ }})</b> {{ $answer['answer'] }}
                                    <input type="radio" class="select_ans" name="radio_{{ $qcount - 1 }}"
                                        id="ans   _{{ $qcount - 1 }}" value="{{ $answer['id'] }}"
                                        data-id="{{ $qcount - 1 }}">
                                </p>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="text-center">
                        <input type="submit" class="btn btn-info">
                    </div>
                </form>
            @else
                <h3 style="color: red" class="text-center">Questions & Answer not available!</h3>
            @endif
        @else
            <h3 style="color: red" class="text-center">{{ $msg }}</h3>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $(".select_ans").click(function() {
                var id = $(this).attr('data-id');
                $("#ans_" + id).val($(this).val());
            });


            var time = @json($time);
            console.log(time);
            $(".time").text(time[0]+':::::'+time[1]+': 00 Left time');
            var second= 9;
            var hours=parseInt(time[0]);
            var minutes= parseInt(time[1]);

            var timer = setInterval(() => {

               if(hours == 0 && minutes == 0 && second == 0){
                clearInterval(timer);
                
                $("#exam_form").submit();

               }


               console.log(hours+" -:- "+minutes+" -:- "+second);

                if(second <= 0){
                    minutes--;
                    second = 59;
                }


                if(minutes<=0 && hours !=0){
                    hours--;
                    minutes=60;
                    second=59;
                }
                 
                var temphours=hours.toString().length>1?hours:'0'+hours;
                var tempmint=minutes.toString().length>1?minutes:'0'+minutes;
                var tempsec=second.toString().length>1?second:'0'+second;


                $(".time").text(temphours+':'+tempmint+': '+ tempsec+' Left time');

                second--;


            }, 1000);
            


        });

        function isvalid() {
            var result = true;
            var qlength = parseInt("{{ $qcount }}") - 1;
             console.log(qlength);

            for (i = 1; i <= qlength; i++) {
                if ($("#ans_" + i).val() == "") {
                    result = false;
                    $("#ans_" + i).parent().append("<span style='color:red' class='error_msg'>Please Select Answer</span>");
                    setTimeout(() => {
                        $(".error_msg").remove();
                    }, 50000);
                }
                // alert(i);
            }
            return result;

        }
    </script> 
@endsection
