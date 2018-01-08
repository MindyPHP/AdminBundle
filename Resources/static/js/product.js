import $ from 'jquery';

$(document).on('click', '.b-product-image__remove', e => {
    e.preventDefault();

    let $target = $(e.target).closest('a');

    if (confirm('Удалить изображение?')) {
        $.ajax({
            url: $target.attr('href'),
            success: data => {
                $('.b-file-upload__container').html(data);
            },
        });
    }
});
