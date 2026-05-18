<section>
    <p class="text-sm text-gray-500 mb-5">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
            @if($errors->updatePassword->get('current_password'))
                <p class="mt-1 text-xs text-red-500">{{ implode(', ', $errors->updatePassword->get('current_password')) }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Password Baru</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
            @if($errors->updatePassword->get('password'))
                <p class="mt-1 text-xs text-red-500">{{ implode(', ', $errors->updatePassword->get('password')) }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="mt-1 text-xs text-red-500">{{ implode(', ', $errors->updatePassword->get('password_confirmation')) }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all text-sm">
                <i class="fas fa-key mr-1.5"></i> Ubah Password
            </button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-blue-600 font-medium">
                    <i class="fas fa-check-circle mr-1"></i> Password berhasil diubah.
                </p>
            @endif
        </div>
    </form>
</section>
