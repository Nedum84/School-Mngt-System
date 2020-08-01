
<?php
include("inc/modals.inc.php");
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/home.js"></script>
<script type="text/javascript" src="js/edit-result.js"></script>
<script src="js/flickity.pkgd.js"></script>
<script type="text/javascript" src="nicEditor/nicEdit.js"></script>
<!-- <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> -->
<script type="text/javascript" src="js/check-result.js"></script>
<script type="text/javascript" src="js/school-fees.js"></script>

<!-- vendors -->

	<!-- jQuery -->
	<script src="../js/vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../js/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="../js/vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="../js/vendors/nprogress/nprogress.js"></script>
	<!-- Datatables -->
	<script src="../js/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../js/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="../js/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
	<script src="../js/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
	<script src="../js/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../js/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	<script src="../js/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
	<script src="../js/vendors/jszip/dist/jszip.min.js"></script>
	<script src="../js/vendors/pdfmake/build/pdfmake.min.js"></script>
	<script src="../js/vendors/pdfmake/build/vfs_fonts.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="../js/vendors/build/js/custom.min.js"></script>   

    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });
    </script>
<script type="text/javascript">
  $(document).ready(function() {

  //menu addclassShow
  $('#left_side_div li a').hover(function() {
    $('#left_side_div li a').removeClass('add_left_effect');
    $(this).addClass('add_left_effect');
  },function() {
    MenuSlide_show();
  });
  MenuSlide_show();
  function MenuSlide_show() {
    $('#left_side_div li a').removeClass('add_left_effect');
    var url=location.href;
    // var split_url=url.split('/');
    // var firstVal=split_url[split_url.length-1].split('?');
    // var currentUrl=firstVal[0];

    var split_url=url.split('?');
    var firstVal=split_url[0].split('/');
    var currentUrl=firstVal[firstVal.length-1];

    if (currentUrl=='school-fees-gen'||currentUrl=='school-fees-pay') {
      currentUrl='school-fees';
    }if(currentUrl=='edit-results') {
      currentUrl='uploads';
    }if (currentUrl=='view-all-result'||currentUrl=='form-teacher-comment'||currentUrl=='view-uploaded-r') {
      currentUrl='teacher-management';
    }if(currentUrl=='view-result') {
      currentUrl='check-result';
    }
    $('#left_side_div li a[href='+currentUrl+']').addClass('add_left_effect');
    
  }
  });
</script>