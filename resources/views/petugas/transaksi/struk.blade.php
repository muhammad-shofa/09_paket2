<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Parkir - {{ $transaksi->kendaraan->plat_nomor }}</title>
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Courier New', Courier, monospace;
            padding: 2rem;
            color: #0f172a;
        }

        .struk-container {
            background: white;
            max-width: 350px;
            margin: 0 auto;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .border-dashed {
            border-top: 1px dashed #cbd5e1;
            border-bottom: 1px dashed #cbd5e1;
            padding: 0.75rem 0;
            margin: 1rem 0;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .py-1 {
            padding: 0.25rem 0;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .struk-container {
                box-shadow: none;
                max-width: 100%;
                border: none;
                padding: 0.5rem;
            }

            button {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="struk-container">
        <div class="text-center mb-4">
            <h2 class="font-bold text-xl m-0">Parkir Sek.</h2>
            <p class="text-sm m-0">Sistem Parkir Terpadu</p>
            <p class="text-sm m-0">Kendaraan: {{ $transaksi->kendaraan->plat_nomor }}</p>
        </div>

        <div class="border-dashed">
            <div class="flex py-1 text-sm">
                <span>No Tiket:</span>
                <span class="font-bold">#{{ str_pad($transaksi->id_parkir, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex py-1 text-sm">
                <span>Area:</span>
                <span>{{ $transaksi->area->nama_area }}</span>
            </div>
            <div class="flex py-1 text-sm">
                <span>Waktu Masuk:</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->waktu_masuk)->format('d-m-Y H:i') }}</span>
            </div>
            <div class="flex py-1 text-sm">
                <span>Waktu Keluar:</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('d-m-Y H:i') }}</span>
            </div>
            <div class="flex py-1 text-sm">
                <span>Durasi:</span>
                <span>{{ $transaksi->durasi_jam }} Jam</span>
            </div>
            <div class="flex py-1 text-sm">
                <span>Tarif Dasar:</span>
                <span>Rp {{ number_format($transaksi->tarif->tarif_per_jam, 0, ',', '.') }} / jam</span>
            </div>
        </div>

        <div class="flex mt-4 font-bold">
            <span>TOTAL TAGIHAN</span>
            <span>Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</span>
        </div>

        <div class="text-center text-sm mt-4 pt-4" style="border-top:1px dashed #cbd5e1;">
            <p class="mb-2">Operator: {{ $transaksi->user->nama_lengkap ?? 'Petugas' }}</p>
            <p class="m-0">Terima kasih atas kunjungan Anda!</p>
            <p class="text-xs mt-2" style="color:#64748b;">Simpan struk ini sebagai bukti pembayaran yang sah.</p>
            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px dashed #cbd5e1;">
                <p class="text-xs" style="color:#64748b; font-weight:bold; margin:0;">Riwayat parkir Anda dapat dicek secara online di <br> <span style="color:#4f46e5;">parkirsek.com</span><br>dengan memasukkan Nomor Tiket Anda.</p>
            </div>
        </div>

        <script>
            window.onload = function () { window.print(); }
        </script>
    </div>

</body>

</html>