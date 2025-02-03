const path = require('path')

const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const themename = 'centrotrika-theme'
const destdir = path.join(__dirname, themename)
const themeplublic = '/wp-content/themes/' + themename

module.exports = env => {    
                                                    
  const input = Object.keys(env)[2] || ''

  const params = input.split('-')
  const section = params[0] || 'custom' // app | admin
  const mode = params[1] || 'dev' // dev | prod
   
  let paths = {}

  paths.entryjs = './src/main.js'
  paths.entryscss = './src/main.scss'
  paths.output = destdir  + '/custom'
  paths.public = themeplublic
  paths.cssfilename = 'main.css'

  return {
    context: __dirname,
    stats: 'minimal',
    watch: true,
    name: 'minimal',
    entry: {
      main: paths.entryjs,
      maincss: paths.entryscss
    },
    output: {
      path: paths.output,
      publicPath: paths.public
    },
    mode: mode == 'prod' ? 'production' : 'development',
    devtool: mode == 'prod' ? 'none' : 'source-map',
    module: {
      rules: [
        {
          test: /\.jsx?$/,
          exclude: /node_modules/,
          use: [          
            { 
              loader: 'babel-loader',
              options: {
                presets: [
                  '@babel/preset-env',
                  '@babel/preset-react'
                ]
              }
            }
          ]
        },
        {
          test: /\.s[ac]ss$/i,
          exclude: /node_modules/,
          use: [
            { 
              loader: MiniCssExtractPlugin.loader
            },
            {
              loader: 'css-loader'
            },
            {
              loader: 'sass-loader',
              options: {
                sassOptions: {
                  quietDeps: true,
                },
              },
            }
          ]
        },
        {
          test: /\.css$/,
          include: /node_modules/,
          use: [
            { 
              loader: MiniCssExtractPlugin.loader
            },
            'style-loader',
            'css-loader'
          ]
        },
        // Assets
        {
          test: /\.(jpg|jpeg|png|gif|svg|woff|ttf|eot|mp3|woff|woff2|webm|mp4)$/,
          type: 'asset/resource',
          generator: {
            emit: false,
            filename: content => { 

              return content.filename.replace(themename, '')
            }
          }
        }
      ]
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: pathData => {

          return paths.cssfilename
        }
      })
    ],
    resolve: {
      extensions: ['.js']
    }
  }
}