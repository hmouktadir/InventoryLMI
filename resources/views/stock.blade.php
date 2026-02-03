<x-app-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ openEdit: false, currentStock: { id: '', name: '', qty: '' } }" class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 class="fixed top-24 right-10 z-[200] transform transition-all">
                <div class="bg-white border-l-4 border-emerald-500 shadow-2xl rounded-2xl p-5 flex items-center gap-4">
                    <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-card rounded-3xl p-8 shadow-xl sticky top-24">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Ajouter un article</h2>
                    <form action="{{ route('stock.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Désignation</label>
                            <input type="text" name="designation" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 outline-none" placeholder="ex: Câble HDMI 2m" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Catégorie</label>
                            <select name="categorie" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none cursor-pointer">
                                <option value="Vidéo">Vidéo / Affichage</option>
                                <option value="Périphérique">Périphérique</option>
                                <option value="Réseau">Réseau</option>
                                <option value="Alimentation">Alimentation</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Quantité</label>
                                <input type="number" name="quantite" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none" value="0" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Seuil Alerte</label>
                                <input type="number" name="seuil_alerte" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none" value="5" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full btn-grad text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-indigo-300 transition-all active:scale-95">
                            Enregistrer l'article
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Inventaire Consommables</h3>
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Mise à jour en direct</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-widest border-b border-slate-50">
                                    <th class="px-8 py-4">Désignation</th>
                                    <th class="px-8 py-4 text-center">En Stock</th>
                                    <th class="px-8 py-4 text-center">Date d'Ajout</th>
                                    <th class="px-8 py-4 text-center">Actions</th>
                                    <th class="px-8 py-4 text-right">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($stocks as $stock)
                                    @php $alerte = $stock->quantite <= $stock->seuil_alerte; @endphp
                                    <tr class="hover:bg-slate-50/80 transition-all">
                                        <td class="px-8 py-5">
                                            <div class="text-slate-700 font-bold text-sm">{{ $stock->designation }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold uppercase">{{ $stock->categorie }}</div>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="text-lg font-black {{ $alerte ? 'text-red-500' : 'text-slate-700' }}">
                                                {{ $stock->quantite }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <div class="text-xs font-bold text-slate-500">
                                                {{ $stock->created_at->format('d/m/Y') }}
                                            </div>
                                            <div class="text-[10px] text-slate-300">
                                                {{ $stock->created_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" 
                                                    @click="openEdit = true; currentStock = { id: '{{ $stock->id }}', name: '{{ addslashes($stock->designation) }}', qty: '{{ $stock->quantite }}' }"
                                                    class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                                    ✏️
                                                </button>

                                                <form action="{{ route('stock.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            @if($alerte)
                                                <span class="bg-red-100 text-red-600 text-[9px] font-black px-2 py-1 rounded-full uppercase animate-pulse">Réapprovisionner</span>
                                            @else
                                                <span class="bg-emerald-100 text-emerald-600 text-[9px] font-black px-2 py-1 rounded-full uppercase">✓ OK</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold">Aucun article en stock.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openEdit" 
             class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             x-transition x-cloak>
            
            <div @click.away="openEdit = false" 
                 class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 transform transition-all border border-slate-100">
                
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-black text-slate-800">Modifier le stock</h2>
                        <p class="text-sm text-indigo-500 font-bold" x-text="currentStock.name"></p>
                    </div>
                    <button @click="openEdit = false" class="text-slate-400 hover:text-slate-600 font-bold text-xl">✕</button>
                </div>

                <form :action="'/stock/' + currentStock.id" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-8">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Quantité en stock</label>
                        <div class="relative">
                            <input type="number" name="quantite" x-model="currentStock.qty" 
                                   class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-indigo-500/10 text-3xl font-black text-slate-800 outline-none transition-all">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 font-bold">UNITÉS</div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" @click="openEdit = false" 
                                class="flex-1 py-4 font-bold text-slate-500 hover:bg-slate-50 rounded-2xl transition">Annuler</button>
                        <button type="submit" 
                                class="flex-1 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition active:scale-95">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>
</x-app-layout>