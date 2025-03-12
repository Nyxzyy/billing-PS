<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Billing Manage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="flex h-screen">
        <div class="w-3/5 relative bg-cover bg-center flex items-center justify-center"
            style="background-image: url('{{ asset('assets/images/Background (1).png') }}');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative p-6 text-center text-white">
                <h1 class="text-4xl font-semibold italic underline" style="font-family: Roboto, sans-serif">"INILOGONYA"
                </h1>
            </div>
        </div>

        <div class="w-2/5 bg-white p-6 px-16 shadow-lg flex flex-col justify-center">
            <h2 class="text-3xl font-semibold" style="font-family: Roboto, sans-serif">Selamat Datang!</h2>
            <p class="text-[#606060] mt-1 text-sm" style="font-family: Roboto, sans-serif">Silakan masuk untuk mengelola
                transaksi dan pelanggan dengan mudah.</p>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 mb-2"
                    role="alert">
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 mb-2"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="w-full max-w mt-4">
                @csrf
                <div class="mb-4 relative w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-[#BDBDBD]">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <input
                        class="text-sm w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="email" type="email" name="email" placeholder="Email" required
                        value="{{ old('email') }}">
                </div>
                <div class="mb-4 relative w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-[#BDBDBD]">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <input
                        class="text-sm w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="password" type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit"
                    class="w-full text-white font-semibold py-2 px-4 rounded-lg italic bg-[#004a6ae3] hover:bg-[#004a6a] hover:text-white hover:cursor-pointer hover:font-semibold hover:drop-shadow-2xl transition duration-300">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>

</html>
