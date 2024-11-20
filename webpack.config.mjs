import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

// Obtener la ruta del directorio actual
const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default {
    entry: './assets/js/index.js',
    output: {
        filename: 'bundle.js',
        path: resolve(__dirname, 'public/dist')
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    }
};