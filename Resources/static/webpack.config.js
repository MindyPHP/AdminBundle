var webpack = require('webpack'),
    path = require('path');

module.exports = {
    entry: "./js/index",
    output: {
        path: path.resolve(path.join(__dirname, '/../public/js')),
        filename: "bundle.js"
        // publicPath: "/assets/"
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: ['babel-loader'],
                exclude: /node_modules/
            },
            {
                test: require.resolve('jquery'),
                use: [
                    { loader: 'expose-loader', options: 'jQuery' },
                    { loader: 'expose-loader', options: '$' }
                ]
            },
            {
                test: require.resolve('./js/mindy'),
                use: [
                    { loader: 'expose-loader', options: 'mindy' }
                ]
            }
        ]
    },
    resolve: {
        // options for resolving module requests
        // (does not apply to resolving to loaders)
        alias: {
            "jquery-ui/ui/widget": "blueimp-file-upload/js/vendor/jquery.ui.widget.js",
        },
        modules: [
            "node_modules",
            path.resolve(__dirname, "js")
        ],
        extensions: [".js", ".json", ".jsx"]
    },
    devtool: "eval", // enum
    context: __dirname, // string (absolute path!)
    target: "web",
    externals: ["react"],
    plugins: [
        new webpack.ProvidePlugin({
            'Promise': 'bluebird',
            'jQuery': 'jquery',
            '$': 'jquery',
        }),
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: JSON.stringify(process.env.NODE_ENV || 'development')
            }
        })
    ]
};