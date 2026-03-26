(function ($) {
    "use strict";
	
	var $window = $(window); 
	var $body = $('body'); 
	
	/* Preloader Effect */
	$window.on('load', function(){
		setHeaderHeight();
		$(".preloader").fadeOut(800);
	});

	/* Sticky Header */
	$window.on('resize', function(){
		setHeaderHeight();
	});

	function setHeaderHeight(){
		$("header.main-header").css("height", $('header .header-sticky').outerHeight());
	}	
	
	$(window).on("scroll", function() {
		var fromTop = $(window).scrollTop();
		setHeaderHeight();
		var headerHeight = $('header .header-sticky').outerHeight()
		$("header .header-sticky").toggleClass("hide", (fromTop > headerHeight + 100));
		$("header .header-sticky").toggleClass("active", (fromTop > 600));

		$(".footer-btn").toggleClass("active", (fromTop > 600));
	});

	/* Slick Menu JS */
	$('#menu').slicknav({
		label : '',
		prependTo : '.responsive-menu'
	});

	/* Testimonial Carousel JS */
	if ($('.testimonial-slider').length) {
		var swiper = new Swiper(".testimonial-slider", {
			slidesPerView: 1,
			spaceBetween: 20,
			autoplay: true,
			loop: true,
			speed: 750,
			pagination: {
				el: ".swiper-pagination",
				clickable: true,
			},
			breakpoints: {
				768: {
					slidesPerView: 3,
					spaceBetween: 20,
				},
				991: {
					slidesPerView: 4,
					spaceBetween: 30,
				},
			},
		});
	}

	/* Popup Video */
	if ($('.popup-video').length) {
		$('.popup-video').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	}

	/* Init Counter */
	if ($('.counter').length) {
		$('.counter').counterUp({ delay: 6, time: 5000 });
	}

	/* Image Reveal Animation */
	if ($('.reveal').length) {
        gsap.registerPlugin(ScrollTrigger);
        let revealContainers = document.querySelectorAll(".reveal");
        revealContainers.forEach((container) => {
            let image = container.querySelector("img");
            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: container,
                    toggleActions: "play none none none"
                }
            });
            tl.set(container, {
                autoAlpha: 1
            });
            tl.from(container, 1, {
                xPercent: -100,
                ease: Power2.out
            });
            tl.from(image, 1, {
                xPercent: 100,
                scale: 1,
                delay: -1,
                ease: Power2.out
            });
        });
    }

	/* Text Effect Animation */
	if ($('.text-anime').length) {
		const animatedElements = document.querySelectorAll(".text-anime");

		animatedElements.forEach((element) => {
		let staggerAmount = 0.05;
		let translateXValue = 20;
		let translateYValue = false;
		let onScrollValue = 1;
		let delayValue = 0.5;
		let easeType = "power2.out";

		if (element.getAttribute("data-stagger")) {
			staggerAmount = element.getAttribute("data-stagger");
		}

		if (element.getAttribute("data-translateX")) {
			translateXValue = element.getAttribute("data-translateX");
		}

		if (element.getAttribute("data-translateY")) {
			translateYValue = element.getAttribute("data-translateY");
		}

		if (element.getAttribute("data-on-scroll")) {
			onScrollValue = element.getAttribute("data-on-scroll");
		}

		if (element.getAttribute("data-delay")) {
			delayValue = element.getAttribute("data-delay");
		}

		if (element.getAttribute("data-ease")) {
			easeType = element.getAttribute("data-ease");
		}

		if (onScrollValue == 1) {
			if (translateXValue > 0 && !translateYValue) {
			let splitText = new SplitType(element, { type: "chars, words" });
				gsap.from(splitText.chars, {
					duration: 1,
					delay: delayValue,
					x: translateXValue,
					autoAlpha: 0,
					stagger: staggerAmount,
					ease: easeType,
					scrollTrigger: { trigger: element, start: "top 85%"},
				});
			}

			if (translateYValue > 0 && !translateXValue) {
			let splitText = new SplitType(element, { type: "chars, words" });
			gsap.from(splitText.chars, {
				duration: 1,
				delay: delayValue,
				y: translateYValue,
				autoAlpha: 0,
				ease: easeType,
				stagger: staggerAmount,
				scrollTrigger: { trigger: element, start: "top 85%" },
			});
			}

			if (translateXValue && translateYValue) {
			let splitText = new SplitType(element, { type: "chars, words" });
			gsap.from(splitText.chars, {
				duration: 3,
				delay: delayValue,
				y: translateYValue,
				x: translateXValue,
				autoAlpha: 0,
				ease: easeType,
				stagger: staggerAmount,
				scrollTrigger: { trigger: element, start: "top 85%" },
			});
			}

			if (!translateXValue && !translateYValue) {
				let splitText = new SplitType(element, { type: "chars, words" });
				gsap.from(splitText.chars, {
					duration: 1,
					delay: delayValue,
					x: 50,
					autoAlpha: 0,
					stagger: staggerAmount,
					ease: easeType,
					scrollTrigger: { trigger: element, start: "top 85%" },
				});
			}
			} else {
				if (translateXValue > 0 && !translateYValue) {
				let splitText = new SplitType(element, { type: "chars, words" });
				gsap.from(splitText.chars, {
					duration: 1,
					delay: delayValue,
					x: translateXValue,
					ease: easeType,
					autoAlpha: 0,
					stagger: staggerAmount,
				});
				}

				if (translateYValue > 0 && !translateXValue) {
				let splitText = new SplitType(element, { type: "chars, words" });
				gsap.from(splitText.chars, {
					duration: 1,
					delay: delayValue,
					y: translateYValue,
					autoAlpha: 0,
					ease: easeType,
					stagger: staggerAmount,
				});
				}

				if (translateXValue && translateYValue) {
				let splitText = new SplitType(element, { type: "chars, words" });
				gsap.from(splitText.chars, {
					duration: 1,
					delay: delayValue,
					y: translateYValue,
					x: translateXValue,
					ease: easeType,
					autoAlpha: 0,
					stagger: staggerAmount,
				});
				}

				if (!translateXValue && !translateYValue) {
				let splitText = new SplitType(element, { type: "chars, words" });
				gsap.from(splitText.chars, {
					duration: 1,
					delay: delayValue,
					ease: easeType,
					x: 50,
					autoAlpha: 0,
					stagger: staggerAmount,
				});
				}
			}
		});
	}

	/* Parallaxie js */
	var $parallaxie = $('.parallaxie');
	if($parallaxie.length)
	{
		if ($window.width() > 768) {
			$parallaxie.parallaxie({
				speed: 0.55,
				offset: 0,
			});
		}
	}

	/* Contact form validation */
	var $contactform=$("#contactForm");
	$contactform.validator({focus: false}).on("submit", function (event) {
		if (!event.isDefaultPrevented()) {
			event.preventDefault();
			submitForm();
		}
	});

	function submitForm(){
		/* Initiate Variables With Form Content*/
		var name = $("#name").val();
		var email = $("#email").val();
		var phone = $("#phone").val();
		var subject = $("#subject").val();
		var message = $("#msg").val();

		$.ajax({
			type: "POST",
			url: "form-process.php",
			data: "name=" + name + "&email=" + email + "&phone=" + phone + "&subject=" + subject + "&message=" + message,
			success : function(text){
				if (text == "success"){
					formSuccess();
				} else {
					submitMSG(false,text);
				}
			}
		});
	}

	function formSuccess(){
		$contactform[0].reset();
		submitMSG(true, "Message Sent Successfully!")
	}

	function submitMSG(valid, msg){
		if(valid){
			var msgClasses = "h3 text-success";
		} else {
			var msgClasses = "h3 text-danger";
		}
		$("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
	}
	/* Contact form validation end */

	/* Animated Wow Js */	
	new WOW().init();
	
})(jQuery);