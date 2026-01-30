<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Templatenesia - Official Store')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    colors: {
                        iosBlue: '#007AFF',
                        iosPurple: '#9333ea',
                        iosDark: '#1D1D1F',
                        iosBg: '#F5F5F7',
                    },
                    boxShadow: {
                        'soft': '0 8px 30px rgba(0,0,0,0.04)',
                        'glow': '0 0 20px rgba(0, 122, 255, 0.3)',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>
<body style="background-color: #F5F5F7; color: #1D1D1F; -webkit-font-smoothing: antialiased;">
    @yield('content')
    
    @stack('scripts')
</body>
</html>
