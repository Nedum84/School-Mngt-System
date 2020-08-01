<?php
include("inc/header.inc.php");

if ($status=="teachers") {
    header("Location:home");
}
?>  <title>Assignmets for <?php echo strtoupper($class) ?></title>
    <div class="left_divs">
        <?php include 'inc/left_menu.inc.php'; ?>
    </div><!-- 
    --><div class="contents">
        <center>
            <div id="welcome" class="home_welcome">
                <h4>
                    Assignment for <?php echo "$class_set ".$term." term ".$session." session"; ?>
                </h4>
            </div>
            <div class="curriculum_result_wrapper">

                <div class="res_cur">  
                    <!-- corricolum          -->
                    <div class="curriculum" style="display: block;">
                        <div class="inputss">
                            <h4>Uploaded Assignment</h4>
                            <form enctype="multipart/form-data" method="post" id="add_curriculum_form"></form>
                        </div>
                        <div class="uploaded_files">
                            <div class="show_c_uploaded">
                            <?php
if ($status=="students") {
    $feedCount=mysqli_query($mysqli,"SELECT * FROM assignment WHERE class_term='$term' AND session='$session' AND class LIKE '%".$class_set."%' ORDER BY id DESC");
    $curOutput='';
    while ($row=mysqli_fetch_assoc($feedCount)) {
    $main_subject   =strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
                    WHERE subject_code ='{$row['subject']}'"))['subject']);
    $teacherName    =strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT name FROM teachers
                    WHERE teachers_id ='{$row['teachers_id']}'"))['name']);
    $curOutput.='
                <div class="c_cols">
                    <h4>Assignment '.strtoupper($row['class']).'</h4>
                    <p style="text-transform:capitalize"><span>Subject: </span> '.$main_subject.'</p>
                    <p style="text-transform:capitalize"><span>Term: </span> '.$row['class_term'].' Term</p>
                    <p><span>Session: </span> '.$row['session'].'</p>
                    <p style="text-transform:capitalize"><span>Date: </span> '.timer_converter_f($row['uploaded_time']).'</p>
                    <p style="text-transform:capitalize"><span>Teacher: </span> '.$teacherName.'</p>
                    <p>
                        <button class="ass_view" data-type="view" data-viewPath='.$row['file_path'].'> <i class="fa fa-eye"></i> View</button>
                        <button style="background-color:rgb(0,102,190)" class="ass_download" data-type="download" data-viewPath='.$row['file_path'].'> <i class="fa fa-download"></i> Download</button>
                    </p>
                </div>
                ';
    }
    echo $curOutput;
}elseif ($status=="principal") {
    $feedCount=mysqli_query($mysqli,"SELECT * FROM assignment WHERE session='$session' AND class_term='$term'  ORDER BY id DESC "); 
    $curOutput='';
    while ($row=mysqli_fetch_assoc($feedCount)) {
    $main_subject   =strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
                    WHERE subject_code ='{$row['subject']}'"))['subject']);
    $teacherName    =strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT name FROM teachers
                    WHERE teachers_id ='{$row['teachers_id']}'"))['name']);
    $curOutput.='
                <div class="c_cols">
                    <h4>Assignment '.strtoupper($row['class']).'</h4>
                    <p style="text-transform:capitalize"><span>Subject: </span> '.$main_subject.'</p>
                    <p style="text-transform:capitalize"><span>Term: </span> '.$row['class_term'].' Term</p>
                    <p><span>Session: </span> '.$row['session'].'</p>
                    <p style="text-transform:capitalize"><span>Date: </span> '.timer_converter_f($row['uploaded_time']).'</p>
                    <p style="text-transform:capitalize"><span>Teacher: </span> '.$teacherName.'</p>
                    <p>
                        <button class="ass_view" data-type="view" data-viewPath='.$row['file_path'].'> <i class="fa fa-eye"></i> View</button>
                        <button  style="background-color:rgb(254,111,80)" class="ass_delete" data-deleteId='.$row['id'].'> <i class="fa fa-trash-o"></i> Delete</button>
                        <button  style="background-color:rgb(0,102,190)" class="ass_download" data-type="download" data-viewPath='.$row['file_path'].'> <i class="fa fa-download"></i> Download</button>
                    </p>
                </div>
                ';
    }
    echo $curOutput;
}
                             ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </div>
</div>

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click','.ass_view',function() {
            var assViewPath=$(this).attr('data-viewPath');
            var type=$(this).attr('data-type');
            window.location.href="feed_back.php?assViewPath="+assViewPath+"&ass_type="+type;
        });
        $(document).on('click','.ass_download',function() {
            var assViewPath=$(this).attr('data-viewPath');
            var type=$(this).attr('data-type');
            window.location.href="feed_back.php?assViewPath="+assViewPath+"&ass_type="+type;
        });
        $(document).on('click','.ass_delete',function() {
            var deleteAssId=$(this).attr('data-deleteId');
            if (confirm("Delete Curriculum?")) {
                $.post('ajax/misc.php',{deleteAssId:deleteAssId},function(data) {
                    if (data=='ok') {
                        window.location.reload(true);
                    }
                });
            }
        });
    })
</script>
</body>
</html><?php 

  
?>