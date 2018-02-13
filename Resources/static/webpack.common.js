const webpack = require('webpack');
const path = require('path');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const HardSourceWebpackPlugin = require('hard-source-webpack-plugin');

module.exports = {
    entry: {
        app: './js/app.js'
    },
    plugins: [
        new HardSourceWebpackPlugin(),
        new FriendlyErrorsWebpackPlugin({
            clearConsole: false,
        }),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
        })
    ],
    module: {
        rules: [
            {
                test: require.resolve('jquery'),
                use: [
                    { loader: 'expose-loader', options: '$' }
                ]
            }
        ]
    },
    output: {
        filename: '[name].js',
        path: path.join(__dirname, '/../public/js')
    }
};
