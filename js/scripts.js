/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/

$(document).ready(function() {
    'use strict';

    //  hamburger + menu
    $('.nav_icon').on('click', function() {
        $(this).toggleClass('is_active').next().stop().toggleClass('is_open');
        $('body').toggleClass('is_overflow');
        return false;
    });
    $('#menu .menu-item-has-children > a').after('<span />');
    $('#menu').on('click', '.menu-item-has-children > a + span', function() {
        $(this).toggleClass('is_open').next().stop().toggle().parent().toggleClass('is_active');
    });


    //  contact form 7
    $(this).on('click', '.wpcf7-not-valid-tip', function() {
        $(this).prev().trigger('focus');
        $(this).fadeOut(500,function(){
            $(this).remove();
        });
    });
    $(this).on('focus', '.wpcf7-form-control:not([type="submit"])', function() {
        $(this).parent().addClass('is_active');
    });
    $(this).on('blur', '.wpcf7-form-control:not([type="submit"])', function() {
        if($(this).val() !== "") {
            $(this).parent().addClass('is_active');
        } else {
            $(this).parent().removeClass('is_active');
        }
    });
    $(this).on( 'keyup', 'textarea', function() {
        $(this).height( 0 );
        $(this).height( this.scrollHeight );
    });


    //  custom select
    // $('select').selectric({
    //     disableOnMobile: false,
    //     nativeOnMobile: false,
    //     arrowButtonMarkup: '<span class="select_arrow"></span>'
    // });
    // $('select.wpcf7-form-control').each(function () {
    //     $(this).find('option').first().val('');
    // });


    //  custom code
    
});



$(window).on('load', function() {
    'use strict';

    //  swiper
    // setTimeout(function() {
    //     var home_slider = new Swiper('.home_slider', {
    //         navigation: {
    //             nextEl: '.custom_next',
    //             prevEl: '.custom_prev'
    //         },
    //         pagination: {
    //             el: '.sw_pagination',
    //             type: 'bullets',
    //             clickable: true
    //         },
    //         autoplay: {
    //             delay: 4000
    //         },
    //         speed: 1000
    //     });
    // }, 500);


    //  fluid video (iframe)
    $('.content iframe').each(function(i) {
        var t = $(this),
            p = t.parent();
        if (p.is('p') && !p.hasClass('fullframe')) {
            p.addClass('fullframe');
        }
    });
    $('.wp-video').each(function() {
        $('.mejs-video .mejs-inner', this).addClass('fullframe');
    });

});



$(window).resizeEnd(function() {
    'use strict';
    
});