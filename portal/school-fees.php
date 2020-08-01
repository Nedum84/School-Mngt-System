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
					<h3>School Fees Payment</h3>
					<h4>Select Operation Type</h4>
				</div>
				<div class="sch_fees_body">
					<button onclick="window.location.href='school-fees-gen'" id="school-fees-gen">
						<i class="fa fa-refresh fa-spin"></i> Generate Invoice
					</button>
					<button onclick="window.location.href='school-fees-pay'" id="school-fees-pay">
						<i class="fa fa-check"></i> Pay School Fees
					</button>
				</div>
			</div>
		</div>
		</center>
	</div>
</div>

<?php
include("inc/footer.inc.php");
?>
</body>
</html>