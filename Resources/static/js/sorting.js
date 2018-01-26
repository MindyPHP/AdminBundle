import $ from 'jquery';
import notify from './notify';

const selector = '.b-table[data-sorting] .b-table__tbody';

const initSortingTable = () => {
    $(selector).sortable({
        items: '.b-table__tr',
        handle: '.sorting--container',
        axis: 'y',
        placeholder: 'highlight',
        helper: function(e, ui) {
            ui.children().each(function() {
                let $this = $(this);
                $this.width($this.width());
            });
            return ui;
        },
        update: function(event, ui) {
            let $tbody = $(this),
                $table = $tbody.closest('.b-table'),
                $to = $(ui.item),
                $prev = $to.prev(),
                $next = $to.next(),
                data = $tbody.sortable('toArray', { attribute: 'data-id' });

            $.post(
                $table.attr('data-sorting'),
                {
                    sort: {
                        column: $table.attr('data-column'),
                        models: data,
                        id: $to.attr('data-id'),
                        after: $prev.attr('data-id'),
                        before: $next.attr('data-id'),
                    },
                },
                data => {
                    $tbody.replaceWith($(data).find(selector));

                    notify({
                        type: 'success',
                        text: 'Выполнено',
                    });

                    // Reinit sorting
                    initSortingTable();
                }
            ).fail(() => {
                notify({
                    type: 'error',
                    text: 'Произошла ошибка',
                });
            });
        },
    });
};

$(() => {
    initSortingTable();
});
