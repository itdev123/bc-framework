$(document).ready(function () {

// Add padding to <main> to compensate for sticky header
    var headerHeight = $('#header').outerHeight();
    $('#main').css('margin-top', headerHeight);
});

$(window).on('load', function() {
  // Sets the correct height of the iframe on preview page
  var windowWidthUser = $(window).width();
  var windowHeightUser = $(window).height();

  if(windowWidthUser < 992 && windowWidthUser > 768)
   {

     windowHeightUser = windowHeightUser - 395;
     $('.section_preview_content-2').css('height', windowHeightUser);
   }
  else if(windowWidthUser < 768)
    {

      windowHeightUser = windowHeightUser - 386;
      $('.section_preview_content-2').css('height', windowHeightUser);
    }else{

      windowHeightUser = windowHeightUser - 373;
      $('.section_preview_content-2').css('height', windowHeightUser);
    }

});

//Special footer for iframe
  var loc = window.location.href; // returns the full URL
  if(/preview/.test(loc)) {
    $('footer').addClass('footer-iframe');
  }


//Preview page btns that change iframe width
$("#btn-iframe-mobile").click(
    function () {
        $(".section_preview_content-2 iframe").css({"width": "480px"});
        $("#btn-iframe-mobile").addClass('active');
        $("#btn-iframe-tablet").removeClass('active');
        $("#btn-iframe-desktop").removeClass('active');
    },
);

$("#btn-iframe-tablet").click(
    function () {
        $(".section_preview_content-2 iframe").css({"width": "1024px"});
        $("#btn-iframe-mobile").removeClass('active');
        $("#btn-iframe-tablet").addClass('active');
        $("#btn-iframe-desktop").removeClass('active');
    },
);

$("#btn-iframe-desktop").click(
    function () {
        $(".section_preview_content-2 iframe").css({"width": "100%"});
        $("#btn-iframe-mobile").removeClass('active');
        $("#btn-iframe-tablet").removeClass('active');
        $("#btn-iframe-desktop").addClass('active');
    },
);


$("#corner-peeler").hover(
    function () {
        $(this).removeClass('out').addClass('over');
        $("#curl").removeClass('out').addClass('over');
    },
    function () {
        $(this).removeClass('over').addClass('out');
        $("#curl").removeClass('over').addClass('out');
    }
);

$(window).on('resize', function(){
  // Sets the correct height of the iframe on preview page
  var windowWidthUser = $(window).width();
  var windowHeightUser = $(window).height();

  if(windowWidthUser < 992 && windowWidthUser > 768)
   {

     windowHeightUser = windowHeightUser - 395;
     $('.section_preview_content-2').css('height', windowHeightUser);
   }
  else if(windowWidthUser < 768)
    {

      windowHeightUser = windowHeightUser - 386;
      $('.section_preview_content-2').css('height', windowHeightUser);
    }else{

      windowHeightUser = windowHeightUser - 373;
      $('.section_preview_content-2').css('height', windowHeightUser);
    }


  // Add padding to <main> to compensate for sticky header
  var headerHeight = $('#header').outerHeight();
  $('#main').css('margin-top', headerHeight);
});

// Switch Template
$(".template-thumbs > input").change(function() { if(this.checked) { this.form.submit();  } });

/* attach a submit handler to the form */
$("#form-templates").submit(function(event) {

  /* stop form from submitting normally */
  event.preventDefault();

  /* get the action attribute from the <form action=""> element */
  var $form = $( this ),
      url = $form.attr( 'action' );

  /* Send the data using post with element id name and name2*/
  var posting = $.post( url, { Template1: $('#thumb1').val(), Template2: $('#thumb2').val(), Template3: $('#thumb3').val(), Template4: $('#thumb4').val() } );

  /* Alerts the results */
  posting.done(function( data ) {
    alert('success');
  });
});

// Domain Validation for input field


//    $('#start-domain').click(function() {
//        var d = $('#web_address').val();
//
//        if(!/^[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9](?:\.[a-zA-Z]{1,})+$/.test(d))
//            {
//              $("#web_address").val("INVALID DOMAIN, PLEASE TYPE IT HERE AGAIN");
//
//              $("#web_address").css("border-width", "2px");
//              $("#web_address").css("border-style", "solid");
//              $("#web_address").css("border-color", "red");
//              $("#web_address").css("background-color", "#fff1f1");
//              $("#web_address").val("INVALID DOMAIN, PLEASE TYPE IT HERE AGAIN");
//
//
//                return false;
//            }
//
//        $('#contentajax').empty()
//                         .css("border", "1px solid #CCCCCC")
//                         .html('<p class="vent">Please wait...</p><p class="venter"><img src="../images/ajax.gif" /></p>');
//        $.ajax({
//            type: 'POST',
//            url: 'http://localhost:3000/domain',
//            data: {
//                domain: doma
//            },
//            success: function(msg){
//                $('#contentajax').html(msg);
//                $('#contentajax').css("border", "none");
//            }
//        });
//    });


// END Domain Validation for input field
//$('.digi-preloader').hide();
//});
