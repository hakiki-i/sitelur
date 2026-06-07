@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Penjualan</h2>
            <p class="text-sm text-gray-400 mt-0.5">Riwayat penjualan telur ayam</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl border border-blue-100 shadow-sm">
                <span id="qz-status-dot" class="w-3 h-3 rounded-full bg-yellow-500 shadow animate-pulse"></span>
                <select id="printer-select" class="bg-transparent text-sm text-gray-700 outline-none cursor-pointer max-w-[150px] truncate" disabled>
                    <option>Mencari printer...</option>
                </select>
            </div>
            
            <a href="{{ route('penjualan.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-md hover:from-blue-700 hover:to-indigo-700 hover:-translate-y-0.5 transition-all duration-200">
                <i class="fas fa-plus text-xs"></i> Tambah Penjualan
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 mb-5 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm">
            <i class="fas fa-check-circle text-blue-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-shopping-cart text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Daftar Penjualan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Pembeli</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Jenis Pembeli</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Detail Belanja</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Keterangan</th>
                        <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($penjualan as $p)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->tanggal }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $p->pembeli }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold
                                {{ $p->jenis_pembeli == 'Agen' ? 'bg-blue-100 text-blue-700' : ($p->jenis_pembeli == 'Toko' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600') }}">
                                {{ $p->jenis_pembeli }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1.5 mb-0.5">
                                <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold
                                    {{ $p->jenis_telur == 'layak' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $p->jenis_telur == 'layak' ? 'Grade A' : 'Grade B' }}
                                </span>
                            </div>
                            <div class="font-bold text-blue-700">Rp {{ number_format($p->total,0,',','.') }}</div>
                            <div class="text-[11px] text-gray-500 font-medium mt-0.5">
                                {{ $p->jumlah }} kg × Rp {{ number_format($p->harga_perkilo,0,',','.') }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($p->status_pembayaran == 'kasbon')
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700 w-max">Kasbon</span>
                                    <span class="text-[10px] text-gray-500 font-semibold">Kurang: Rp {{ number_format($p->kekurangan, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold bg-green-100 text-green-700">Lunas</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500 max-w-xs truncate">{{ $p->keterangan ?? '-' }}</td>
                        <td class="px-3 py-3">
                            <div class="flex flex-wrap items-center justify-start gap-1.5">
                                <a href="{{ route('penjualan.pdf', $p->id) }}" target="_blank"
                                    class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 bg-blue-50 text-blue-700 text-[11px] font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 transition-all shadow-sm">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                                <button type="button" onclick="cetakStruk('{{ $p->tanggal }}', '{{ addslashes($p->pembeli) }}', {{ $p->jumlah }}, {{ $p->harga_perkilo }}, {{ $p->total }}, '{{ $p->status_pembayaran }}', {{ $p->dibayar }}, {{ $p->kekurangan }})"
                                    class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 bg-indigo-50 text-indigo-700 text-[11px] font-semibold rounded-lg border border-indigo-200 hover:bg-indigo-100 transition-all shadow-sm">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                                @if($p->status_pembayaran == 'kasbon')
                                <button type="button" onclick="openBayarModal({{ $p->id }}, {{ $p->kekurangan }})"
                                    class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 bg-emerald-50 text-emerald-700 text-[11px] font-semibold rounded-lg border border-emerald-200 hover:bg-emerald-100 transition-all shadow-sm">
                                    <i class="fas fa-money-bill-wave"></i> Bayar
                                </button>
                                @endif
                                @if($p->bukti_foto)
                                <a href="{{ Storage::url($p->bukti_foto) }}" target="_blank"
                                    class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 bg-purple-50 text-purple-700 text-[11px] font-semibold rounded-lg border border-purple-200 hover:bg-purple-100 transition-all shadow-sm" title="Lihat Bukti Foto">
                                    <i class="fas fa-image"></i> Bukti
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
            <form method="get" class="flex items-center gap-2 text-sm text-gray-500">
                <span>Tampil</span>
                <select name="perPage" onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="10" {{ request('perPage', $perPage ?? 25) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage', $perPage ?? 25) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage', $perPage ?? 25) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('perPage', $perPage ?? 25) == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>data</span>
            </form>
            <div>{!! $penjualan->links('pagination::bootstrap-5') !!}</div>
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
            
            // Coba ambil SEMUA printer yang terdaftar
            return qz.printers.find();
        }).then(printers => {
            printerSelect.innerHTML = '';
            printerSelect.disabled = false;

            // Jika printers adalah string (hanya 1 printer), bungkus jadi array
            if (typeof printers === 'string') {
                printers = [printers];
            }

            console.log("Printer ditemukan:", printers);

            if (!printers || printers.length === 0) {
                // Tidak ada printer ditemukan, coba ambil printer default
                return qz.printers.getDefault().then(defaultPrinter => {
                    if (defaultPrinter) {
                        let option = document.createElement('option');
                        option.value = defaultPrinter;
                        option.text = defaultPrinter + " (Default)";
                        option.selected = true;
                        printerSelect.appendChild(option);
                    } else {
                        printerSelect.innerHTML = '<option value="">-- Tidak ada printer --</option>';
                        alert("QZ Tray terhubung, namun tidak ada printer yang terinstall di komputer ini.\nSilakan install driver printer terlebih dahulu.");
                    }
                });
            }

            // Tampilkan semua printer (tanpa filter)
            printers.forEach(printer => {
                let option = document.createElement('option');
                option.value = printer;
                option.text = printer;
                // Auto-pilih printer thermal jika ada
                if (printer.includes("MPT-II") || printer.toLowerCase().includes("thermal") || printer.toLowerCase().includes("pos")) {
                    option.selected = true;
                }
                printerSelect.appendChild(option);
            });

        }).catch(err => {
            console.error("QZ Error:", err);
            statusDot.classList.replace('bg-yellow-500', 'bg-red-500');
            statusDot.classList.remove('animate-pulse');
            printerSelect.innerHTML = '<option>QZ Tray Tidak Jalan</option>';
            console.warn("Pastikan aplikasi QZ Tray sudah dibuka dan Anda mengklik ALLOW saat ada popup di browser.");
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
