(function ($) {
    "use strict";

    $(document).ready(function () {

        // ── data-bg → background-image (domain cards) ────────────────
        document.querySelectorAll('[data-bg]').forEach(function (el) {
            el.style.backgroundImage = 'url(' + el.getAttribute('data-bg') + ')';
        });

        // ── Navbar scroll effect ──────────────────────────────────────
        var $nav = $('#mainNav');
        function updateNav() {
            if ($nav.length === 0) return;
            if ($(window).scrollTop() > 80) {
                $nav.addClass('scrolled');
            } else {
                $nav.removeClass('scrolled');
            }
        }
        $(window).on('scroll', updateNav);
        updateNav();

        // ── Dropdown hover (desktop only) ─────────────────────────────
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);

        // ── Date and time picker ──────────────────────────────────────
        if ($.fn.datetimepicker) {
            $('.date').datetimepicker({ format: 'L' });
            $('.time').datetimepicker({ format: 'LT' });
        }

        // ── Back to top ───────────────────────────────────────────────
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.back-to-top').fadeIn('slow');
            } else {
                $('.back-to-top').fadeOut('slow');
            }
        });
        $('.back-to-top').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
            return false;
        });

        // ── Animated counters (IntersectionObserver) ──────────────────
        var countersTriggered = false;
        function animateCounter(el) {
            var $el = $(el);
            var target = parseInt($el.data('target'), 10);
            if (isNaN(target)) return;
            var duration = 2000;
            var start = 0;
            var increment = target / (duration / 16);
            var timer = setInterval(function () {
                start += increment;
                if (start >= target) {
                    start = target;
                    clearInterval(timer);
                }
                $el.text(Math.floor(start).toLocaleString('fr-FR'));
            }, 16);
        }

        if ('IntersectionObserver' in window) {
            var statsSection = document.querySelector('.stats-section');
            if (statsSection) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting && !countersTriggered) {
                            countersTriggered = true;
                            document.querySelectorAll('.counter-number').forEach(function (el) {
                                animateCounter(el);
                            });
                        }
                    });
                }, { threshold: 0.3 });
                observer.observe(statsSection);
            }
        } else {
            // Fallback for older browsers
            $(window).one('scroll.counter', function () {
                $('.counter-number').each(function () { animateCounter(this); });
            });
        }

        // ── Team carousel ─────────────────────────────────────────────
        if ($.fn.owlCarousel) {
            $(".team-carousel, .related-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                center: true,
                margin: 30,
                dots: false,
                loop: true,
                nav: true,
                navText: [
                    '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                    '<i class="fa fa-angle-right" aria-hidden="true"></i>'
                ],
                responsive: { 0: { items: 1 }, 576: { items: 1 }, 768: { items: 2 }, 992: { items: 3 } }
            });

            $(".testimonial-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1500,
                margin: 30,
                dots: true,
                loop: true,
                center: true,
                responsive: { 0: { items: 1 }, 576: { items: 1 }, 768: { items: 2 }, 992: { items: 3 } }
            });

            $('.vendor-carousel').owlCarousel({
                loop: true,
                margin: 30,
                dots: true,
                center: true,
                autoplay: true,
                smartSpeed: 1000,
                responsive: { 0: { items: 2 }, 576: { items: 3 }, 768: { items: 4 }, 992: { items: 5 }, 1200: { items: 6 } }
            });
        }

    });

})(jQuery);
