<section class="space-y-5">
    <p class="text-sm text-gray-500">
        Setelah akun Anda dihapus, semua data dan sumber daya yang terkait akan dihapus secara permanen.
        Sebelum menghapus, pastikan sudah menyimpan data penting Anda.
    </p>

    {{-- Trigger Button --}}
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-100 text-red-700 font-bold text-sm rounded-xl hover:bg-red-200 transition-colors">
        <i class="fas fa-trash-alt text-xs"></i> Hapus Akun
    </button>

    {{-- Modal --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Hapus Akun?</h2>
            </div>

            <p class="text-sm text-gray-600 mb-5">
                Tindakan ini tidak dapat dibatalkan. Semua data akan dihapus permanen. Masukkan password untuk konfirmasi.
            </p>

            <div class="mb-5">
                <label for="del_password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Password</label>
                <input id="del_password" name="password" type="password" placeholder="Masukkan password Anda"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent focus:bg-white transition-all">
                @if($errors->userDeletion->get('password'))
                    <p class="mt-1 text-xs text-red-500">{{ implode(', ', $errors->userDeletion->get('password')) }}</p>
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl text-sm transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm transition-colors">
                    <i class="fas fa-trash-alt mr-1.5"></i> Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
