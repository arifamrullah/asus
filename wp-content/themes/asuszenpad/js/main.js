jQuery(function($){
  $("#topItems").owlCarousel({
    // autoPlay: 3000,
    items : 5,
    itemsCustom : [
      [0, 1],
      [360, 1],
      [450, 1],
      [600, 2],
      [640, 3],
      [700, 3],
      [1024, 5],
      [1000, 5],
      [1200, 5],
      [1400, 5],
      [1600, 5]
    ],
    responsive: true,
    pagination: false,
    navigation: true,
    navigationText: [
        "<i class='glyphicon left-arrows'></i>",
        "<i class='glyphicon right-arrows'></i>"
    ]
  });

	// toggle filter
  $(".filter-button, .filter-btn").click(function () {
        if ($('.filter-box').is(':visible')) {
          $(".filter-box, .filter-opt").hide();
        } else {
          $(".filter-box, .filter-opt").show();
        }
      return false;
  });

  $(".close-filter").click(function () {
      $(".filter-box, .filter-opt").hide();
      return false;
  });

	// collapse top menu
	$('#menuCarousel').collapse();

	$('#asusTop').on('shown.bs.collapse', function () {
	  $('.menu-content').addClass('bordered');
    $('.black-button').addClass('active');
  });

  $('#asusTop').on('hidden.bs.collapse', function () {
    $('.menu-content').removeClass('bordered');
    $('.black-button').removeClass('active');
	});

	// filter search
	$(".filter-search input").keypress(function () {
	    // $('.filter-opt').slideToggle();
	});

  $('#myCarousel').carousel({
	   interval:   4000
  });

  $('#myCarousel').on('click', '.nav a', function() {
    $('#myCarousel .nav li').removeClass('active');
    $(this).parent().addClass('active');
  });

  $('.filter-mobile').on('click', '.filter-choose a', function() {
    $('.filter-mobile .filter-choose li').removeClass('choosen active');
    $(this).parent().addClass('choosen active');
  });

  // Carousel Auto-Cycle

  $('.filter-opt .col-md-8 a').click(function(){
      $(this).toggleClass('active');
  });

  $('.filter-opt .col-md-4 a').click(function(){
      $('.filter-opt .col-md-4 a').removeClass('active')
      $(this).addClass('active');
  });

  $('.filter-search input').focus(function(){
  	$('.close-filter').show();
  	$('.filter-opt').show();
  });

  $('.filter-box form').submit(function(e){
  	e.preventDefault();
  	return false;
  });

	$('#openSearch, #openSearchMob').click(function(){
		$('.search-box').toggle();
		$('.compare-box').hide();
	});

	 $('#openCompare, #openCompareMob').click(function(){
		$('.compare-box').toggle();
		$('.search-box').hide();
	});

	//CAROUSEL SOCIAL
	$(document).ready(function(){

		$('.bxslider').bxSlider({
			minSlides: 1,
			maxSlides: 6,
			slideWidth: $(document).width / 6
		});

    var $social_loader = $('<img src="'+ajax_object.base_url+'/images/bx_loader.gif" style="margin:90px 50%;" />');

    $('.social-filter a').click(function(){
      var dataType = $(this).data('social');
      $('.social-filter li').removeClass('active');
      $(this).parent().addClass('active');

			var data = {
				'action':'filter_social_feed',
				'data':{
					'type':dataType
				}
			};

      $('#carousel-social').empty();
      $('#carousel-social').append( $social_loader );

			jQuery.post(ajax_object.ajax_url, data, function(response) {
				$('#carousel-social').empty();
				$('#carousel-social').append(response);
				$('.bxslider').bxSlider({
					minSlides: 1,
					maxSlides: 6,
					slideWidth: $(document).width / 6
				});
			});
		});

	});

  $(window).resize(function() {
    var widthSocial = $('.social-item').width();
    $('.social-item').height(widthSocial);
  });

  // $('#main .col-md-3').height(heightCont);
  if ($(window).width() < 480) {
    var heightCont = $('#main a').width();
    $('#main .col-md-3').height(heightCont);
    $('#main .col-md-6').height(heightCont/2);
  };

  var cw = $('.li-slide, .li-noimage').width();
	$('.li-slide, .li-noimage').css({'height':cw+'px'});

  //MASONRY
  var $grid = $('.grid-content #main').masonry({
    // set itemSelector so .grid-sizer is not used in layout
    itemSelector: '.grid-list',
    // use element for option
    columnWidth: '.grid-sizer',
    percentPosition: true
  })

  $(window).resize(function () {
      $grid.masonry({
        // set itemSelector so .grid-sizer is not used in layout
        itemSelector: '.grid-list',
        // use element for option
        columnWidth: '.grid-sizer',
        percentPosition: true
      })
  });

  var page = 0;
  var $content = $("body #main");
  var minlength = 12;

  $('.load').on( 'click', function(e) {
    if( $(this).hasClass('enabled') ){
      e.preventDefault();
    } else {
      page++;
      var $items_loader = $('<a class="col-md-3 noPad grid-list news-img box text-center wrap-loader" style="background-color: transparent;min-height: 292px;"><img src="'+ajax_object.base_url+'/images/bx_loader.gif" style="height: auto;width: auto;min-height: auto;float: none;margin:48% 45%;" /></a>');

      $grid.append( $items_loader )
      .masonry( 'appended', $items_loader );

      jQuery.ajax({
          type : 'post',
          url : ajax_object.ajax_url,
          data : {
              action : 'loop_handler_mansonry',
              numPosts : minlength,
              pageNumber : page,
              load : 'true'
          },
          beforeSend: function() {
            $('a.load').addClass('enabled');
            if (page >= total_pages-1) {
              $('.load').hide();
              $('.end').show();
            };
          },
          success : function( response ) {
            $('a.load').removeClass('enabled');
              $grid.masonry( 'remove', $grid.find('a.grid-list:last-child') )
              // layout remaining item elements
              .masonry('layout');

              var $items = $(response);
              $grid.append( $items )
              .masonry( 'appended', $items );
          }
        });
      }
    return false;
  });

  $('.nav-pills li, .filter-mobile li').click(function () {
    page = 1;
    cat = $(this).attr('data-passion');
      jQuery.ajax({
          type : 'post',
          url : ajax_object.ajax_url,
          data : {
              action : 'loop_handler_mansonry',
              numPosts : minlength,
              pageNumber : page,
              category : cat
          },
          beforeSend: function() {
              $('.loader').toggle();
              $('.end, .load').hide();
              $grid.masonry( 'remove', $grid.find('.grid-list') );
              $grid.masonry();
          },
          success : function( response ) {
              $('.loader').toggle();
              $('.load').show();
              var $items = $(response);
              if ($items.length) {
                $grid.append( $items )
                .masonry( 'appended', $items );
              } else {
                $('.load').hide();
                $('.end').show();
              };
          }
      });
  });

  $('.filter-search input').keyup(function (e){
    var searchText = $(this).val();
    var selector = $('#filters .active').attr('data-filter');
    // var selector = [];
    // $("#filters .active").each(function(a,b) {
    //     selector.push( $(b).attr('data-filter') );
    // });
    // selector = selector.join(', ');
    var sort = $('#sorts a.active').attr('data-sort');
    if ( searchText.length >= minlength && e.which == 32 || e.which == 13 ){
      jQuery.ajax({
          type : 'post',
          url : ajax_object.ajax_url,
          data : {
              action : 'loop_handler_mansonry',
              numPosts : minlength,
              search : searchText,
              selector  : selector,
              sort_pop : sort
          },
          beforeSend: function() {
              $('.loader').show();
              $('.end, .load').hide();
              $grid.masonry( 'remove', $grid.find('.grid-list') );
              $grid.masonry();
          },
          success : function( response ) {
              $('.loader').hide();
              $('.load').show();
              var $items = $(response);
              if ($items.length) {
                $grid.append( $items )
                .masonry( 'appended', $items );
              } else {
                $('.load').hide();
                $('.end').show();
              };
          }
      });
    }
    return false;
  });

  var $optionLinks = $('#filters a');
  $optionLinks.click( function() {
    $('#filters a').removeClass('active');
    $(this).addClass('active');

    var selector = $(this).attr('data-filter');

    jQuery.ajax({
      type : 'post',
      url : ajax_object.ajax_url,
      data : {
        action : 'div_filter_result',
        hashtag : selector
      },
      beforeSend : function() {
        $('.filter-result').remove();
      },
      success : function( response ) {
        $('.loader').hide();
        $('.result-container').append(response);
      }
    });

    // var selector = [];
    // $("#filters .active").each(function(a,b) {
    //     selector.push( $(b).attr('data-filter') );
    // });
    // selector = selector.join(', ');

    var searchText = jQuery('.filter-search input').val();

    $('.end, .load').hide();
    $('.loader').show();
    $grid.masonry( 'remove', $grid.find('.grid-list') );
    $grid.masonry();

    setTimeout(function(){
      jQuery.ajax({
        type : 'post',
        url : ajax_object.ajax_url,
        data : {
          action : 'loop_handler_mansonry',
          numPosts : minlength,
          search : searchText,
          selector : selector
        },
        success : function( response ) {
          $('.load').show();
          $grid.masonry( 'remove', $grid.find('.grid-list') );
          $grid.masonry();
          var $items = $(response);
          if ($items.length) {
            $grid.append( $items )
            .masonry( 'appended', $items );
          } else {
            $('.load').hide();
            $('.end').show();
          };
        }
     });
    }, 1000 );
    return false;
  });

   $('#sorts a').click(function () {
     var sort = $(this).attr('data-sort');
     var searchText = jQuery('.filter-search input').val();
     var selector = $('#filters .active').attr('data-filter');
     // var selector = [];
     // $("#filters .active").each(function(a,b) {
     //     selector.push( $(b).attr('data-filter') );
     // });
     // selector = selector.join(', ');
     jQuery.ajax({
         type : 'post',
         url : ajax_object.ajax_url,
         data : {
             action : 'loop_handler_mansonry',
             numPosts : minlength,
             search : searchText,
             selector : selector,
             sort_pop : sort
         },
         beforeSend: function() {
             $('.loader').toggle();
             $('.end, .load').hide();
             $grid.masonry( 'remove', $grid.find('.grid-list') );
             $grid.masonry();
         },
         success : function( response ) {
             $('.loader').toggle();
             $('.load').show();
             var $items = $(response);
             if ($items.length) {
                $grid.append( $items )
                .masonry( 'appended', $items );
              } else {
                $('.load').hide();
                $('.end').show();
              };
         }
     });
     return false;
   });


  $("#menuCarousel").click(function(){
    if($(this).hasClass("active")){
      $(this).parent().removeClass("blueactive");
    }else{
      $(this).parent().addClass("blueactive");
    }
  });

  $('.menu-content .container').hover(
    function(){
      $('.left-arrows, .right-arrows').stop().animate({'opacity': '1'}, 'fast');
    },
    function(){
      $('.left-arrows, .right-arrows').stop().animate({'opacity': '0'}, 'fast');
    }
  );

  $(".jumper").on("click", function(e) {
    e.preventDefault();
    $("body, html").animate({ 
        scrollTop: $( $(this).attr('href') ).offset().top 
    }, 4000);
  });

  $(".stickyintel").length > 0 && $(window).scroll(function() {
    apifooter = $("#asus-api-footer").outerHeight();
    $("body").height() <= $(window).height() + $(window).scrollTop() + 100 ? ($(".stickyintel").addClass("bottom"), $(".stickyintel").css("bottom", apifooter + 5)) : ($(".stickyintel").removeClass("bottom"), $(".stickyintel").css("bottom", 80))
  });

});
