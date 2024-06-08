
<?php $__env->startSection('space-works'); ?>
    <h2 class="mb-4">Q&A</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddqnaModal">
        Add Q&A
    </button>

    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importqnaModal">
       Import Q&A
    </button>
    
    <?php if(session('success')): ?>

<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
    <strong>Success</strong>  <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

    <div class="table-responsive mt-3">
        <table class="table table-light">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Question</th>
                    <th scope="col">Answer</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($questions) > 0): ?>
                    <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="">
                            <td><?php echo e($question->id); ?></td>
                            <td><?php echo e($question->questions); ?></td>
                            <td><a href="#" class="btn btn-primary ansbtn" data-id="<?php echo e($question->id); ?>"
                                    data-bs-toggle="modal" data-bs-target="#showansModal">See answer</a></td>

                            <td>
                                <button class="btn btn-primary editbtn " data-id="<?php echo e($question->id); ?>"
                                    data-bs-toggle="modal" data-bs-target="#editqnaModal">Edit</button>
                                    <button class="btn btn-danger deletebtn " data-id="<?php echo e($question->id); ?>"
                                        data-bs-toggle="modal" data-bs-target="#deleteqnaModal">Delete</button>
                    
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Question & Answer not found!</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

    <!-- add-q & a-Modal -->
    <div class="modal fade" id="AddqnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Q & A</h5>
                    <button id="addanswer" class="btn btn-primary  ml-3">Add answer</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addqna">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body addmodalans">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="question" placeholder="Enter Questions"
                                    required>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <textarea  class="form-control w-100" name="explanation" placeholder="Enter  your explanation(Optional)"></textarea>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color: red"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary addq">Add Q & A</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end-add-Q & a-modal-->


    <!-- edit-q & a-Modal -->
    <div class="modal fade" id="editqnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Q & A</h5>
                    <button id="editqna" class="btn btn-primary  ml-3">Add answer</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editqna" class="editqna">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body edit-modal-answer">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="question_id" id="question_id">
                                <input type="text" class="form-control" name="question" id="question"
                                    placeholder="Enter Questions" required>

                                <br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <textarea  class="form-control w-100" name="explanation" id="explanation" placeholder="Enter  your explanation(Optional)"></textarea>
                                <br>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <span class="editerror" style="color: red"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary up editq" >Update Q & A</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end-edit-Q & a-modal-->



    
    <div class="modal fade" id="deleteqnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteqnaform">
                        <?php echo csrf_field(); ?>
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
    

    
    
    <div class="modal fade" id="importqnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importqnaform" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                       <p>Are you Sure you want to Import this Q&A! </p>
                        <input type="file"   name="file" id="uploadfile" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms.excel"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info importq ">Import Q&A</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    



    <!-- show-ans-modal -->
    <div class="modal fade" id="showansModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Show Answer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive mt-3">

                        <table class="table-hover table">
                            <thead>
                                <th>#</th>
                                <th>Answer</th>
                                <th>Is Correct</th>
                            </thead>
                            <tbody class="showanswer">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="error" style="color: red"></span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end-show-answer-modal-->

    <script>
        $(document).ready(function() {
            // form submission
            $("#addqna").submit(function(e) {
                e.preventDefault();
                $(".addq").html('Please Wait <i class="fa fa-spinner fa-spin"></i>');

                if ($(".answer").length < 2) {
                    $(".error").text("Please add minimum two answer");
                    setTimeout(() => {
                        $(".error").text("");

                    }, 2000);

                } else {
                    var checkiscorrect = false;
                    for (let i = 0; i < $('.is_correct').length; i++) {
                        if ($(".is_correct:eq(" + i + ")").prop("checked") == true) {
                            checkiscorrect = true;
                            $(".is_correct:eq(" + i + ")").val($(".is_correct:eq(" + i + ")").next().find(
                                'input').val())
                        }
                    }

                    if (checkiscorrect) {
                        var formdata = $(this).serialize();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo e(route('addqna')); ?>",
                            data: formdata,
                            success: function(data) {
                                console.log(data);
                                if (data.success == true) {
                                    // alert(data.message);
                                    location.reload();
                                } else {
                                    alert(data.msg);
                                }
                            }
                        });
                    } else {
                        $(".error").text("Please Select anyone correct answer");
                        setTimeout(() => {
                            $(".error").text("");

                        }, 2000);

                    }

                }
            });


            // add answer
            $("#addanswer").click(function() {
                if ($(".answer").length >= 6) {
                    $(".error").text("You can add maximum six answers");
                    setTimeout(() => {
                        $(".error").text("");

                    }, 2000);
                } else {
                    var html = `
    <div class="row mt-3 answer d-flex">
                    <div class="col d-flex">
                        <input type="radio" name="is_correct"  class="is_correct" />
<div  style="width:300px">
                        <input type="text" class="form-control ms-2" name="answer[]" placeholder="Enter answer" required>
                        </div>
                        <button class="btn btn-danger ml-4 removebtn" >Remove</button>
                    </div>
                   </div>
    `
                }
                $(".addmodalans").append(html);

            });
            $(document).on('click', '.removebtn', function() {
                $(this).parent().parent().remove();
            })

            //  show answer
            $('.ansbtn').click(function() {
                var question = <?php echo json_encode($questions, 15, 512) ?>;
               // console.log(question);
                var qid = $(this).attr('data-id');
                var html = ``;
                for (let i = 0; i < question.length; i++) {
                    if (question[i]['id'] == qid) {
                        var answerlength = question[i]['answer'].length;
                        for (let j = 0; j < answerlength; j++) {
                            let iscorrect = "no";
                            if (question[i]['answer'][j]['is_correct'] == 1) {
                                iscorrect = "yes";
                            }
                            html += `
        <tr>
            <td>${j + 1}</td>
            <td>${question[i]['answer'][j]['answer']}</td>
            <td>${iscorrect}</td>
        </tr>
    `;
                        }
                        break;
                    }
                }
                $(".showanswer").html(html);

            });

            // edit  or update Q & A

            $("#editqna").click(function() {
                if ($(".editanswer").length >= 6) {
                    $(".editerror").text("You can add maximum six answers");
                    setTimeout(() => {
                        $(".editerror").text("");

                    }, 2000);
                } else {

                    var html = `
                    <div class="row mt-3 edit editanswer d-flex">
                    <div class="col d-flex">
                        <input type="radio" name="is_correct"  class="edit_is_correct" />
                              <div  style="width:300px">
                        <input type="text" class="form-control ms-2" name="new_answer[]" placeholder="Enter answer" required>
                        </div>
                        <button class="btn btn-danger ml-4   removebtn" >Remove</button>
                    </div>
                   </div>
    `
                }
                $(".edit-modal-answer").append(html);

            });

            $(".editbtn").click(function() {

                var qid = $(this).attr('data-id');
                //    console.log(qid);
                $.ajax({
                    type: "GET",
                    url: "<?php echo e(route('getqnadetails')); ?>",
                    data: {
                        qid: qid
                    },
                    success: function(data) {
                        console.log(data);
                        var qna = data[1][0];
                        // console.log(qna);
                        $("#question_id").val(qna.id);

                        $("#question").val(qna.questions);
                        $("#explanation").val(qna.explanation);
                        $(".editanswer").remove();

                        var html = '';
                        for (let i = 0; i < qna['answer'].length; i++) {
                            var checked = '';
                            if (qna['answer'][i]['is_correct'] == 1) {
                                checked = 'checked';
                            }
                            html += `

                    <div class="row mt-3 edit editanswer d-flex">
                    <div class="col d-flex">
                        <input type="radio" name="is_correct"  class="edit_is_correct" ` + checked + `/>
                              <div  style="width:300px">
                        <input type="text" class="form-control ms-2" name="answer[` + qna['answer'][i]['id'] +
                                `]" placeholder="Enter answer" value="` + qna['answer'][i][
                                    'answer'
                                ] + `" required>
                        </div>
                        <button class="btn btn-danger ml-4 removeanswer removebtn" data-is="` + qna['answer'][i][
                                'id'] + `">Remove</button>
                    </div>
                   </div>
`;
                        }
                        $(".edit-modal-answer").append(html);

                    }
                });

            });

            // update-qna-submission
            $(".editqna").submit(function(e) {

                e.preventDefault();
                $(".editq").html('Please Wait <i class="fa fa-spinner fa-spin"></i>');

                if ($(".editanswer").length < 2) {
                    $(".editerror").text("Please add minimum two answer");
                    setTimeout(() => {
                        $(".editerror").text("");

                    }, 2000);

                } else {
                    var checkiscorrect = false;
                    for (let i = 0; i < $('.edit_is_correct').length; i++) {
                        if ($(".edit_is_correct:eq(" + i + ")").prop("checked") == true) {
                            checkiscorrect = true;
                            $(".edit_is_correct:eq(" + i + ")").val($(".edit_is_correct:eq(" + i + ")")
                                .next().find(
                                    'input').val())
                        }
                    }

                    if (checkiscorrect) {
                        var formdata=$(this).serialize();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo e(route('updateqna')); ?>",
                            data: formdata,
                            success: function(data) {
                                console.log(data);

                                if (data.success == true) {
                                    location.reload();
                                } else {
                                    // location.reload();

                                    // alert(data.msg);
                                }
                            }
                        });
                    } else {
                        $(".editerror").text("Please Select anyone correct answer");
                        setTimeout(() => {
                            $(".editerror").text("");

                        }, 2000);

                    }

                }
            });

            //edit-remove-answer

            $(document).on('click', '.removeanswer', function() {
                var ansid = $(this).attr('data-is');
                $.ajax({
                    type: "GET",
                    url: "<?php echo e(route('deleteans')); ?>",
                    data: {
                        id: ansid
                    },
                    // dataType: "dataType",
                    success: function(data) {
                        if (data.success == true) {
                            console.log(data.msg);
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            // delete qna
            $(".deletebtn").click(function(){
                var id=$(this).attr('data-id');
                $("#delete_qna_id").val(id);
            });
            $("#deleteqnaform").submit(function(e){
                // alert();
                e.preventDefault();
                $(".delq").html('Please Wait <i class="fa fa-spinner fa-spin"></i>');

                var formdata=$(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('deleteqna')); ?>",
                    data: formdata,
                    // dataType: "dataType",
                    success: function (data) {
                        if(data.success==true){
                            // alert();
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });

           // import qna
            $("#importqnaform").submit(function(e){
                e.preventDefault();
                $(".importq").html('Please Wait <i class="fa fa-spinner fa-spin"></i>');

                var formdata=new FormData();
                formdata.append("file",uploadfile.files[0]);
                $.ajaxSetup({
                    headers:{
                        "X-CSRF-TOKEN":"<?php echo e(csrf_token()); ?>"
                    }
                })
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('importqna')); ?>",
                    data: formdata,
                    processData:false,
                    contentType:false,
                    success: function (data) {
                      console.log(data);
                        if(data.success==true){
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/admin/qnadashboard.blade.php ENDPATH**/ ?>