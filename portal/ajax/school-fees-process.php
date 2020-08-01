<?php 

include_once("../inc/plan_connect.inc.php");

//check result
if (isset($_POST['sch_fees_gen_session'])) {
  $sch_fees_gen_term =strtolower(trim($_POST['sch_fees_gen_term']));
  $sch_fees_gen_class   =strtolower(trim($_POST['sch_fees_gen_class']));
  $sch_fees_gen_session =strtolower(trim($_POST['sch_fees_gen_session']));
  $sch_fees_gen_st_id =strtolower(trim($_POST['sch_fees_gen_st_id']));

  $check_previous=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM sch_fees_invoice WHERE st_id='$sch_fees_gen_st_id' AND class='$sch_fees_gen_class' AND term='$sch_fees_gen_term' AND session='$sch_fees_gen_session' ORDER BY id DESC LIMIT 1 "));
  if (!empty($check_previous)&&(time()-$check_previous['order_no_and_time'])>=172800) {
    
  }else{
    $insert_invoice=mysqli_query($mysqli, "INSERT INTO sch_fees_invoice (id,st_id,class,term,session,order_no_and_time,rrr)
              VALUES ('{}','{$sch_fees_gen_st_id}','{$sch_fees_gen_term}','{$sch_fees_gen_class}','{$sch_fees_gen_session}','{$order_no_and_time},'{$rr}') ");
    if ($insert_invoice) {
      
    }
  }



}

?>