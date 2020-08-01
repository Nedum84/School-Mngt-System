<?php
include("inc/header.inc.php");
if ($status!="students") {
    header("Location:home");
}
?>	<title>Check your result</title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents">
		<center>
		<div class="check_result_wrapper">
			<div class="check_result">
				<div class="check_r_header">
					<h3>Pay School Fees</h3>
					<h4>Carefully Enter the Remita Retrival Reference (RRR) below</h4>
				</div>
				<div class="check_r_body">
					<form method="post" id="school_fees_pay">
						<input type="text" id="st_class" placeholder="Remita Retrival Reference (RRR)" name="sch_fees_pay_rrr_class" value="<?php if (isset($rrr)){echo $rrr;}?>">
						<span>Make sure you payed to the bank using the RRR generated from this website.</span>
						<div class="enter_btn">
							<button id="sch_fees_pay_submit" type="submit" name="sch_fees_pay_submit"> <i class="fa fa-check"></i> Pay School Fees</button>
						</div>
					</form>
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

	});
</script>
<div id="error_feed"></div>
</body>
</html>