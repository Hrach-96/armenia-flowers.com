
jQuery(document).ready(function($) {
    // Tabs
    $('body:not(.su-shortcodes-loaded)').on('click', '#productdetailsview.quick .su-tabs-nav span', function(e) {
        var $tab = $(this),
            data = $tab.data(),
            index = $tab.index(),
            is_disabled = $tab.hasClass('su-tabs-disabled'),
            $tabs = $tab.parent('.su-tabs-nav').children('span'),
            $panes = $tab.parents('.su-tabs').find('.su-tabs-pane'),
            $gmaps = $panes.eq(index).find('.su-gmap:not(.su-gmap-reloaded)');
        // Check tab is not disabled
        if (is_disabled) return false;
        // Hide all panes, show selected pane
        $panes.hide().eq(index).show();
        // Disable all tabs, enable selected tab
        $tabs.removeClass('su-tabs-current').eq(index).addClass('su-tabs-current');
        // Reload gmaps
        if ($gmaps.length > 0) $gmaps.each(function() {
            var $iframe = $(this).find('iframe:first');
            $(this).addClass('su-gmap-reloaded');
            $iframe.attr('src', $iframe.attr('src'));
        });
        // Set height for vertical tabs
        tabs_height();

        // Open specified url
        if (data.url !== '') {
            if (data.target === 'self') window.location = data.url;
            else if (data.target === 'blank') window.open(data.url);
        }        
        e.preventDefault();
    });

    // Activate tabs
    $('#productdetailsview.quick .su-tabs').each(function() {
        var active = parseInt($(this).data('active')) - 1;
        $(this).children('.su-tabs-nav').children('span').eq(active).trigger('click');
        tabs_height();
    });

    // Activate anchor nav for tabs and spoilers
    anchor_nav();

    function tabs_height() {
        $('#productdetailsview.quick .su-tabs-vertical').each(function() {
            var $tabs = $(this),
                $nav = $tabs.children('.su-tabs-nav'),
                $panes = $tabs.find('.su-tabs-pane'),
                height = 0;
            $panes.css('min-height', $nav.outerHeight(true));
        });
    }

    function anchor_nav() {
        // Check hash
        if (document.location.hash === '') return;
        // Go through tabs
        $('#productdetailsview.quick .su-tabs-nav span[data-anchor]').each(function() {
            if ('#' + $(this).data('anchor') === document.location.hash) {
                var $tabs = $(this).parents('.su-tabs');
                // Activate tab
                $(this).trigger('click');
                // Scroll-in tabs container
                window.setTimeout(function() {
                    $(window).scrollTop($tabs.offset().top - 10);
                }, 100);
            }
        });
    }
});
