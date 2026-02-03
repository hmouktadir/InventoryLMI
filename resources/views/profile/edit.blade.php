<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="glass-card rounded-3xl p-8 shadow-2xl border border-white/20 bg-white/80 backdrop-blur-lg">
            
            <div class="mb-8">
                <h1 class="text-2xl font-black text-slate-800">Mon Profil</h1>
                <p class="text-sm text-slate-500 font-medium">Gérez vos informations personnelles et votre sécurité.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 text-emerald-700 rounded-2xl font-bold text-sm flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Nom Complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 font-bold text-slate-700 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 font-bold text-slate-700 outline-none">
                    </div>
                </div>

                <hr class="border-slate-100 my-8">

                <div class="mb-4">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest text-red-500">Sécurité</h3>
                    <p class="text-[10px] text-slate-400 font-medium italic">Laissez vide si vous ne souhaitez pas changer de mot de passe.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Nouveau mot de passe</label>
                        <input type="password" name="password" 
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" 
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-5 rounded-2xl shadow-xl hover:bg-indigo-600 transition-all active:scale-95 duration-300">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>