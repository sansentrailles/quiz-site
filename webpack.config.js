// webpack.config.js
const path = require('path');

module.exports = (env) => {
  const isProduction = env === 'production';

  return {
    mode: isProduction ? 'production' : 'development',
    entry: './frontend/js/main.js',
    output: {
        filename: 'main.js',          // Имя собранного файла
        path: path.resolve(__dirname, 'frontend/build/js') // Путь (для dev), gulp может это переопределять
    },
    // output: {
    //   filename: 'bundle.js',
    //   path: path.resolve(__dirname, isProduction ? './public_html/js' : './frontend/build/js'),
    // },
    devtool: isProduction ? false : 'source-map',
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader', 
            options: {
              presets: ['@babel/preset-env']
            }
          }
        }
      ]
    }
  };
};