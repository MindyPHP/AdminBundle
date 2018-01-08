import $ from 'jquery';
import notify from './notify';

$(document)
    .on('click', '.b-filemanager__mkdir', e => {
        e.preventDefault();

        let $this = $(e.target).closest('a');
        let directory = prompt('Введите имя директории:');
        if (directory) {
            $.post($this.attr('href'), { directory }, data => {
                notify({ text: data.message });

                if (data.status) {
                    $.get('', {}, data => {
                        let $newContent = $(data).find(
                            '.b-filemanager__target'
                        );
                        $('.b-filemanager__target').replaceWith($newContent);
                    });
                }
            });
        }
    })
    .on('click', '.b-filemanager__remove', e => {
        e.preventDefault();

        let $this = $(e.target);
        if (confirm($this.attr('data-confirm-message'))) {
            api.post($this.attr('href')).then(data => {
                $this.closest('tr').remove();

                notify({ title: 'Файл удален' });
            });
        }
    })
    .on('click', '.b-filemanager__copy', e => {
        e.preventDefault();

        $(e.target)
            .closest('.b-filemanager__container')
            .find('.b-filemanager__input')
            .select();
        document.execCommand('copy');

        notify({ text: 'Ссылка скопирована' });
    })
    .on('click', '.b-filemanager__input', e => {
        $(e.target).select();
    });
