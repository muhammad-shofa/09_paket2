<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Tagihan Parkir - Parkir Sek</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 py-4 px-6 md:px-12 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="p-2 bg-indigo-600 rounded-lg">
                <i class="ph-bold ph-car text-white text-xl"></i>
            </div>
            <span class="font-bold text-xl text-slate-800">Parkir Sek</span>
        </div>
        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
            Login Petugas
        </a>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-sm border border-slate-100 text-center">
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Cek Tagihan Parkir</h1>
            <p class="text-sm text-slate-500 mb-8">Masukkan Nomor Tiket Parkir (ID) yang ada pada Karcis Anda.</p>

            <form id="track-form" class="flex gap-2 mb-6">
                @csrf
                <input type="number" id="ticket_input" placeholder="Contoh: 098765"
                    class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    required>
                <button type="submit" id="btn-search"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
                    <i class="ph-bold ph-magnifying-glass"></i> Cek
                </button>
            </form>

            <!-- Result Container -->
            <div id="result-container" class="hidden text-left bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-200">
                    <span class="text-sm font-bold text-slate-400 uppercase tracking-wider">Status</span>
                    <span id="res-status"
                        class="px-3 py-1 bg-sky-100 text-sky-700 font-bold rounded-full text-xs">PARKIR</span>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">No. Tiket</span>
                        <b id="res-tiket" class="text-slate-800">#000000</b>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Plat Nomor</span>
                        <b id="res-plat" class="text-slate-800 uppercase">-</b>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Waktu Masuk</span>
                        <b id="res-masuk" class="text-slate-800">-</b>
                    </div>
                    <div class="flex justify-between" id="row-keluar">
                        <span class="text-slate-500">Waktu Keluar</span>
                        <b id="res-keluar" class="text-slate-800">-</b>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Durasi</span>
                        <b id="res-durasi" class="text-slate-800">- Jam</b>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-end">
                    <span class="text-slate-500 text-sm font-semibold">Estimasi Tagihan</span>
                    <b id="res-biaya" class="text-2xl text-indigo-700">Rp 0</b>
                </div>
            </div>

            <!-- Loading / Error Message -->
            <div id="msg-container" class="hidden mt-4 text-sm font-semibold"></div>

        </div>
    </main>

    <!-- AI Chatbot Component -->
    <script src="https://js.puter.com/v2/"></script>
    @include('partials.chatbot')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#track-form').on('submit', function (e) {
                e.preventDefault();
                let btn = $('#btn-search');
                let msg = $('#msg-container');
                let resBox = $('#result-container');

                let tiket = $('#ticket_input').val();

                btn.prop('disabled', true).html('<i class="ph-bold ph-spinner animate-spin"></i>');
                msg.addClass('hidden').removeClass('text-red-500');
                resBox.addClass('hidden');

                $.ajax({
                    url: "{{ route('track') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ticket_id: tiket
                    },
                    success: function (res) {
                        let data = res.data;
                        $('#res-tiket').text('#' + data.no_tiket);
                        $('#res-plat').text(data.plat_nomor);
                        $('#res-masuk').text(data.waktu_masuk);

                        if (data.status === 'keluar') {
                            $('#res-keluar').text(data.waktu_keluar);
                            $('#res-status').removeClass('bg-sky-100 text-sky-700').addClass('bg-emerald-100 text-emerald-700').text('SELESAI');
                        } else {
                            $('#res-keluar').text('-');
                            $('#res-status').removeClass('bg-emerald-100 text-emerald-700').addClass('bg-sky-100 text-sky-700').text('PARKIR');
                        }

                        $('#res-durasi').text(data.durasi_jam + ' Jam');
                        $('#res-biaya').text('Rp ' + data.biaya_estimasi);

                        resBox.removeClass('hidden');
                    },
                    error: function (err) {
                        let errorText = err.responseJSON?.message || "Terjadi kesalahan sistem.";
                        msg.text(errorText).addClass('text-red-500').removeClass('hidden');
                    },
                    complete: function () {
                        btn.prop('disabled', false).html('<i class="ph-bold ph-magnifying-glass"></i> Cek');
                    }
                });
            });
        });
    </script>
</body>

</html>