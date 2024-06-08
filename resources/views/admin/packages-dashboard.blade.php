@extends('layout.admin-layout')
@section('space-works')
    <h2 class="mb-4">Packages</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpackagemodel">
        Add Package
    </button>

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
                <th>Actions</th>
            </tr>
        </thead>
        @php
            $sr = 0;
        @endphp
        @if (count($packages) > 0)
            <tbody>

                @foreach ($packages as $package)
                    <tr>
                        <td>{{ $sr++ }}</td>
                        <td>{{ $package->name }}</td>
                        <td>
                            {{-- {{ $package->exam_id }} --}}
                            @foreach ($package->exam_id as $exam)
                                {{ $exam->exam_name }} ,
                            @endforeach
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
                            <a href="" class="btn btn-primary editbtn" data-obj="{{ $package }}"
                                data-bs-toggle="modal" data-bs-target="#editpackage">Edit</a>

                            <a href="" class="btn btn-danger deletepkg" data-id={{ $package->id }}
                                data-bs-toggle="modal" data-bs-target="#deletestudentModal">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <td colspan="4">No Packages Found!</td>
        @endif
    </table>



    <!-- add-subject-Modal -->
    <div class="modal fade" id="addpackagemodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addpackage" method="POST" action="{{ route('addpackage') }}">
                        @csrf
                        <input type="text" name="package_name" id="" class="form-control mb-2"
                            placeholder="Enter package Name" required>
                        @if (count($exams) > 0)
                            @foreach ($exams as $exam)
                                @php
                                    $id = $exam->id;
                                @endphp
                                @if ($exam->check_in_exits_package == false)
                                    <input type="checkbox" name="exam[]" value="{{ $id }}" class="exams">
                                    &nbsp;&nbsp;{{ $exam->exam_name }} <br>
                                @endif
                            @endforeach
                            &nbsp;
                        @endif
                        <input type="date" name="expire" min="{{ date('Y-m-d') }}" required class="form-control">
                        &nbsp;

                        <input type="number" name="pricepkr" id="" min="0" class="form-control"
                            placeholder="Price(PKR)">
                        &nbsp;
                        <p class="error m-0" style="color: red"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary addp">Add Package</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end-add-subject-modal-->
    {{-- {{ $packages }} --}}

    <!-- Delete-subject-Modal -->
    <div class="modal fade" id="deletestudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <p>Are you Sure you want to delete this Subject! </p>
                    {{-- <input type="hidden" name="id" id="delete_stu_id" /> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger finaldelete delp">Delete</button>
                </div>
                {{-- </form> --}}

            </div>
        </div>
    </div>

    <div class="modal fade" id="editpackage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editpackage" method="POST" action="{{ route('editpackage') }}">
                        @csrf
                        <input type="hidden" name="package_id" id="package_id">
                        <input type="text" name="package_name" id="package_name" class="form-control mb-2"
                            placeholder="Enter package Name" required>
                        @if (count($exams) > 0)
                            @foreach ($exams as $exam)
                                @php
                                    $id = $exam->id;
                                @endphp
                                @if ($exam->check_in_exits_package == false)
                                    <input type="checkbox" name="exam[]" value="{{ $id }}"
                                        class="editexams"> &nbsp;&nbsp;{{ $exam->exam_name }} <br>
                                @endif
                            @endforeach
                        @endif
                        <div id="package_exam">

                        </div>
                        &nbsp;
                        <input type="date" name="expire" min="{{ date('Y-m-d') }}" required class="form-control"
                            id="expire_date">
                        &nbsp;
                        <input type="number" name="pricepkr"   id="package_price" min="0"  class="form-control"
                            placeholder="Price(PKR)">
                        &nbsp;
                        <p class="error m-0" style="color: red"></p>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary editp">Update</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#addpackage").submit(function(e) {
                $(".addp").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var lgt = $(".exams").length;
                var checked = false;
                for (var i = 0; i < lgt; i++) {
                    if ($('.exams:eq(' + i + ')').prop('checked') == true) {
                        checked = true;
                        break;
                    }
                }
                if (checked == false) {
                    e.preventDefault();

                    $(".error").text("Please select at least one exam");

                }
            });

            $(".deletepkg").click(function() {
                var obj = $(this);
                var id = $(this).attr('data-id');
                // var check=true;
                var clicked = false; // Declare clicked outside the function

                $(".finaldelete").click(function() {
                    $(".delp").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                    clicked = true;
                    console.log(clicked);
                    
                    if (clicked == true) {

                        $.ajax({
                            type: "GET",
                            url: "{{ route('deletepkg') }}",
                            data: {
                                id,
                                id
                            },
                            // dataType: "dataType",
                            success: function(data) {
                                if (data.success == true) {
                                    obj.parent().parent().remove();
                                    // alert(data.msg);
                                    location.reload();

                                } else {
                                    alert(data.msg);

                                }
                            }
                        });
                    }






                });

                // console.log(clicked); // Now this will print true after a click




            });


            $(".editbtn").click(function() {
                var obj = JSON.parse($(this).attr('data-obj'));
                console.log(obj);
                $("#package_id").val(obj.id);
                $("#package_name").val(obj.name);
                $("#package_price").val(obj.name);
                $("#expire_date").val(obj.expire)

                var exam = obj.exam_id;
                var html = '';
                for (var i = 0; i < exam.length; i++) {
                    html += `
                <input type="checkbox" checked name="exam[]" value="` + exam[i]['id'] +
                        `" class="editexams"> &nbsp;&nbsp;` + exam[i]['exam_name'] + ` <br>       
                `;
                }
                $("#package_exam").html(html);
            });

            $("#editpackage").submit(function(e) {
                $(".editp").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')
                var lgt = $(".editexams").length;
                var checked = false;
                for (var i = 0; i < lgt; i++) {
                    if ($('.editexams:eq(' + i + ')').prop('checked') == true) {
                        checked = true;
                        break;
                    }
                }
                if (checked == false) {

                    e.preventDefault();
                    $(".error").text("Please select at least one exam");

                }
            });



        })
    </script>
@endsection
