@extends('layout.studentlayout')
@section('space-works')
    <h2 class="mb-4">Packages</h2>
    <!-- Button trigger modal -->


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <strong>Success</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table mt-5 table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Package Name</th>
                <th>Exams</th>
                <th>Price</th>
                <th>Expiry Date</th>
                <th>Buy Package</th>
            </tr>
        </thead>
        @php
            $sr = 1;
        @endphp
        @if (count($paidpackage) > 0)
            <tbody>

                @foreach ($paidpackage as $package)
                    @php
                        $exams = '';
                        $packageid = $package->id;
                        foreach ($package->exam_id as $exam) {
                            $exams .= $exam->exam_name . ',';
                        }
                    @endphp

                    @if ($package->is_paid == false)
                        <tr>
                            <td>{{ $sr++ }}</td>
                            <td>{{ $package->name }}</td>
                            <td>
                                {{ $exams }}
                            </td>
                            <td>
                                @php
                                    $price = json_decode($package->price);
                                @endphp
                                @foreach ($price as $key => $p)
                                    {{ $key }} : {{ $p }}<br>
                                @endforeach
                            </td>
                            <td>{{ $package->exapire }}</td>
                            <td>

                                @if ($package->exapire >= date('Y-m-d'))
                                    <b><a href="#" style="color: red;text-decoration:none" class="buynow"
                                            data-bs-toggle="modal" data-bs-target="#buymodel"
                                            data-price="{{ $package->price }}" data-id="{{ $package->id }}"> Buy
                                            Now</a></b>
                                @else
                                    <b>Expired</b>
                                @endif
                            </td>
                        {{-- </tr> --}}
                        @else
                        {{-- <td colspan="4">No Packages Found!</td> --}}


                    @endif


                    
                @endforeach

            </tbody>
        @else
        {{-- <tr> --}}
            <td colspan="4">No Packages Found!</td>
        
        @endif
    </table>

    {{-- buy model --}}
    <div class="modal fade" id="buymodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Buy Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="buyform" action="{{ route('packagepayment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" id="package_id">
                        <select name="price" class="form-control" id="price" required>
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

    {{-- buy model --}}


    <script>
        var ispkr = false;
        $(document).ready(function() {

            $(".buynow").click(function() {
                var prices = JSON.parse($(this).attr('data-price'));
                var html = '';
                html += `
              
              <option value="">Select  Currency(Price)</option>
              <option value="` + prices.PKR + `">PKR: ` + prices.PKR + `</option>
              `;

                $("#price").html(html);

            });

            $(".buynow").click(function() {
                var id = $(this).attr('data-id');
                $("#package_id").val(id);
            });




            //     $('.fa-copy').click(function(){
            //     $(this).parent().append('<span class="copytext">Copied</span>');
            //     var code=$(this).parent().attr('data-code');
            //     console.log(code)
            //     var url="{{ URL::to('/') }}/exam/"+code;
            //    var $temp=$("<input>");
            //    $("body").append($temp);

            //    $temp.val(url).select();
            //    document.execCommand('copy');
            //    $temp.remove();



            //     setTimeout(() => {
            //        $(".copytext").remove(); 
            //     }, 1000);
            // });






            // $("#price").change(function() { 

            //     var price = $("#price").val();
            //     if(price.includes('PKR')){
            //         ispkr=true;

            //     }else{
            //         ispkr=false;
            //     }
            // });







        })
    </script>


@endsection
