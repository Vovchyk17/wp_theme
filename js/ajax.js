/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/

// ajax posts - loading + filtering
function load_posts_ajax(filter_data = null) {
    const ajax_content = $('.posts__container[data-post-type="post"]');
    const posts_per_page = parseInt(ajax_content.data('posts-per-page')) || 6;

    if (!filter_data) {
        filter_data = {
            tax: {
                category: [],
                topic: [],
            },
            posts_per_page: posts_per_page,
            date: [],
            author: [],
            next: 1,
            s: $('#s_ajax').val() || ''
        }

        $('.tax_filter_dropdown').each(function() {
            const tax = $(this).data('tax');
            const selected_value = $(this).val();
            filter_data.tax[tax] = selected_value !== '*' ? [parseInt(selected_value)] : [];
        });

        const date_selected = $('#date_dropdown').val();
        date_selected !== '*' ? filter_data.date = [date_selected] : filter_data.date = [];

        const author_selected = $('#author_dropdown').val();
        author_selected !== '*' ? filter_data.author = [parseInt(author_selected)] : filter_data.author = [];

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

            ajax_content[parseInt(result.paged) !== 1 ? 'append' : 'html'](result.html);

            $('.show_box').removeClass('is_loading');
        }
    });

    return false;
}


$(document).ready(function () {
    'use strict';

    /*ajax post filter start*/
    // dropdown filter
    $('.posts__filters select').on('change', function () {
        $(this).parents('.posts__filters').find('.show_box').addClass('is_loading');
        load_posts_ajax();
    });

    // search form
    const search_form = $('.form_search_ajax[data-post-type="post"]');
    const search_form_input = search_form.find('input[type="search"]');
    const search_form_submit_btn = search_form.find('button[type="submit"]');
    search_form_input.on('input', function () {
        if ($(this).val().length > 0) {
            search_form_submit_btn.hide();
        } else {
            search_form_submit_btn.show();
        }
    });

    search_form.on('submit', function (event) {
        event.preventDefault();
        $(this).parents('.posts__filters').find('.show_box').addClass('is_loading');
        load_posts_ajax();
    });

    // load more posts
    $(this).on('click', '.load_more__posts', function () {
        $(this).parent().next().find('.show_box').addClass('is_loading');
        load_posts_ajax($(this).data('next_page'));
        $(this).parent().remove();
        return false;
    });

    $('.posts__filters_clear').on('click', function () {
        $(this).parents('.posts__filters').find('.show_box').addClass('is_loading');
        $('#s_ajax').val('');
        $('.posts__filters select').each(function () {
            $(this).find('option:first').prop('selected', true);
            $(this).selectric('refresh');
        });
        load_posts_ajax();
        return false;
    })
    /*ajax post filter end*/

});