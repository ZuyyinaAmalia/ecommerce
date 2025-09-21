<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pilih Jenis Pengguna</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md text-center">
        <h2 class="text-2xl font-bold mb-6">Anda Pengunjung atau Pengguna?</h2>
        <div class="flex flex-col gap-4">
            <a href="{{ route('landing') }}" class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700">Masuk sebagai Pengunjung</a>
            <a href="{{ route('register') }}" class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700">Daftar sebagai Pengguna/Admin</a>
        </div>
    </div>
</body>
</html>