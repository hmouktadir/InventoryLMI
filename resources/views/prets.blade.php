<x-app-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
        .table-spaced { border-separate: separate; border-spacing: 0 0.75rem; }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success') || session('error'))
            <div id="status-alert" 
                class="fixed top-24 right-10 z-50 transform transition-all duration-500 ease-out translate-x-full opacity-0">
                <div class="bg-white border-l-4 {{ session('success') ? 'border-emerald-500' : 'border-rose-500' }} shadow-2xl rounded-2xl p-5 flex items-center gap-4 min-w-[300px]">
                    <div class="{{ session('success') ? 'bg-emerald-100' : 'bg-rose-100' }} p-2 rounded-full">
                        <svg class="w-6 h-6 {{ session('success') ? 'text-emerald-600' : 'text-rose-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ session('success') ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Système</p>
                        <p class="text-sm font-bold text-slate-700">{{ session('success') ?? session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-card rounded-3xl p-8 shadow-xl shadow-slate-200/50 sticky top-24">
                    <h2 class="text-xl font-black text-slate-800 mb-6 tracking-tighter italic">Nouvelle <span class="text-indigo-600">Affectation</span></h2>
                    <form action="{{ route('prets.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Bénéficiaire</label>
                            <input type="text" name="employe" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-semibold" placeholder="Nom de l'employé" required>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Site</label>
                            <select name="site" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-bold text-slate-700 appearance-none" required>
                                <option value="" disabled selected>Choisir un site...</option>
                                <option value="Lycée">🏢 Lycée</option>
                                <option value="Collège">🏫 Collège</option>
                                <option value="B1">📍 B1</option>
                                <option value="B2">📍 B2</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Matériel en Stock</label>
                            <select name="stock_id" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-bold text-slate-700" required>
                                <option value="" disabled selected>Choisir l'article...</option>
                                @foreach($stocks as $item)
                                    <option value="{{ $item->id }}" {{ $item->quantite <= 0 ? 'disabled' : '' }}>
                                        {{ $item->designation }} ({{ $item->quantite }} dispo)
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[9px] text-slate-400 mt-2 ml-1 italic">* Le stock sera déduit de 1 unité automatiquement.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Numéro de série (S/N)</label>
                            <input type="text" name="numero_serie" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-mono text-sm" placeholder="Optionnel">
                        </div>

                        <button type="submit" class="w-full btn-grad text-white font-black py-4 rounded-2xl shadow-xl hover:shadow-indigo-300 transition-all active:scale-95 uppercase tracking-widest text-xs">
                            Confirmer & Déduire Stock
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="px-2">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="font-black text-slate-800 text-2xl tracking-tight italic">Prêts <span class="text-indigo-600">Actifs</span></h3>
                        
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <form action="{{ route('prets.index') }}" method="GET" class="relative flex-1 md:w-72">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filtrer les prêts..." 
                                       class="w-full pl-11 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-bold outline-none focus:ring-4 focus:ring-indigo-500/10">
                                <span class="absolute left-4 top-3 text-slate-400">🔍</span>
                            </form>
                            <div class="bg-indigo-100 text-indigo-700 px-4 py-2.5 rounded-2xl font-black text-xs">
                                {{ $prets->count() }}
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-spaced">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-[0.2em] font-black">
                                    <th class="px-6 py-2 text-left">Bénéficiaire</th>
                                    <th class="px-6 py-2 text-left">Site</th>
                                    <th class="px-6 py-2 text-left">Équipement</th>
                                    <th class="px-6 py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prets as $pret)
                                    @php
                                        $jours = \Carbon\Carbon::parse($pret->date_affectation)->diffInDays(now());
                                        $alerte = $jours >= 7;
                                    @endphp
                                    <tr class="group bg-white hover:bg-indigo-50/40 transition-all duration-300 shadow-sm">
                                        <td class="px-6 py-4 first:rounded-l-3xl border-y border-l {{ $alerte ? 'border-amber-200 bg-amber-50/30' : 'border-slate-100' }}">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-xl text-white flex items-center justify-center font-black shadow-lg mr-4 text-xs 
                                                    {{ $alerte ? 'bg-amber-500 animate-pulse' : 'bg-slate-900 group-hover:bg-indigo-600 transition-all' }}">
                                                    {{ substr($pret->employe, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-slate-800 font-black text-sm">{{ $pret->employe }}</div>
                                                    <div class="text-[10px] uppercase font-black {{ $alerte ? 'text-amber-600' : 'text-slate-400' }}">
                                                        {{ \Carbon\Carbon::parse($pret->date_affectation)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 border-y {{ $alerte ? 'border-amber-200 bg-amber-50/30' : 'border-slate-100' }}">
                                            <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-600">
                                                {{ $pret->site }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 border-y {{ $alerte ? 'border-amber-200 bg-amber-50/30' : 'border-slate-100' }}">
                                            <div class="text-slate-700 font-bold text-sm italic">{{ $pret->accessoire }}</div>
                                            <div class="text-[9px] font-mono text-slate-400">SN: {{ $pret->numero_serie ?? 'n/a' }}</div>
                                        </td>

                                        <td class="px-6 py-4 last:rounded-r-3xl border-y border-r {{ $alerte ? 'border-amber-200 bg-amber-50/30' : 'border-slate-100' }} text-right">
                                            <div class="flex justify-end items-center gap-3">
                                                
                                                <a href="{{ route('prets.pdf', $pret->id) }}" 
                                                   class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white p-2.5 rounded-xl transition-all active:scale-95 group/pdf"
                                                   title="Télécharger Bon de Décharge"
                                                   target="_blank">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </a>

                                                <form action="{{ route('prets.update', $pret->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2.5 rounded-xl text-[10px] font-black transition-all shadow-lg shadow-emerald-100 active:scale-95 uppercase">
                                                        Rendre & Réappro
                                                    </button>
                                                </form>

                                                <form action="{{ route('prets.destroy', $pret->id) }}" method="POST" onsubmit="return confirm('Supprimer ce prêt ?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">🗑️</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-24 text-center">
                                            <div class="text-slate-200 text-6xl mb-4">🤝</div>
                                            <p class="text-slate-400 font-bold italic">Tout le matériel est en stock.</p>
                                        </td>
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
            const alert = document.getElementById('status-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('translate-x-full', 'opacity-0');
                    alert.classList.add('translate-x-0', 'opacity-100');
                }, 100);
                setTimeout(() => {
                    alert.classList.remove('translate-x-0', 'opacity-100');
                    alert.classList.add('translate-x-full', 'opacity-0');
                }, 3500);
            }
        });
    </script>
</x-app-layout>