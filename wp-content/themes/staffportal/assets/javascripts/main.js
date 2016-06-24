
$(document).ready(function() {

  // Home page slider init
  $('.hero-slider').slick({
    dots: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000
  });

  // Holiday Slider init
  $('.holiday-container').slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 3,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 650,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  var win = $(window);

  // change slider images depending on screen sizes
  var windowWidth = win.width();

  var changeSliderImages = function(windowWidth) {
    var $slidesMobile = $('.the-slide-mobile');
    var $slideDesktop = $('.the-slide');

    $slidesMobile.each(function(index, el) {
      if(windowWidth <= 800) {
        $(el).css({
          'background-image': 'url(' + $(el).data('img-sm') + ')'
        });
      }
    });

    $slideDesktop.each(function(index, el) {
      if(windowWidth >= 801) {
        $(el).attr('src', $(el).data('img-lg'));
      }
    });

    setTimeout(function() {
      $('#page-loader').fadeOut(300).addClass('gone');
    }, 300);
    
  };

  changeSliderImages(windowWidth);

  // failsafe
  if($('#page-loader').hasClass('gone')) {
    setTimeout(function() {
      $('#page-loader').remove();
    }, 700);
  }

  //init fancybox
  $(".fancybox").fancybox({
      padding: 0,
      prevEffect: 'none',
      nextEffect: 'none',
      helpers: {
        title: {
          type: 'outside'
        },
        media: {},
        thumbs: {
          width: 80,
          height: 50
        }
      }
    });


  // staff portal anchor links - set width
  var $links = $('.anchor-links li');
  var linksLength = $links.length;
  var widthOfLink = 100 / linksLength;
  
  function linkWidth(windowWidth) {
    if(windowWidth >= 1024) {
      $links.each(function() {
        $(this).width(widthOfLink + '%');
      });
    } else if(windowWidth <= 1023 && windowWidth >= 768) {
      $links.each(function() {
        $(this).width(50 + '%');
      });
    } else {
      $links.each(function() {
        $(this).width(100 + '%');
      });
    }
  }

  linkWidth(windowWidth);


  win.on('resize', function(windowWidth) {
    windowWidth = $(window).width();
    changeSliderImages(windowWidth);
    linkWidth(windowWidth);
  });

  document.getElementById('alert-toggle').addEventListener('click', function() {
    $('body').css('overflow-Y', 'hidden');
    $('.alert-modal').fadeToggle(200);
    $('.alert-list-panel').addClass('scale-in');
  });

  $('.close-alert').on('click', function() {
    $('.alert-modal').fadeToggle('fast', function() {
      $('.alert-list-panel').removeClass('scale-in');
      $('body').css('overflow-Y', 'scroll');
    });
  });



  // STAFF PORTAL ACCORDIONS
  // var collapseItems = document.getElementsByClassName('collapse-item-click');
  // for(var i = 0; i < collapseItems.length; i++) {
  //   collapseItems[i].addEventListener('click', function(e) {
  //     e.preventDefault();
  //     this.nextElementSibling.classList.toggle('show');
  //   });
  // }
    function accordionCollapse(windowWidth) {
      if(windowWidth <= 768) {
        $('.collapse-item-click').on('click', function() {
          console.log($(this))
          $(this).next().slideToggle(250);
        });
      }
    }

    accordionCollapse(windowWidth);

  // HOVER ANIMATION TRICKS

  var allMods = $("#flipper li");

  // allMods.each(function(i, el) {
  //   var el = $(el);
  //   if (el.visible(true)) {
  //     el.addClass("already-visible");
  //   }
  // });

  win.scroll(function(event) {

    allMods.each(function(i, el) {
      var el = $(el);
      if(Modernizr.touch) {
        el.addClass("come-in");
      } else {
        if (el.visible(true)) {
          el.addClass("come-in");
        }
      }
    });

  });

  //click handler for login modal close button
  $(".login-modal .close-modal").click(close_login_modal);

  function open_login_modal(evt) {
    if(evt) evt.preventDefault();
    modal_class = $(this).attr("rel");
    $(".login-modal."+modal_class).addClass("open");
  }

  function close_login_modal(evt) {
    if(evt) evt.preventDefault();
    $(".login-modal").removeClass("open");
  }

  $(".open-login").click(open_login_modal);

  // disable scrolling of google map embed on contact page, then re-enable on click
  $('.google-map iframe').addClass('scrolloff');

  $('.google-map').on('mousedown', function() {
    $(this).children('iframe').removeClass('scrolloff');
  });

  // Trigger Investors login modal
  // var loginModal = document.getElementById('login-modal');
  // document.getElementsByClassName('investors-link')[0].addEventListener('click', function() {
  //   loginModal.style.display = 'block';
  // });

  // // Close login modal
  // var closeBtn = document.querySelector('.close-modal');
  // closeBtn.addEventListener('click', function() {
  //   loginModal.style.display = 'none';
  // });

  $('#js-mobile-search-icon').on('click', function() {
    $('.secondary_search_wrap').slideToggle(250);
  });
  
  //nav js
  var menu = $('#main_nav');
  var menuToggle = $('#mobile_menu');
  var navWrap = $('nav');
  var moreLink = $('.menu-item-has-children');
  var subMenu = $('.sub-menu');
  var subMenuExpanded = $('.show_submenu');

  $(menuToggle).on('click', function(e) {
    e.preventDefault();
    menu.slideToggle(function(){
      if(menu.is(':hidden')) {
        menu.removeAttr('style');
      } else {
        menu.css('overflow', 'hidden');
      }
    });
  });

  $(window).on('resize', function() {
    if($(this).width() >= 1024) {
      menu.removeAttr('style');
    }
  });

  $(moreLink).on('click', function(evt) {
    var self = $(this).find(subMenu);
        currentOpen = navWrap.find(subMenuExpanded);

    // if nothing is open, open clicked, slide down nav
    if (!navWrap.hasClass('expand_down')) {
      self.toggleClass('show_submenu').prev().toggleClass('active');
      navWrap.toggleClass('expand_down');
    }

    // close the opened one if it's clicked while open
    else if (self.hasClass('show_submenu')) {
      self.toggleClass('show_submenu').prev().toggleClass('active');
      navWrap.toggleClass('expand_down');
    }

    // if one is open, then you click another one, close current and open new one.
    else if (navWrap.hasClass('expand_down') && $('.sub-menu').hasClass('show_submenu'))  {

      // close everything
      $('.sub-menu').removeClass('show_submenu').prev().removeClass('active');
      currentOpen.removeClass('show_submenu');
      self.removeClass('show_submenu');
      navWrap.removeClass('expand_down');

      // open everything
      currentOpen.addClass('show_submenu');
      self.addClass('show_submenu').prev().addClass('active');
      navWrap.addClass('expand_down');
    }
  });

  // underline under the active nav item
  $(".nav .nav-link").click(function() {
    $(".nav .nav-link").each(function() {
      $(this).removeClass("active-nav-item");
    });
    $(this).addClass("active-nav-item");
    $(".nav .more").removeClass("active-nav-item");
  });


  // staff portal bio cards = flip on click
  var $employeeCard = $('.employee-bio');
  $employeeCard.on('click', function() {
    $(this).toggleClass('flip');
  });

  var employeeSort = new EmployeeSort();

});


