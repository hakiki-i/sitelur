<section>
    <p class="text-sm text-gray-500 mb-5">Perbarui informasi profil dan alamat email akun Anda.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama</label>
            <input id="name" name="name" type="text"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
            @if($errors->get('name'))
                <p class="mt-1 text-xs text-red-500">{{ implode(', ', $errors->get('name')) }}</p>
            @endif
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Email</label>
            <input id="email" name="email" type="email"
                value="{{ old('email', $user->email) }}" required autocomplete="username"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
            @if($errors->get('email'))
                <p class="mt-1 text-xs text-red-500">{{ implode(', ', $errors->get('email')) }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-700">
                    Alamat email Anda belum diverifikasi.
                    <button form="send-verification" class="underline font-semibold ml-1 hover:text-amber-900">
                        Kirim ulang email verifikasi.
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 font-medium text-blue-600">Link verifikasi baru telah dikirim.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all text-sm">
                <i class="fas fa-save mr-1.5"></i> Simpan
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-blue-600 font-medium">
                    <i class="fas fa-check-circle mr-1"></i> Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>
