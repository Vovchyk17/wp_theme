document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    /**
     * Attach event listener to the "Load More" button
     */
    const attachLoadMoreEvent = () => {
        const loadMoreBtn = document.querySelector('.load_more__posts');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => {
                loadMoreBtn.parentElement.nextElementSibling.querySelector('.show_box').classList.add('is_loading');
                const dataAttr = loadMoreBtn.getAttribute('data-next_page');
                loadPostsAjax(dataAttr ? JSON.parse(dataAttr) : null);
                loadMoreBtn.parentElement.remove();
            });
        }
    };

    /**
     * Fetch and load posts via AJAX based on filters
     * @param {Object|null} filter_data - Filter criteria
     */
    const loadPostsAjax = (filter_data = null) => {
        const bodyAjax = document.querySelector('body').dataset.a;
        const ajaxContent = document.querySelector('.posts__container[data-post-type="post"]');
        const postsPerPage = parseInt(ajaxContent?.dataset.postsPerPage || 6);
        const searchInput = document.querySelector('#s_ajax');

        // Initialize filter data if not provided
        if (!filter_data) {
            filter_data = {
                tax: {},
                posts_per_page: postsPerPage,
                date: [],
                author: [],
                next: 1,
                s: searchInput?.value.trim() || ''
            };

            // Collect taxonomy filters
            document.querySelectorAll('.tax_filter_dropdown').forEach(dropdown => {
                const tax = dropdown.dataset.tax;
                const selectedValue = dropdown.value;
                if (selectedValue !== '*') {
                    filter_data.tax[tax] = [parseInt(selectedValue)];
                }
            });

            // Collect date and author filters
            ['date_dropdown', 'author_dropdown'].forEach(id => {
                const value = document.querySelector(`#${id}`)?.value;
                if (value && value !== '*') {
                    filter_data[id.includes('date') ? 'date' : 'author'].push(parseInt(value));
                }
            });
        }

        // Prepare form data for AJAX request
        const formData = new FormData();
        formData.append('action', 'load_posts_ajax');

        // Append filter_data to formData
        Object.keys(filter_data).forEach(key => {
            if (typeof filter_data[key] === 'object' && filter_data[key] !== null) {
                Object.keys(filter_data[key]).forEach(subKey => {
                    formData.append(`filter_data[${key}][${subKey}]`, filter_data[key][subKey]);
                });
            } else {
                formData.append(`filter_data[${key}]`, filter_data[key]);
            }
        });

        // Perform AJAX request
        fetch(bodyAjax, { method: 'POST', body: formData })
            .then(response => response.json())
            .then(result => {
                ajaxContent.querySelectorAll('.load_more_holder, .loader_holder').forEach(el => el.remove());

                ajaxContent.innerHTML = parseInt(result.paged) !== 1 ? ajaxContent.innerHTML + result.html : result.html;

                document.querySelectorAll('.show_box').forEach(el => el.classList.remove('is_loading'));

                attachLoadMoreEvent();
            })
            .catch(error => console.error('Error:', error));
    };

    /**
     * Handle filter changes for dropdowns
     */
    document.querySelectorAll('.posts__filters select').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('.posts__filters').querySelector('.show_box').classList.add('is_loading');
            loadPostsAjax();
        });
    });
    document.querySelectorAll('select').forEach(select => {
        jQuery(select).selectric({
            disableOnMobile: false,
            nativeOnMobile: false,
            arrowButtonMarkup: '<span class="select_arrow"></span>',
            onChange: function() {
                select.closest('.posts__filters').querySelector('.show_box').classList.add('is_loading');
                loadPostsAjax();
            }
        });
    });

    /**
     * Handle AJAX search form submission
     */
    const searchForm = document.querySelector('.form_search_ajax[data-post-type="post"]');
    const searchFormInput = searchForm?.querySelector('input[type="search"]');
    const searchFormSubmitBtn = searchForm?.querySelector('button[type="submit"]');

    if (searchFormInput && searchFormSubmitBtn) {
        searchFormInput.addEventListener('input', () => {
            searchFormSubmitBtn.style.display = searchFormInput.value.length > 0 ? 'none' : '';
        });

        searchForm.addEventListener('submit', event => {
            event.preventDefault();
            searchForm.closest('.posts__filters').querySelector('.show_box').classList.add('is_loading');
            loadPostsAjax();
        });
    }

    /**
     * Handle clearing filters with a single AJAX call
     */
    document.querySelector('.posts__filters_clear')?.addEventListener('click', () => {
        const postsFilters = document.querySelector('.posts__filters');
        const showBox = postsFilters.querySelector('.show_box');

        if (showBox.classList.contains('is_loading')) return;

        showBox.classList.add('is_loading');

        // Reset search input
        const searchInput = document.querySelector('#s_ajax');
        if (searchInput) searchInput.value = '';

        // Reset all dropdowns without triggering multiple AJAX calls
        postsFilters.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0
            jQuery(select).selectric('refresh');
        });

        // Make a single call to reload posts
        loadPostsAjax();
    });

    // Attach "Load More" event
    attachLoadMoreEvent();
});
