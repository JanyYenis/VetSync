/* ========================================
   VetSync - General Scripts
   ======================================== */

let clientesChart, mascotasChart;

$(document).ready(function() {
    'use strict';

    // ==========================================
    // Initialize Application
    // ==========================================
    initSidebar();

    // ==========================================
    // Sidebar Functions
    // ==========================================
    function initSidebar() {
        // Toggle sidebar on mobile
        $('#sidebarToggle').on('click', function() {
            $('#sidebar').toggleClass('show');
            $('body').toggleClass('sidebar-open');

            // Add overlay
            if ($('#sidebar').hasClass('show')) {
                $('body').append('<div class="sidebar-overlay show" id="sidebarOverlay"></div>');
                $('#sidebarOverlay').on('click', function() {
                    $('#sidebar').removeClass('show');
                    $('body').removeClass('sidebar-open');
                    $(this).remove();
                });
            } else {
                $('#sidebarOverlay').remove();
            }
        });

        $('#sidebarClose').on('click', function() {
            $('#sidebar').removeClass('show');
            $('body').removeClass('sidebar-open');
            $('#sidebarOverlay').remove();
        });

        // Logout
        $('#logoutBtn').on('click', function(e) {
            e.preventDefault();
            sessionStorage.removeItem('vetcare_logged_in');
            sessionStorage.removeItem('vetcare_user');
            window.location.href = 'login.html';
        });
    }
});
