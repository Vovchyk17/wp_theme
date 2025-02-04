$(document).ready(function () {
    'use strict';

    $(this).on('click', '.wpcf7-not-valid-tip', function () {
        $(this).prev().trigger('focus');
        $(this).fadeOut(250, function () {
            $(this).remove();
        });
        $(this).parents('.wpcf7-form').find('.wpcf7-response-output').addClass('is_temp_hidden');
    });
    $(this).on('focus', '.wpcf7-form-control.wpcf7-not-valid', function () {
        $(this).next('.wpcf7-not-valid-tip').fadeOut(250, function () {
            $(this).remove();
        });
        $(this).parents('.wpcf7-form').find('.wpcf7-response-output').addClass('is_temp_hidden');
    });
    document.addEventListener('wpcf7submit', function (event) {
        $('.wpcf7-response-output').removeClass('is_temp_hidden');
    }, false);

});