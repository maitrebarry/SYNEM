<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <!-- Global 5 Mo/image client-side validation (guest/auth) -->
        <script>
            (function(){
                const MAX = 5 * 1024 * 1024; // 5 Mo
                window.SYNEM_MAX_IMAGE_BYTES = MAX;
                function isImage(file, input){
                    const mime = (file && file.type) ? String(file.type) : '';
                    if (mime.startsWith('image/')) return true;
                    const accept = (input && input.getAttribute) ? (input.getAttribute('accept') || '') : '';
                    return String(accept).includes('image');
                }
                function validateInput(input){
                    if(!input || input.type !== 'file') return true;
                    const files = Array.from(input.files || []);
                    if(!files.length) return true;
                    const oversized = files.filter(f => isImage(f, input) && f.size > MAX);
                    if(!oversized.length) return true;
                    try{ input.value = ''; }catch(e){}
                    alert('Chaque image doit faire au maximum 5 Mo.');
                    return false;
                }
                document.addEventListener('change', function(e){
                    const t = e.target;
                    if(t && t.matches && t.matches('input[type="file"]')) validateInput(t);
                }, true);
                document.addEventListener('submit', function(e){
                    const form = e.target;
                    if(!form || !form.querySelectorAll) return;
                    const inputs = Array.from(form.querySelectorAll('input[type="file"]'));
                    for(const inp of inputs){
                        if(!validateInput(inp)){
                            e.preventDefault();
                            e.stopPropagation();
                            return false;
                        }
                    }
                }, true);
            })();
        </script>
    </body>
</html>
