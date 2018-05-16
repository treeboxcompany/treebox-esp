
$(document).ready(function() {

  var w = $( window ).width();
  var h = $( window ).height();

  $('nav .menu-item-object-custom a').click(function(e){

      e.preventDefault();
      var target_offset = $(this.hash).offset() ? $(this.hash).offset().top : 0;
      console.log(target_offset);
      var customoffset = 40;
      if(target_offset > 0) {
        $('html, body').animate({scrollTop:target_offset - customoffset}, 750);
      }else{
        window.location.href = '/treebox' + $(this).attr('href');
      }
      // if ( w < 768 ){
        $('.menu-main-menu-container ul').slideToggle();
        $(".cmn-toggle-switch").toggleClass("active");
      // }
  });

  $(".cmn-toggle-switch").click(function(t) {
    t.preventDefault();
    $(this).toggleClass("active");
    if($(this).hasClass('active')){
      $('.menu-main-menu-container ul').slideToggle( 600, function() {});
      $('header nav .lang').slideToggle();

    }else{
      $('header nav .lang').fadeToggle(300, function(){});
      $('.menu-main-menu-container ul').slideToggle();
    }
  });

  var servicesContainer = $('.services-carousel');
  var teamContainer = $('.team-expanded');

  var slider = servicesContainer.bxSlider({
    auto: true
  });

  var slider2 = teamContainer.bxSlider({
    auto: true
  });

  if(servicesContainer.length  || teamContainer.length ){
    slider.destroySlider();
    slider2.destroySlider();
  }

  if ( w < 768 ){
    slider.reloadSlider();
    slider2.reloadSlider();
  }

  $( window ).resize(function() {
    var w = $( window ).width();
    if ( w < 768 ){
      slider.reloadSlider();
      slider2.reloadSlider();
      var h = $( window ).height();
    }else{
      slider.destroySlider();
      slider2.destroySlider();
      $('.services-carousel li, .services-carousel, .team-expanded, .team-expanded li').removeAttr( "style" );
    }
  });

  $('.testimonials-carousel').bxSlider({
    auto: true
  });

  $(".team .more-button").click(function(t) {
    t.preventDefault();
    $(".hidden-content").slideToggle();
    var w = $( window ).width();
    if(teamContainer.length && w < 768){
      slider2.reloadSlider();
    }else{
      slider2.destroySlider();
      $('.services-carousel li, .services-carousel, .team-expanded, .team-expanded li').removeAttr( "style" );
    }
  });

});
