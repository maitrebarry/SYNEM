
    $(document).ready(function() {
        // Animation automatique des carousels de page
        $('#page-carousel').carousel({
            interval: 5000,
            pause: 'hover'
        });
        
        // Animation du texte au chargement
        $('.carousel-caption .animated').each(function(i) {
            $(this).delay(i * 300).animate({
                opacity: 1,
                marginTop: 0
            }, 800);
        });
        
        // Gestion du redimensionnement
        $(window).on('resize', function() {
            $('.carousel-item').height($(window).height() * 0.7);
        });
    });
