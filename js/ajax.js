/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/


// ajax posts - loading + filtering
function load_posts_ajax(filter_data = null) {
    const ajax_content = $('.posts__container');

    if (!filter_data) {
        filter_data = {
            tax: {
                category: [],
            },
            next: 1,
        }
        $('.posts__dropdown option:selected').each(function () {
            const _val = $(this).val();
            if (_val !== '*') filter_data.tax.category.push(_val);
        });
    }

    $.ajax({
        type: 'POST',
        url: $('body').data('a'),
        data: {
            action: 'load_posts_ajax',
            filter_data: filter_data
        },
        success: function (result) {
            ajax_content.find('.load_more_holder, .loader_holder').remove();

            if (parseInt(result.paged) !== 1) {
                ajax_content.append(result.html);
            } else {
                ajax_content.html(result.html);
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
        $(this).parents('.posts__filters').find('.show_box').addClass('is_loading');

        const _term_id = $(this).attr('data-id');

        const filter_data = {
            tax: {
                category: _term_id === '*' ? [] : [_term_id],
            },
            next: 1,
        };

        load_posts_ajax(filter_data)

        $('.posts__filters a').removeClass('is_filtered');
        $(this).addClass('is_filtered');

        // window.location.hash = cat;

        return false;
    });
    // desktop - hash catch
   /* posts_filters.each(function() {
        const hash = $(this).attr('href');
        if (hash === window.location.hash) {
            $(this).click();
        }
    });*/

    // mobile
    posts_dropdown.on('change', function () {
        $(this).parents('.posts__filters').find('.show_box').addClass('is_loading');
        load_posts_ajax();
        // window.location.hash = cat;
    });
    // mobile - hash catch
    /*posts_dropdown.find('option').each(function() {
        const hash = $(this).val();
        if (hash === window.location.hash) {
            const ti = $(this).index();
            posts_dropdown.prop('selectedIndex', ti).selectric('refresh');
        }
    });*/

    // ajax posts - page loading
    $(this).on('click', '.load_more__posts', function () {
        $(this).parent().next().find('.show_box').addClass('is_loading');
        load_posts_ajax($(this).data('next_page'));
        $(this).parent().remove();
        return false;
    });

});