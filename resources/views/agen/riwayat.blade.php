@extends('layouts.app')

@section('title', 'Riwayat Pembelian ' . $agen->nama_agen)

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Pembelian Agen</h2>
            <p class="text-sm text-gray-400 mt-0.5">Nama Agen: <span class="font-semibold text-blue-600">{{ $agen->nama_agen }}</span></p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl border border-blue-100 shadow-sm">
                <span id="qz-status-dot" class="w-3 h-3 rounded-full bg-yellow-500 shadow animate-pulse"></span>
                <select id="printer-select" class="bg-transparent text-sm text-gray-700 outline-none cursor-pointer max-w-[150px] truncate" disabled>
                    <option>Mencari printer...</option>
                </select>
            </div>
            <a href="{{ route('agen.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl shadow-sm hover:bg-gray-50 transition-all duration-200">
                <i class="fas fa-arrow-left text-xs"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-blue-50 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500">
                <i class="fas fa-store text-lg"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase">Nama Agen</p>
                <p class="text-base font-bold text-gray-800">{{ $agen->nama_agen }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-blue-50 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500">
                <i class="fas fa-phone text-lg"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase">Nomor HP</p>
                <p class="text-base font-bold text-gray-800">{{ $agen->nomor_hp ?? '-' }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-blue-50 flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500">
                <i class="fas fa-shopping-bag text-lg"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase">Total Pembelian</p>
                <p class="text-base font-bold text-gray-800">{{ $riwayatPembelian->count() }} Transaksi</p>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-history text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Catatan Riwayat Pembelian</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Jenis Telur</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Detail Belanja</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($riwayatPembelian as $pembelian)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($pembelian->tanggal)->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-3">
                            @if($pembelian->jenis_telur === 'keduanya')
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                                    Grade A + B
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold
                                    {{ $pembelian->jenis_telur == 'layak' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $pembelian->jenis_telur == 'layak' ? 'Grade A' : 'Grade B' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($pembelian->jenis_telur === 'keduanya')
                                <div class="flex items-center gap-1 mb-0.5">
                                    <span class="text-[10px] font-bold text-emerald-600">A:</span>
                                    <span class="text-xs text-gray-600">{{ $pembelian->jumlah }} kg × Rp {{ number_format($pembelian->harga_perkilo,0,',','.') }} = <strong class="text-emerald-700">Rp {{ number_format($pembelian->total,0,',','.') }}</strong></span>
                                </div>
                                <div class="flex items-center gap-1 mb-0.5">
                                    <span class="text-[10px] font-bold text-amber-600">B:</span>
                                    <span class="text-xs text-gray-600">{{ $pembelian->jumlah_b }} kg × Rp {{ number_format($pembelian->harga_perkilo_b,0,',','.') }} = <strong class="text-amber-700">Rp {{ number_format($pembelian->total_b,0,',','.') }}</strong></span>
                                </div>
                                <div class="font-bold text-blue-700 text-sm border-t border-gray-100 pt-1">Rp {{ number_format(($pembelian->total + $pembelian->total_b),0,',','.') }}</div>
                            @else
                                <div class="font-bold text-blue-700">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</div>
                                <div class="text-[11px] text-gray-500 font-medium mt-0.5">
                                    {{ $pembelian->jumlah }} kg × Rp {{ number_format($pembelian->harga_perkilo, 0, ',', '.') }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($pembelian->status_pembayaran == 'kasbon')
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700 w-max">Kasbon</span>
                                    <span class="text-[10px] text-gray-500 font-semibold">Kurang: Rp {{ number_format($pembelian->kekurangan, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold bg-green-100 text-green-700">Lunas</span>
                            @endif
                        </td>
                        <td class="px-3 py-3">
                            <div class="flex flex-wrap items-center justify-start gap-1.5">
                                <a href="{{ route('penjualan.pdf', $pembelian->id) }}" target="_blank"
                                    class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 bg-blue-50 text-blue-700 text-[11px] font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 transition-all shadow-sm">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                                <button type="button" onclick="cetakStruk('{{ $pembelian->tanggal }}', '{{ addslashes($pembelian->pembeli) }}', {{ $pembelian->jumlah }}, {{ $pembelian->harga_perkilo }}, {{ $pembelian->total }}, '{{ $pembelian->status_pembayaran }}', {{ $pembelian->dibayar }}, {{ $pembelian->kekurangan }})"
                                    class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 bg-indigo-50 text-indigo-700 text-[11px] font-semibold rounded-lg border border-indigo-200 hover:bg-indigo-100 transition-all shadow-sm">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                                @if($pembelian->status_pembayaran == 'kasbon')
                                <button type="button" onclick="openBayarModal({{ $pembelian->id }}, {{ $pembelian->kekurangan }})"
                                    class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 bg-emerald-50 text-emerald-700 text-[11px] font-semibold rounded-lg border border-emerald-200 hover:bg-emerald-100 transition-all shadow-sm">
                                    <i class="fas fa-money-bill-wave"></i> Bayar
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat pembelian untuk agen ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Pelunasan --}}
<div id="bayarModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeBayarModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-emerald-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-money-bill-wave text-emerald-600"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        Pelunasan Kasbon
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Masukkan nominal untuk membayar kasbon. Sisa hutang saat ini: <span id="modal-kekurangan-text" class="font-bold text-red-600">Rp 0</span>.
                        </p>
                    </div>
                    <form id="modal-form-bayar" method="POST" class="mt-4">
                        @csrf
                        <div>
                            <label for="modal-input-bayar" class="block text-sm font-medium text-gray-700">Nominal Pembayaran (Rp)</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="tambah_bayar" id="modal-input-bayar" required min="1"
                                    class="block w-full pl-10 pr-12 py-3 border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm bg-gray-50 border transition-colors" placeholder="0">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Maksimal: <span id="modal-max-text">0</span></p>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-emerald-600 border border-transparent rounded-xl shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan Pembayaran
                            </button>
                            <button type="button" onclick="closeBayarModal()"
                                class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/rsvp@3.1.0/dist/rsvp.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.4/qz-tray.min.js"></script>
<script>
    const statusDot = document.getElementById('qz-status-dot');
    const printerSelect = document.getElementById('printer-select');

    // --- QZ Tray Logic ---
    function connectQZ() {
        qz.websocket.connect().then(() => {
            console.log("QZ Tray Terhubung!");
            statusDot.classList.replace('bg-yellow-500', 'bg-green-500');
            statusDot.classList.remove('animate-pulse');
            
            return qz.printers.find(); 
        }).then(printers => {
            printerSelect.innerHTML = '';
            printerSelect.disabled = false;
            
            printers.forEach(printer => {
                let option = document.createElement('option');
                option.value = printer;
                option.text = printer;
                if (printer.includes("MPT-II") || printer.toLowerCase().includes("thermal")) {
                    option.selected = true;
                }
                printerSelect.appendChild(option);
            });
        }).catch(err => {
            console.error("QZ Error:", err);
            statusDot.classList.replace('bg-yellow-500', 'bg-red-500');
            statusDot.classList.remove('animate-pulse');
            printerSelect.innerHTML = '<option>QZ Tray Tidak Jalan</option>';
        });
    }

    document.addEventListener('DOMContentLoaded', connectQZ);

    const bayarModal = document.getElementById('bayarModal');
    const modalFormBayar = document.getElementById('modal-form-bayar');
    const modalInputBayar = document.getElementById('modal-input-bayar');
    const modalKekuranganText = document.getElementById('modal-kekurangan-text');
    const modalMaxText = document.getElementById('modal-max-text');

    function openBayarModal(id, kekurangan) {
        modalFormBayar.action = `/penjualan/${id}/bayar`;
        modalInputBayar.max = kekurangan;
        modalInputBayar.value = '';
        modalKekuranganText.innerText = 'Rp ' + kekurangan.toLocaleString('id-ID');
        modalMaxText.innerText = 'Rp ' + kekurangan.toLocaleString('id-ID');
        bayarModal.classList.remove('hidden');
        setTimeout(() => modalInputBayar.focus(), 100);
    }

    function closeBayarModal() {
        bayarModal.classList.add('hidden');
    }

    function cetakStruk(tanggal, pembeli, qty, harga, total, status, dibayar, kekurangan) {
        const selectedPrinter = printerSelect.value;
        if (!selectedPrinter || selectedPrinter === 'Mencari printer...' || selectedPrinter === 'QZ Tray Tidak Jalan') {
            alert("Printer belum siap atau QZ Tray tidak berjalan!");
            return;
        }

        const config = qz.configs.create(selectedPrinter, { encoding: 'UTF-8' });

        const ESC = '\x1B', INIT = ESC + '@', CENTER = ESC + 'a' + '\x01', LEFT = ESC + 'a' + '\x00', BOLD_ON = ESC + 'E' + '\x01', BOLD_OFF = ESC + 'E' + '\x00';

        let printData = [
            INIT, CENTER, BOLD_ON + "SITELUR POS\n" + BOLD_OFF,
            "Peternakan Ayam Petelur\n",
            "================================\n",
            LEFT, 
            "Waktu   : " + tanggal + "\n", 
            "Pembeli : " + pembeli + "\n",
            "--------------------------------\n"
        ];

        printData.push("Telur Ayam (" + qty + " kg)\n");
        printData.push(qty + " x Rp " + harga.toLocaleString('id-ID') + " = Rp " + total.toLocaleString('id-ID') + "\n");

        printData.push("--------------------------------\n");
        printData.push(BOLD_ON + "TOTAL   : Rp " + total.toLocaleString('id-ID') + "\n" + BOLD_OFF);
        
        printData.push("--------------------------------\n");
        printData.push("Status  : " + status.toUpperCase() + "\n");
        if (status === 'kasbon') {
            printData.push("Dibayar : Rp " + dibayar.toLocaleString('id-ID') + "\n");
            printData.push(BOLD_ON + "Kurang  : Rp " + kekurangan.toLocaleString('id-ID') + "\n" + BOLD_OFF);
        }
        
        printData.push("================================\n");
        printData.push(CENTER, "Terima Kasih\n\n\n\n");

        qz.print(config, printData).catch(err => {
            alert("Gagal mencetak: " + err.message);
        });
    }
</script>
@endpush
@endsection
