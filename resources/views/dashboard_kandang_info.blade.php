<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-2">
    @foreach($kandangList as $kandang)
    <div class="bg-white rounded-2xl border border-blue-50 shadow-sm overflow-hidden hover:-translate-y-1 transition-transform duration-200">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-3 flex items-center gap-2">
            <i class="fas fa-warehouse text-white/80 text-sm"></i>
            <span class="font-bold text-white text-sm tracking-wide">{{ $kandang->nama_kandang }}</span>
        </div>
        <!-- Card Body -->
        <div class="p-4 space-y-3">

            <!-- Jumlah Ayam -->
            <div class="flex items-center gap-3 pb-3 border-b border-dashed border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-drumstick-bite text-blue-500 text-base"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Jumlah Ayam</p>
                    <p class="text-lg font-extrabold text-gray-800 leading-tight">{{ $kandang->jumlah_ayam }}</p>
                </div>
            </div>

            <!-- Umur Ayam -->
            <div class="flex items-center gap-3 pb-3 border-b border-dashed border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-birthday-cake text-indigo-500 text-base"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Umur Ayam Tertua</p>
                    <p class="text-lg font-extrabold text-gray-800 leading-tight">{{ $kandang->umur_tertua }}</p>
                </div>
            </div>

            <!-- Produksi Hari Ini -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-egg text-sky-500 text-base"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Produksi Hari Ini</p>
                    <p class="text-lg font-extrabold text-gray-800 leading-tight">{{ $kandang->produksi_hari_ini }}</p>
                </div>
            </div>

        </div>
    </div>
    @endforeach
</div>
