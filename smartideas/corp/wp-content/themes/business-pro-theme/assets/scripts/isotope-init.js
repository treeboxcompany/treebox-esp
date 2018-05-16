jQuery(function($){
	$(window).load(function() {

		// Main function.
		function portfolioIsotope() {
			var $container = $('.portfolio-content');
			$container.isotope({
				itemSelector: '.portfolio-item',
				masonry: {
					itemSelector: ".portfolio-item",
					columnWidth: ".portfolio-item",
					gutter: 20
				}
			});
		} portfolioIsotope();

		// Filter.
		$('.filter a').click(function(){
		  var selector = $(this).attr('data-filter');
			$('.portfolio-content').isotope({ filter: selector });
			$(this).parent().find('a').removeClass('active');
			$(this).addClass('active');
		  return false;
		});

		// Resize.
		var isIE8 = $.browser.msie && +$.browser.version === 8;
		if (isIE8) {
			document.body.onresize = function () {
				portfolioIsotope();
			};
		} else {
			$(window).resize(function () {
				portfolioIsotope();
			});
		}

		// Orientation change.
		window.addEventListener("orientationchange", function() {
			portfolioIsotope();
		});
	});
});