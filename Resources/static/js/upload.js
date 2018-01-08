import 'blueimp-file-upload';
import notify from './notify';

const attachFileManager = () => {
    $('.b-filemanager__fileinput').fileupload({
        dataType: 'html',
        limitConcurrentUploads: 1,
        sequentialUploads: true,
        dropZone: $('.b-filemanager__dropzone'),
        add: (e, data) => {
            $('.b-filemanager__progress').addClass(
                'b-filemanager__progress_visible'
            );
            data.submit();
        },
        progressall: (e, data) => {
            let progress = parseInt(data.loaded / data.total * 100, 10);
            $('.b-filemanager__progress')
                .find('.b-filemanager__state')
                .width(progress + '%')
                .text(progress + '%');
        },
        success: data => {
            $('.b-filemanager__progress').removeClass(
                'b-filemanager__progress_visible'
            );
            notify({ text: 'Файлы загружены' });
            $('.b-filemanager__target').replaceWith(data);
        },
    });
};

$(document).on('dragover dragenter', e => {
    let $dropZone = $('.b-filemanager__dropzone'),
        timeout = window.dropZoneTimeout;
    if (!timeout) {
        $dropZone.addClass('b-filemanager__dropzone_in');
    } else {
        clearTimeout(timeout);
    }

    let found = false,
        node = e.target;

    do {
        if (node === $dropZone[0]) {
            found = true;
            break;
        }
        node = node.parentNode;
    } while (node != null);

    if (found) {
        $dropZone.addClass('b-filemanager__dropzone_hover');
    } else {
        $dropZone.removeClass('b-filemanager__dropzone_hover');
    }

    window.dropZoneTimeout = setTimeout(() => {
        window.dropZoneTimeout = null;
        $dropZone.removeClass(
            'b-filemanager__dropzone_in b-filemanager__dropzone_hover'
        );
    }, 100);
});

$(() => {
    attachFileManager();
});
