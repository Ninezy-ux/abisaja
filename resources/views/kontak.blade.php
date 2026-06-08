<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - saweria</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    {{-- HEADER --}}
    @include('partials.header')

    <section class="container mx-auto py-16">
        <div class="bg-white p-8 rounded-lg shadow max-w-xl mx-auto">
            <h1 class="text-2xl font-bold text-green-600 mb-4">Hubungi Kami</h1>

            <p class="text-gray-600 mb-6">
                Jika Anda memiliki pertanyaan atau ingin bekerja sama, silakan hubungi kami.
            </p>

            <form>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Nama</label>
                    <input type="text" class="w-full border rounded-lg p-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" class="w-full border rounded-lg p-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Pesan</label>
                    <textarea class="w-full border rounded-lg p-2"></textarea>
                </div>

                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                    Kirim Pesan
                </button>
            </form>

            <div class="mt-6 text-sm text-gray-600">
                <p>Email: hasbybutuhduit@saweria.com</p>
                <p>Telp: 0857-5225-7076</p>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    @include('partials.footer')

</body>
</html>