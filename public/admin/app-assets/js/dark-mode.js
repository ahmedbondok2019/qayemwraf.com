(function toggleTheme() {

    var link = document.getElementById("theme");
    if (localStorage.getItem('dark-layout') === 'true') {
        document.html = 'dark';
        link.href = link.href.includes('light-layout') ? 'https://stage.carole-clinic.com/admin/app-assets/dark-mode.css' : 'https://stage.carole-clinic.com/admin/app-assets/light-layout.css';
        $('#toggle').attr('checked', true);
    }
    var $toggleButton = $('.dark-btn');
    // var $body = $('body');
    var $html = $('html')
    function toggleDarkMode() {
        if (!$html.hasClass('dark-layout')) {
            $html.addClass('dark-layout');
            localStorage.setItem('dark-layout', 'true');
            link.href = link.href.includes('dark-layout') ? 'https://stage.carole-clinic.com/admin/app-assets/dark-mode.css' : 'https://stage.carole-clinic.com/admin/app-assets/light-layout.css';
            $('#toggle').attr('checked', true);
        } else {
            $('#toggle').attr('checked', true);
            $html.removeClass('dark-layout');
            localStorage.removeItem('dark-layout');
            link.href = link.href.includes('light-layout') ? 'https://stage.carole-clinic.com/admin/app-assets/dark-mode.css' : 'https://stage.carole-clinic.com/admin/app-assets/light-layout.css';
        }
    }
    $toggleButton.on('click', toggleDarkMode);
})();
