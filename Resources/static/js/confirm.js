import $ from 'jquery';

$(document).on('click', '[data-confirm]', e => {
    let $target = $(e.target);
    if (confirm($target.attr('data-confirm'))) {
        return true;
    } else {
        e.preventDefault();
    }
});
