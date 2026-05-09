function printNotaQZ(penjualan) {
    qz.websocket.connect().then(() => {
        return qz.printers.find(); // Pilih printer default, atau ganti dengan nama printer
    }).then(printer => {
        let nota = `TOKO TELUR MAKMUR\n` +
            `Invoice: ${penjualan.id}\n` +
            `Tanggal: ${new Date(penjualan.tanggal).toLocaleString('id-ID')}\n` +
            `Pembeli: ${penjualan.pembeli}\n` +
            `--------------------------\n` +
            `Telur ${penjualan.jenis_telur.charAt(0).toUpperCase() + penjualan.jenis_telur.slice(1)}\n` +
            `${penjualan.jumlah} x ${formatRupiah(penjualan.harga_perkilo)}\n` +
            `--------------------------\n` +
            `TOTAL: Rp ${formatRupiah(penjualan.total)}\n` +
            `Pembayaran: CASH\n` +
            `--------------------------\n` +
            `Terima kasih\n`;
        let config = qz.configs.create(printer, {encoding: 'UTF-8'});
        return qz.print(config, [{type: 'raw', format: 'plain', data: nota}]);
    }).catch(err => {
        alert('Printer tidak terdeteksi atau QZ Tray belum aktif: ' + err);
    });
}
function formatRupiah(angka) {
    return angka.toLocaleString('id-ID');
}
