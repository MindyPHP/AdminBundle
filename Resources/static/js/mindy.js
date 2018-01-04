import Noty from 'noty';

Noty.overrideDefaults({
    layout: 'topRight',
    theme: 'nest',
});

const notify = text => {
    new Noty({ text }).show();
};

export {
    notify
}