<x-app-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success'))
            <div id="success-alert" 
                class="fixed top-24 right-10 z-50 transform transition-all duration-500 ease-out translate-x-full opacity-0">
                <div class="bg-white border-l-4 border-emerald-500 shadow-2xl rounded-2xl p-5 flex items-center gap-4 min-w-[300px]">
                    <div class="bg-emerald-100 p-2 rounded-full">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Notification</p>
                        <p class="text-sm font-bold text-slate-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-card rounded-3xl p-8 shadow-xl shadow-slate-200/50 sticky top-24">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Nouvelle affectation</h2>
                    <form action="{{ route('prets.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Employé bénéficiaire</label>
                            <input type="text" name="employe" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-300" placeholder="Nom complet" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Site de destination</label>
                            <select name="site" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all shadow-inner appearance-none cursor-pointer text-slate-700 font-semibold" required>
                                <option value="" disabled selected>Choisir un site...</option>
                                <option value="Lycée">Lycée</option>
                                <option value="Collège">Collège</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Type de matériel</label>
                            <select name="accessoire" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all shadow-inner appearance-none cursor-pointer text-slate-700 font-semibold" required>
                                <option value="" disabled selected>Choisir un accessoire...</option>
                                <option value="Souris">Souris</option>
                                <option value="Clavier">⌨️ Clavier</option>
                                <option value="Câble HDMI">📺 Câble HDMI</option>
                                <option value="Adaptateur HDMI">🔌 Adaptateur HDMI</option>
                                <option value="Docking Station">🔌 Station d'accueil</option>
                                <option value="Câble Type-C">⚡ Câble Type-C</option>
                                <option value="Caméra">📷 Caméra</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Numéro de série</label>
                            <input type="text" name="numero_serie" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-300">
                        </div>

                        <button type="submit" class="w-full btn-grad text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-indigo-300 transition-all active:scale-[0.98]">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    
                    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-bold text-slate-800">Prêts actifs</h3>
                        <span class="bg-indigo-600 text-white text-xs px-3 py-1.5 rounded-full font-bold">
                            {{ $prets->count() }} Matériel(s)
                        </span>
                    </div>

                    <div class="px-8 py-4 border-b border-slate-100 bg-white">
                        <form action="{{ route('prets.index') }}" method="GET" class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Trouver un employé ou un matériel..." 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-4 py-2.5 text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-widest border-b border-slate-50">
                                    <th class="px-8 py-4 font-bold">Bénéficiaire</th>
                                    <th class="px-8 py-4 font-bold">Localisation</th>
                                    <th class="px-8 py-4 font-bold">Équipement</th>
                                    <th class="px-8 py-4 font-bold text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($prets as $pret)
                                    @php
                                        $jours = \Carbon\Carbon::parse($pret->date_affectation)->diffInDays(now());
                                        $alerte = $jours >= 7;
                                    @endphp
                                    <tr class="group transition-all {{ $alerte ? 'bg-yellow-50/70 border-l-4 border-yellow-400' : 'hover:bg-slate-50/80 border-l-4 border-transparent' }}">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-xl text-white flex items-center justify-center font-bold shadow-sm mr-4 text-xs 
                                                    {{ $alerte ? 'bg-yellow-500 shadow-yellow-200' : 'bg-gradient-to-br from-indigo-500 to-purple-600 shadow-indigo-100' }}">
                                                    {{ substr($pret->employe, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-slate-700 font-bold text-sm">{{ $pret->employe }}</div>
                                                    <div class="text-[10px] flex items-center mt-0.5 uppercase font-bold {{ $alerte ? 'text-yellow-700' : 'text-slate-400' }}">
                                                        {{ \Carbon\Carbon::parse($pret->date_affectation)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tight
                                                {{ $pret->site == 'Lycée' ? 'bg-purple-100 text-purple-600' : '' }}
                                                {{ $pret->site == 'Collège' ? 'bg-blue-100 text-blue-600' : '' }}
                                                {{ $pret->site == 'B1' ? 'bg-orange-100 text-orange-600' : '' }}
                                                {{ $pret->site == 'B2' ? 'bg-pink-100 text-pink-600' : '' }}">
                                                {{ $pret->site ?? 'Non défini' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="text-slate-700 font-medium text-sm">{{ $pret->accessoire }}</div>
                                            <code class="text-[9px] bg-slate-100 px-1.5 py-0.5 rounded text-slate-500 font-mono">{{ $pret->numero_serie ?? 'SANS S/N' }}</code>
                                        </td>
                                        <td class="px-8 py-5 text-right flex justify-end gap-2">
                                            <form action="{{ route('prets.update', $pret->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-white text-emerald-600 border border-emerald-200 hover:bg-emerald-600 hover:text-white px-3 py-2 rounded-xl text-[10px] font-black transition-all shadow-sm">
                                                    CLÔTURER
                                                </button>
                                            </form>

                                            <form action="{{ route('prets.destroy', $pret->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-white text-red-500 border border-red-100 hover:bg-red-500 hover:text-white p-2 rounded-xl transition-all shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-20 text-center text-slate-400 font-medium">Aucun prêt actif trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('translate-x-full', 'opacity-0');
                    alert.classList.add('translate-x-0', 'opacity-100');
                }, 100);
                setTimeout(() => {
                    alert.classList.remove('translate-x-0', 'opacity-100');
                    alert.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }
        });
    </script>
</x-app-layout>