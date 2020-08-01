
(function() {
$(document).ready(function() {
		// $('.nav_div').height(($('.right').height()+30)+"px");
		$(document).ajaxStart(function () {
			//$('#loader').show(); show_opacity();
		}).ajaxStop(function () {
		});

      $(document).ready(function() {
        //close modal
        $(document).on('click','.modal_close',function(e) {
          e.preventDefault();
          $('.modal_wrapper').css({'display':'none'});
          // $('#st_register_form,#st_upload_form,#t_register_form,#t_upload_form,#add_news_form,#notify_st_form,#notify_t_form,#view_uploaded_news,#view_notification,#add_sub_form,#edit_sub_form,form').css('display','none');
          $('.modal_container>form,.modal_container>div').css('display','none');
          
          $('.modal_container form')[0].reset();
          $('.feedback').html('');          
          return false;
        });
        
        // User header dropdown
        $(document).on('click','.header_div .user_info a.slidee',function(e) {
          e.preventDefault();
          $('.header_div .user_info ul').slideToggle();
        });
        //menu toggle
        $(document).on('click','#menu-toggle',function() {
          var win_width = $(window).width();
          if (win_width < 800) {
            if ($('.nav_div').css('width')=='0px') {
              $('.nav_div').addClass('add_slide_width');
              $('.right').addClass('add_slide_margin');
            }else{
              $('.nav_div').removeClass('add_slide_width'); 
              $('.right').removeClass('add_slide_margin');       
            }
          }else{
            if ($('.nav_div').css('width')!='0px') {
              $('.nav_div').addClass('add_slide_widthFull');
              $('.right').addClass('add_slide_marginFull');
            }else{
              $('.nav_div').removeClass('add_slide_widthFull'); 
              $('.right').removeClass('add_slide_marginFull');       
            }

          }

        });
        
        //Hiding the open on click
        $(document).on('click mousedown','tr th span.fa span i',function() {
          $('tr th span.fa span').hide();
        });

        //Toolpick info magnt
        $(document).on('focus','tr td',function(e) {
          var cellIndexNumber=parseInt($(this)[0].cellIndex)+1;
          // var rowIndexNumber=parseInt($(this)[0].rowIndex)+1;

          $('tr th span.fa span').hide();
          $('tr th:nth-child('+cellIndexNumber+') span.fa').children('span').show();
        });
        //Toolpick info magnt
        $(document).on('mouseover focus','table tr',function(e) {
          var tab = e.target||window.event.srcElement;

          var cellIndexNumber=parseInt(tab.cellIndex)+1;
          var rowIndexNumber=parseInt(tab.parentNode.rowIndex);

          // alert(rowIndexNumber);
          $('table tr, table td').removeClass('tab_hover_effect');

          $('tr td:nth-child('+cellIndexNumber+')').addClass('tab_hover_effect');
          $('table tbody tr:nth-child('+rowIndexNumber+')').addClass('tab_hover_effect');
        });

        $(document).on('click mouseover','tr th span.fa',function(e) {
          $('tr th span.fa span').hide();
          $(this).children('span').show();
          e.preventDefault();
          return false;
        });
        $('tr th span.fa').click(function(e) {e.preventDefault();return false;});//avoid asc toggling

        //Form handling plugin
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
      $("#datatable-buttons").css('width','100%');
 

});
})();

(function() {
  $(document).ready(function() {
    function upload(current) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#profileImg').attr('src',e.target.result);
      };
      reader.readAsDataURL(current.files[0]);
    }
  });

  //menu addclassShow
  $('.nav_div ul li a').hover(function() {
    // $('.nav_div ul li a').removeClass('menu_PaddingSlideShow');
    $(this).addClass('menu_PaddingSlideShow');
  },function() {
    MenuSlide_show();
  });
  MenuSlide_show();
  function MenuSlide_show() {
    $('.nav_div ul li a').removeClass('menu_PaddingSlideShow');
    var url=location.href;
    
    var split_url=url.split('?');
    var firstVal=split_url[0].split('/');
    var currentUrl=firstVal[firstVal.length-1];

    if (currentUrl=='add-info') {
      currentUrl='information';
    }if(currentUrl=='view-school-info'||currentUrl=='edit-school-info') {
      currentUrl='dashboard';
    }if (currentUrl=='teachers-edit-results') {
      currentUrl='teachers-upload';
    }if (currentUrl=='print-students') {
      currentUrl='students-view';
    }if (currentUrl=='print-teachers') {
      currentUrl='teachers-view';
    }
    $('.nav_div ul li a[href='+currentUrl+']').addClass('menu_PaddingSlideShow');
    
  }


    var windWidth = $(window).width();
    if (windWidth >= 800) {
      jQuery('.nav_div, .right').theiaStickySidebar({
        // Settings
        // additionalMarginTop: 30
      });      
    };
})();