// sorting for the company directory
function EmployeeSort() {

  // button for office sort
  this.$officeSelect = $('.office-btn');

  // button for name sort
  this.$nameSelect = $('.name-btn');

  // item to hide/show
  this.$sortItem = $('.employee-bio-container');
  
  this.sortByOffice();
  this.sortByName();
}

// sort by office
EmployeeSort.prototype.sortByOffice = function() {
  var _this = this;

  this.$officeSelect.on('click', function(e) {
    e.preventDefault();

    // switch active class to selected button to make blue
    $('.office-btn').removeClass('active');
    $(this).addClass('active');

    // the name button current active
    var nameItemActive = $('.name-sort').data('active-name');

    var selectedOffice = $(this).data('office-selected');

    // loop through cards
    _this.$sortItem.each(function() {

        // the name button current active
        var itemOffice = $(this).data('office');

        // if selected office (button) matches item's office and selected name (button) matches item's name OR selected office (button) matches item's office and selected name (button) is all, fade in
        if(selectedOffice == itemOffice && nameItemActive == $(this).data('name') || selectedOffice == itemOffice && nameItemActive == 'all') {
            $(this).addClass('card-visible').removeClass('card-hidden');

        // if office is all and name is all, fade everything in.
        } else if(selectedOffice == 'all' && nameItemActive == 'all') {
            $(this).addClass('card-visible').removeClass('card-hidden');

        // if office is all and chosen name is same as active name (button)
        } else if(selectedOffice == 'all' && nameItemActive == $(this).data('name')) {
            $(this).addClass('card-visible').removeClass('card-hidden');
        } else {
            $(this).removeClass('card-visible').addClass('card-hidden');
        }

    });

     // assign selected office to container element
    $('.office-sort').data('active-office', selectedOffice);

  });
};

EmployeeSort.prototype.sortByName = function() {
    var _this = this;

    this.$nameSelect.on('click', function(e) {
        e.preventDefault();

        // switch active class to selected button to make blue
        $('.name-btn').removeClass('active');
        $(this).addClass('active');

        // the office button current active
        var officeItemActive = $('.office-sort').data('active-office');

        // get the name clicked item
        var selectedName = $(this).data('name-selected');

        // loop through names
        _this.$sortItem.each(function() {

            // name of card
            var itemName = $(this).data('name');

            // name of office, selected card
            var officeName = $(this).data('office');

            // if selected name matches name of card and office matches chosen office
            if(selectedName == itemName && officeItemActive == officeName || selectedName == itemName && officeItemActive == 'all' ) {
                $(this).addClass('card-visible').removeClass('card-hidden');
            }
            else if(selectedName == 'all' && officeItemActive == 'all') {
                $(this).addClass('card-visible').removeClass('card-hidden');
            }

            // if selected name is all and office matches chosen office
            else if(selectedName == 'all' && officeItemActive == officeName) {
                $(this).addClass('card-visible').removeClass('card-hidden');
            } 

            // if nothing matches, fade out those items
            else {
                $(this).addClass('card-hidden').removeClass('card-visible');
            }
        });

        // assign selected name to container element
        $('.name-sort').data('active-name', selectedName);

    });
};