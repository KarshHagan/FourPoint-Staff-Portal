function parseQueryString( queryString ) {
    var params = {}, queries, temp, i, l;

    // Split into key/value pairs
    queries = queryString.split("&amp;");

    // Convert the array of strings into an object
    for ( i = 0, l = queries.length; i < l; i++ ) {
        temp = queries[i].split('=');
        params[temp[0]] = temp[1];
    }

    return params;
};

$(document).ready(function() {
  var windowWidth = $(window).width();

  //opening modal if profile_open is set to true on the query string.

  parseQueryString(window.location.search);
  request_vars = parseQueryString(window.location.search);
  alert(request_vars.profile_open);
  if( request_vars.profile_open == true ) {
    $(".alert-toggle").trigger('click');
  }

  $(".document-file").on('click',function() {
    tracker_url = '/wp-content/themes/staffportal/record_post_view.php';
    post_data = {
      document_id: $(this).data('documentid'),
      user_id: $(this).data('userid')
    }
    $.post(tracker_url,post_data,function(data) {
      console.log('tracked document view');
      if(data) {
        console.log(data);
      }
    });
  });

  //nav js
  var menu = $('#main_nav');
  var menuToggle = $('#mobile_menu');

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

  // staff portal bio cards = flip on click
  var $flipTrigger = $('.more-flip');
  $flipTrigger.on('click', function(e) {
    e.preventDefault();
    $(this).closest('.employee-bio').toggleClass('flip');
  });

  //homepage carousel
  $(".holiday-container").slick({
  dots: false,
  infinite: true,
  cssEase: 'easeInCubic',
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 3,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

  // alert Modal toggle
  $(".alert-toggle").on('click',function(evt) {
    var clickedId = this.id;
    $('body').css({
      'overflow': 'hidden',
      'position': 'fixed'
    });
    $('.'+ clickedId + '-modal').fadeToggle().find('.modal-panel').addClass('scale-in');
    last_id = $('.'+ clickedId + '-modal').data('last-id');
    tracker_url = '/wp-content/themes/staffportal/record_alert_view.php';
    post_data = {
      alert_id: last_id,
      user_id: $('.'+ clickedId + '-modal').data('userid')
    }
    $.post(tracker_url,post_data,function(data) {
      console.log('tracked alert view');
      if(data) {
        console.log(data);
      }
    });
    $(".alert-notification").hide();
  });

  $(".remove-alert").on('click',function() {
    alert_id = $(this).data('alertid');
    console.log("alert id"+alert_id);
    tracker_url = '/wp-content/themes/staffportal/record_alert_removed.php';
    post_data = {
      alert_id: alert_id,
      user_id: $(this).data('userid')
    }
    $.post(tracker_url,post_data,function(data) {
      console.log('tracked alert removed');
      if(data) {
        console.log(data);
      }
    });
    $(".alert-"+alert_id).hide();
  });

  $('.close-modal').on('click', function(evt) {
    var clickedId = this.id;
    $('.' + clickedId).fadeToggle('fast', function() {
      $('.modal-panel').removeClass('scale-in');
      $('body').css({
        'overflow': 'scroll',
        'position': 'static'
      });
    });
  });

  // back to top buttons
  $('.to-top').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: $('#top').offset().top
    }, 250);
  });

  // secondary nav items
  $('.second-link').on('click', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    $('html, body').animate({
      scrollTop: $(href).offset().top
    }, 250);
  });

  // STAFF PORTAL ACCORDIONS
  function accordionCollapse(windowWidth) {
    if(windowWidth <= 768) {
      $('.collapse-item-click').on('click', function() {
        $(this).next().slideToggle(250);
        $(this).find('.plus-minus').toggleClass('minus');
      });
    }
  }

  accordionCollapse(windowWidth);

  var employeeSort = new EmployeeSort();
  var ticketSort = new TicketSort();
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

// IT Ticket sorting
function TicketSort() {

  // All, Helpful, A/V guides buttons
  this.$ticketSelect = $('.it-btn');

  // Item to sort
  this.$ticket = $('.ticket');

  this.sortTickets();
}

TicketSort.prototype.sortTickets = function() {
  var _this = this;

  //attach event listener to buttons
  this.$ticketSelect.on('click', function(e) {
    e.preventDefault();

    // add active class to button
    $('.it-btn').removeClass('active');
    $(this).addClass('active');

    var selectedItemCategory = $(this).data('it-selected');

    _this.$ticket.each(function() {

      var ticketCategoryToDisplay = $(this).data('it-category');

      if(selectedItemCategory === 'all' || selectedItemCategory === ticketCategoryToDisplay) {
        $(this).fadeIn(250);
      } else {
        $(this).fadeOut(250);
      }
    });

  });
}
