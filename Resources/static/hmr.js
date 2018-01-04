// CSS hot reload fix
// https://github.com/symfony/webpack-encore/pull/8#issuecomment-312599836
import hotEmitter from 'webpack/hot/emitter';

if (module.hot) {
    hotEmitter.on('webpackHotUpdate', () => {
        document.querySelectorAll('link[href][rel=stylesheet]').forEach((link) => {
            link.href = link.href.replace(/(\?\d+)?$/, `?${Date.now()}`); // eslint-disable-line
        });
    });
}
