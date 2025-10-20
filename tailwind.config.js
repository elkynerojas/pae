import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/css/filament/**/*.css',
    ],
    theme: {
        extend: {
            colors: {
                primary: {

    50: #FFF8E1,
    100: #FFECB3,
    200: #FFE082,
    300: #FFD54F,
    400: #FFCA28,
    500: #FFB74D,
    600: #FFA726,
    700: #FF9800,
    800: #F57C00,
    900: #EF6C00,
    950: #E65100

                },
            },
                secondary: {
                    50: '#E3F2FD',   // Azul cielo muy claro
                    100: '#BBDEFB',  // Azul cielo claro
                    200: '#90CAF9',  // Azul cielo medio claro
                    300: '#64B5F6',  // Azul cielo medio
                    400: '#42A5F5',  // Azul cielo medio oscuro
                    500: '#2196F3',  // Azul cielo principal
                    600: '#1E88E5',  // Azul cielo oscuro
                    700: '#1976D2',  // Azul cielo muy oscuro
                    800: '#1565C0',  // Azul cielo extra oscuro
                    900: '#0D47A1',  // Azul cielo ultra oscuro
                    950: '#0A3D91',  // Azul cielo máximo oscuro
                },
                tertiary: {
                    50: '#FFF0F5',   // Rosa muy claro
                    100: '#FCE4EC',  // Rosa claro
                    200: '#F8BBD9',  // Rosa medio claro
                    300: '#F48FB1',  // Rosa medio
                    400: '#F06292',  // Rosa medio oscuro
                    500: '#EC407A',  // Rosa principal
                    600: '#E91E63',  // Rosa oscuro
                    700: '#D81B60',  // Rosa muy oscuro
                    800: '#C2185B',  // Rosa extra oscuro
                    900: '#AD1457',  // Rosa ultra oscuro
                    950: '#880E4F',  // Rosa máximo oscuro
                },
            },
        },
    },
}