<x-app-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
        .table-spaced { border-separate: separate; border-spacing: 0 0.75rem; }
    </style>

    <div x-data="{ openEdit: false, currentStock: { id: '', name: '', qty: '' } }" class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 class="fixed top-24 right-10 z-[200] transform transition-all">
                <div class="bg-white border-l-4 border-emerald-500 shadow-2xl rounded-2xl p-5 flex items-center gap-4 min-w-[300px]">
                    <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Système</p>
                        <p class="text-sm font-bold text-slate-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-card rounded-3xl p-8 shadow-xl sticky top-24">
                    <h2 class="text-xl font-black text-slate-800 mb-6 tracking-tight">Ajouter un article</h2>
                    <form action="{{ route('stock.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Désignation</label>
                            <input type="text" name="designation" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-semibold" placeholder="ex: Câble HDMI 2m" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Catégorie</label>
                            <select name="categorie" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none cursor-pointer font-bold text-slate-700">
                                <option value="Vidéo">📺 Vidéo / Affichage</option>
                                <option value="Périphérique">🖱️ Périphérique</option>
                                <option value="Réseau">🌐 Réseau</option>
                                <option value="Alimentation">🔌 Alimentation</option>
                                <option value="Autre">📦 Autre</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Quantité</label>
                                <input type="number" name="quantite" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-bold text-center" value="0" required>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Alerte</label>
                                <input type="number" name="seuil_alerte" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-bold text-center text-red-500" value="5" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full btn-grad text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 hover:shadow-indigo-300 transition-all active:scale-95 uppercase tracking-widest text-xs">
                            Enregistrer l'article
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="px-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-slate-800 text-2xl tracking-tight">Inventaire <span class="text-indigo-600">Stock</span></h3>
                        <div class="bg-white px-4 py-2 rounded-2xl border border-slate-100 shadow-sm text-[10px] font-black uppercase text-slate-400 tracking-widest">
                            Statut en temps réel
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-spaced">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-[0.2em] font-black">
                                    <th class="px-6 py-2 text-left">Désignation</th>
                                    <th class="px-6 py-2 text-center">Quantité</th>
                                    <th class="px-6 py-2 text-center">Date</th>
                                    <th class="px-6 py-2 text-right">Statut & Gestion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stocks as $stock)
                                    @php $alerte = $stock->quantite <= $stock->seuil_alerte; @endphp
                                    <tr class="group bg-white hover:bg-indigo-50/40 transition-all duration-300 shadow-sm hover:shadow-md">
                                        
                                        <td class="px-6 py-4 first:rounded-l-3xl border-y border-l border-slate-100 group-hover:border-indigo-100">
                                            <div class="text-slate-800 font-black text-sm">{{ $stock->designation }}</div>
                                            <div class="text-[10px] text-indigo-400 font-black uppercase tracking-tighter mt-0.5">{{ $stock->categorie }}</div>
                                        </td>

                                        <td class="px-6 py-4 border-y border-slate-100 group-hover:border-indigo-100 text-center">
                                            <span class="text-xl font-black {{ $alerte ? 'text-red-500 animate-pulse' : 'text-slate-700' }}">
                                                {{ $stock->quantite }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 border-y border-slate-100 group-hover:border-indigo-100 text-center">
                                            <div class="text-xs font-bold text-slate-500">{{ $stock->created_at->format('d/m/Y') }}</div>
                                            <div class="text-[10px] text-slate-300 font-bold uppercase">{{ $stock->created_at->format('H:i') }}</div>
                                        </td>

                                        <td class="px-6 py-4 last:rounded-r-3xl border-y border-r border-slate-100 group-hover:border-indigo-100 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                @if($alerte)
                                                    <span class="bg-red-50 text-red-600 text-[9px] font-black px-3 py-1.5 rounded-xl uppercase border border-red-100">Réappro!</span>
                                                @else
                                                    <span class="bg-emerald-50 text-emerald-600 text-[9px] font-black px-3 py-1.5 rounded-xl uppercase border border-emerald-100">✓ En Stock</span>
                                                @endif

                                                <button type="button" 
                                                    @click="openEdit = true; currentStock = { id: '{{ $stock->id }}', name: '{{ addslashes($stock->designation) }}', qty: '{{ $stock->quantite }}' }"
                                                    class="p-2.5 bg-slate-50 text-slate-400 rounded-xl hover:bg-amber-50 hover:text-amber-500 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                </button>

                                                <form action="{{ route('stock.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-20 text-center">
                                            <div class="text-slate-200 text-6xl mb-4">📦</div>
                                            <p class="text-slate-400 font-bold italic">Le stock est vide.</p>
                                        </td>
                                    </tr>
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
                 class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-10 border border-white/20">
                
                <div class="text-center mb-8">
                    <div class="h-16 w-16 bg-amber-100 text-amber-600 rounded-3xl flex items-center justify-center text-2xl mx-auto mb-4">🔄</div>
                    <h2 class="text-2xl font-black text-slate-800">Mise à jour Stock</h2>
                    <p class="text-indigo-500 font-bold uppercase tracking-widest text-[10px] mt-2" x-text="currentStock.name"></p>
                </div>

                <form :action="'/stock/' + currentStock.id" method="POST">
                    @csrf @method('PATCH')
                    
                    <div class="mb-8">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 text-center">Nouvelle Quantité</label>
                        <div class="relative">
                            <input type="number" name="quantite" x-model="currentStock.qty" 
                                   class="w-full bg-slate-50 border-2 border-slate-100 rounded-3xl px-6 py-6 focus:border-indigo-500/20 focus:bg-white text-4xl font-black text-center text-slate-800 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" @click="openEdit = false" 
                                class="flex-1 py-4 font-black text-slate-400 hover:bg-slate-50 rounded-2xl transition">Annuler</button>
                        <button type="submit" 
                                class="flex-1 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-indigo-600 transition active:scale-95">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>