<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-color: #F5F5F5">
    <div class="flex h-screen">
        <div class="w-1/5 bg-white text-black flex flex-col p-4">
            <div class="flex items-center justify-center mb-6 py-4 border-b">
                <h1 class="text-3xl font-bold italic" style="font-family: Roboto, sans-serif">INILOGONYA</h1>
            </div>
            <nav>
                <ul>
                    <li class="mb-4">
                        <a href="#" class="font-medium block p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white" onclick="showContent('dashboard')">Dashboard</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="font-medium block p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white" onclick="showContent('billing')">Billing</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="font-medium block p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white" onclick="showContent('laporan')">Laporan</a>
                    </li>
                </ul>
            </nav>
            <div class="mt-auto">
                <a href="#" class="block p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">Keluar Akun</a>
            </div>
        </div>
    
        <div class="w-4/5 p-6" id="content-area">
            <div class="w-full bg-gray-100 py-3 mb-8 flex justify-between items-center">
                <div class="text-gray-500">Pages / <span id="breadcrumb" class="font-normal text-black">Dashboard</span></div>
                <div class="flex items-center text-black">
                    Abdullah Ali <span class="ml-2">&#x1F464;</span>
                </div>
            </div>
            <div id="dashboard" class="content-section">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p>Lihat ringkasan keuangan dan status perangkat berdasarkan data hari ini.</p>
            </div>
            <div id="billing" class="content-section hidden">
                <h1 class="text-2xl font-bold">Billing</h1>
                <p>Kontrol billing perangkat dengan cepat. Pantau status perangkat aktif dan non-aktif dalam satu tampilan.</p>
            </div>
            <div id="laporan" class="content-section hidden">
                <h1 class="text-2xl font-bold">Laporan</h1>
                <p>Lihat rekap transaksi kasir, total pendapatan, dan tutup buku dengan konfirmasi cetak laporan.</p>
            </div>
        </div>
    </div>

    <script>
        function showContent(section) {
            document.getElementById('breadcrumb').innerText = section.charAt(0).toUpperCase() + section.slice(1);
            document.querySelectorAll('.content-section').forEach(el => el.classList.add('hidden'));
            document.getElementById(section).classList.remove('hidden');
        }
    </script>
</body>
</html>
