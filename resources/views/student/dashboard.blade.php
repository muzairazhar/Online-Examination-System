@extends('layout.studentlayout')
@section('space-works')

    <h1>Free Exams</h1>
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
        <p>Click <span onclick="alert('Hello! Welcome Student');">here</span> to greet.</p>

        <tbody>
            @if (count($exams) > 0)
                @php
                    $count = 1;
                @endphp
                @foreach ($exams as $exam)

                        @php
                        $exam->id;
                            $package = json_decode(json_encode($exam->package), true);
                            $expiry = '';
                            foreach ($package as $data) {
                                $expiry = $data['exapire'];
                            }
                        @endphp
                        @if ($exam->is_package_exam !=true || date('Y-m-d') > $expiry)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ $exam->subjects['0']['subject'] }}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->time }} Hrs</td>
                            <td>{{ $exam->attempt }} Time</td>
                            <td>{{ $exam->attempt_counter }}</td>
                            <td><a href="#" data-code="{{ $exam->enterance_id }}"><i class="fa fa-copy "></i></a></td>
    
                        </tr>

                        @else
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ $exam->subjects['0']['subject'] }}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->time }} Hrs</td>
                            <td>{{ $exam->attempt }} Time</td>
                            <td>{{ $exam->attempt_counter }}</td>
                            <td><a href="#" data-code="{{ $exam->enterance_id }}"><i class="fa fa-copy "></i></a></td>
    
                        </tr>
                        @endif
                  

                   
                @endforeach
            @else
                <tr>
                    <td colspan="8"> No Exams Available</td>
                </tr>
            @endif
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('.fa-copy').click(function() {
                $(this).parent().append('<span class="copytext">Copied</span>');
                var code = $(this).parent().attr('data-code');
                console.log(code)
                var url = "{{ URL::to('/') }}/exam/" + code;
                var $temp = $("<input>");
                $("body").append($temp);

                $temp.val(url).select();
                document.execCommand('copy');
                $temp.remove();



                setTimeout(() => {
                    $(".copytext").remove();
                }, 1000);
            });

        })
    </script>
@endsection
