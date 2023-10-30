/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/


// ajax posts - loading + filtering
function load_posts_ajax(paged, category) {
    if(!paged) {
        paged = 1;
    }

    const ajax_content = $('.posts__container');

    $.ajax({
        type: 'POST',
        url: $('body').data('a'),
        data: {
            action: 'load_posts_ajax',
            paged: paged,
            category: category
        },
        success: function (html) {
            $('.loader_holder').remove();

            if (paged !== 1) {
                ajax_content.append(html);
            } else {
                ajax_content.html(html);
            }

            $('.show_box').removeClass('is_loading');
        }

    });

    return false;
}


$(document).ready(function () {
    'use strict';

    // ajax posts - filtering
    const posts_filters = $('.posts__filters a');
    const posts_dropdown = $('.posts__dropdown');

    // desktop
    posts_filters.on('click', function () {
        $(this).parents('.posts__filtering').find('.show_box').addClass('is_loading');

        const cat = $(this).attr('href');

        load_posts_ajax(1, cat);

        $('.posts__filters a').removeClass('is_filtered');
        $(this).addClass('is_filtered');

        window.location.hash = cat;

        return false;
    });
    // desktop - hash catch
    posts_filters.each(function() {
        const hash = $(this).attr('href');
        if (hash === window.location.hash) {
            $(this).click();
        }
    });

    // mobile
    posts_dropdown.on('change', function () {
        $(this).parents('.posts__filtering').find('.show_box').addClass('is_loading');

        const cat = $(this).val();

        load_posts_ajax(1, cat);

        window.location.hash = cat;
    });
    // mobile - hash catch
    posts_dropdown.find('option').each(function() {
        const hash = $(this).val();
        if (hash === window.location.hash) {
            const ti = $(this).index();
            posts_dropdown.prop('selectedIndex', ti).selectric('refresh');
        }
    });

    // ajax posts - page loading
    $(this).on('click', '.load_more__posts', function () {
        $(this).parent().next().find('.show_box').addClass('is_loading');

        const pg = $(this).attr('data-href');
        const cat = $(this).attr('data-cat');

        load_posts_ajax(pg === 1 ? 2 : pg, cat);

        $(this).parent().remove();

        return false;
    });

});