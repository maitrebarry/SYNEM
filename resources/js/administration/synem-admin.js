// Initialisation SYNEM Admin
document.addEventListener('DOMContentLoaded', function() {
    console.log('SYNEM Admin initialisé');
    
    // Initialisation MetisMenu
    if (typeof MetisMenu !== 'undefined') {
        new MetisMenu('#menu');
    }
    
    // Gestion du menu mobile
    const mobileToggle = document.querySelector('.mobile-toggle-menu');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            document.body.classList.toggle('mobile-menu-active');
        });
    }
    
    // Fermer les dropdowns en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.matches('.dropdown-toggle') && !e.target.closest('.dropdown-menu')) {
            const openDropdowns = document.querySelectorAll('.dropdown.show');
            openDropdowns.forEach(function(dropdown) {
                dropdown.classList.remove('show');
            });
        }
    });
});

// Initialisation Bootstrap
$(document).ready(function() {
    // Dropdowns Bootstrap
    $('.dropdown-toggle').dropdown();
    
    // Tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Perfect Scrollbar pour sidebar
    if (typeof PerfectScrollbar !== 'undefined') {
        const sidebar = document.querySelector('.sidebar-wrapper');
        if (sidebar) {
            new PerfectScrollbar(sidebar);
        }
    }
});