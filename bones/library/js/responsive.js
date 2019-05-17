/*Responsive Changes*/
jQuery(document).ready(function ($) {

    // define changes to html structure when screen size is changed
    function mobileSiteChange() {
        jQuery('body').css('overflow', 'hidden');
        jQuery('html').css('overflow-y', 'hidden');
        var window_width = jQuery(window).width() + scrollbar_width();
        jQuery('body').css('overflow', '');
        jQuery('html').css('overflow-y', '');

        if (window_width <= 767) {
            //WHEN SCREEN PHONE SIZE
            changePhone();

        } else if (window_width <= 1030) {
            //WHEN SCREEN TABLET SIZE
            changeTablet();

        } else {
            //WHEN DESKTOP SIZE
            changeTablet();
            changeDesktop();
        }

    }

    function changePhone() {
        //console.log('Mobile');



    }

    function changeTablet() {
        //console.log('Tablet');

        //THIS IS THE LINE THAT I USED FOR RETURNING THE NAVIGATION COLUMN


    }

    function changeDesktop() {
       // console.log('Desktop');

    }

    // Call function when page first loads.
    mobileSiteChange();
    var doit;
    // Call function when page is resized.
    $(window).resize(function () {
        mobileSiteChange();
        clearTimeout(doit);
        doit = setTimeout(mobileSiteChange, 100);
    });

    //Calculates scrollbar width in pixels */
    function scrollbar_width() {
        if (jQuery('body').height() > jQuery(window).height()) {
            var calculation_content = jQuery('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div>');
            jQuery('body').append(calculation_content);
            var width_one = jQuery('div', calculation_content).innerWidth();
            calculation_content.css('overflow-y', 'scroll');
            var width_two = jQuery('div', calculation_content).innerWidth();
            jQuery(calculation_content).remove();
            return (width_one - width_two);
        }
        return 0;
    }
        //RESIZE HOMEPAGE WIDGET SPACE
        if ($('#feeds').length) {
            var feeds = $("#feeds .feed-type");
            feeds.css("height", "");
            //var homeWidgetsHeight = $("body.home #home-widgets").height();
            var maxFeedHeight = 0;

            feeds.each(function (index, element) {
                //        var panel = $(element).find(".widget-panel");
                var panelHeight = $(element).outerHeight();
                if (panelHeight > maxFeedHeight) {
                    maxFeedHeight = panelHeight;
                }

            });

            feeds.css("height", maxFeedHeight);
        }

});