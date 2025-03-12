<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/css/styles.css', 'resources/js/app.js', 'resources/js/conf.js'])
</head>
<body style="background-color: #F5F5F5">
    <div class="flex flex-col md:flex-row h-screen">
        @include('component.sidebar-kasir') <!-- Sidebar dipisahkan untuk reusability -->
        <div class="w-full md:w-full pt-6 mx-auto overflow-auto" id="content-area">
            <div class="w-full bg-gray-100 py-3 mb-4 flex flex-wrap justify-between items-center px-4 md:px-6">
                <div class="text-lg md:text-2xl text-gray-500">
                    Pages / <span id="breadcrumb" class="font-normal text-black">@yield('breadcrumb')</span>
                </div>
                <div class="flex items-center text-black mt-2 md:mt-0">
                    Abdullah Ali 
                    <span class="ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#818181" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"/>
                            <circle cx="12" cy="10" r="3"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="p-4 max-w-screen-xl mx-auto">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
