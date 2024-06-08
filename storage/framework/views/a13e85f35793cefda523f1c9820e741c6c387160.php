

<?php $__env->startSection('space-works'); ?>

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
            <?php if(count($attempts) > 0): ?>
                <?php
                    $x = 1;
                ?>
                <?php $__currentLoopData = $attempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($x++); ?></td>
                        <td><?php echo e($attempt->exam[0]['exam_name']); ?></td>
                        <td>

                            <?php if($attempt->status == 0): ?>
                                Not Declared
                            <?php else: ?>
                                <?php if($attempt->marks >= $attempt->exam[0]['pass_marks']): ?>
                                    <span style="color: green">Passed</span>
                                <?php else: ?>
                                    <span style="color: red">Fail</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($attempt->status == 0): ?>
                                <span style="color: red">Pending</span>
                            <?php else: ?>
                                <a href="#" style="text-decoration: none" data-id="<?php echo e($attempt->id); ?>" class="reviewexam"
                                    data-bs-toggle="modal" data-bs-target="#reviewqna">Review Q&A</a>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">You Not attempt any exam!</td>
                </tr>
            <?php endif; ?>
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
                    url: "<?php echo e(route('review-student-qna')); ?>",
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


    


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.studentlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/student/result.blade.php ENDPATH**/ ?>