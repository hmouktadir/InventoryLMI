<x-guest-layout>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .btn-grad {
            background-image: linear-gradient(to right, #4f46e5 0%, #7c3aed 51%, #4f46e5 100%);
            background-size: 200% auto;
            transition: 0.5s;
        }
        .btn-grad:hover { background-position: right center; }
    </style>

    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-slate-800 tracking-tighter">CONNEXION</h2>
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Accès Inventaire IT</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Identifiant / Email</label>
            <x-text-input id="email" 
                class="block w-full bg-slate-50/50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 shadow-inner" 
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                placeholder="admin@entreprise.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-2 ml-1">
                <label for="password" class="block text-[10px] font-black uppercase text-slate-400 tracking-widest">Mot de passe</label>
            </div>
            <x-text-input id="password" 
                class="block w-full bg-slate-50/50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 shadow-inner"
                type="password"
                name="password"
                required autocomplete="current-password" 
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold" />
        </div>

        <div class="flex items-center justify-between px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-[11px] font-bold text-slate-500 uppercase">{{ __('Se souvenir') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-[11px] font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-tighter transition-all" href="{{ route('password.request') }}">
                    {{ __('Oublié ?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full btn-grad text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 uppercase tracking-widest text-xs active:scale-[0.98] transition-all">
                {{ __('Se connecter') }}
            </button>
        </div>
    </form>
</x-guest-layout>