<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title><?php echo isset($page_title) ? $page_title . " | WowVision Real Estate" : "Propiedades Premium | Bienes Raíces de Lujo"; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Descubre nuestra colección exclusiva de propiedades de diseño contemporáneo, minimalista y de lujo.'; ?>">
    <meta name="robots" content="index, follow">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configuración de la paleta premium dentro del objeto de Tailwind
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        premium: {
                            dark: '#111111',
                            gray: '#737373',
                            light: '#F5F5F7',
                            border: '#E5E5E5'
                        }
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="public/css/custom.css">
</head>
<body class="flex flex-col min-h-screen justify-between">