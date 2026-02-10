<x-app-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
        .table-spaced { border-separate: separate; border-spacing: 0 0.75rem; }
    </style>

    <div x-data="{ 
        openEdit: false, 
        isAddition: true, 
        currentStock: { id: '', name: '', qty: '' } 
    }" class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success') || session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 class="fixed top-24 right-10 z-[200] transform transition-all">
                <div class="bg-white border-l-4 {{ session('success') ? 'border-emerald-500' : 'border-rose-500' }} shadow-2xl rounded-2xl p-5 flex items-center gap-4 min-w-[300px]">
                    <div class="{{ session('success') ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }} p-2 rounded-full text-lg">
                        {{ session('success') ? '✅' : '⚠️' }}
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
                <div class="glass-card rounded-[2.5rem] p-8 shadow-xl sticky top-24">
                    <h2 class="text-2xl font-black text-slate-800 mb-6 tracking-tight">Nouvel Article</h2>
                    <form action="{{ route('stock.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Désignation</label>
                            <input type="text" name="designation" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-semibold" placeholder="ex: Clavier USB" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Catégorie</label>
                            <select name="categorie" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none cursor-pointer font-bold text-slate-700">
                                <option value="Vidéo">📺 Vidéo / Affichage</option>
                                <option value="Périphérique">🖱️ Périphérique</option>
                                <option value="Réseau">🌐 Réseau</option>
                                <option value="Alimentation">🔌 Alimentation</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Initial</label>
                                <input type="number" name="quantite" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-bold text-center" value="0">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Alerte</label>
                                <input type="number" name="seuil_alerte" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-bold text-center text-rose-500" value="5">
                            </div>
                        </div>
                        <button type="submit" class="w-full btn-grad text-white font-black py-4 rounded-2xl shadow-xl hover:shadow-indigo-300 transition-all active:scale-95 uppercase tracking-widest text-xs">
                            Enregistrer l'article
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="px-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-slate-800 text-2xl tracking-tight italic">Inventaire <span class="text-indigo-600">LFILM</span></h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-spaced">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-[0.2em] font-black">
                                    <th class="px-6 py-2 text-left">Désignation</th>
                                    <th class="px-6 py-2 text-center">Quantité</th>
                                    <th class="px-6 py-2 text-right">Actions de Flux</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock)
                                @php $alerte = $stock->quantite <= $stock->seuil_alerte; @endphp
                                <tr class="group bg-white hover:bg-slate-50/50 transition-all duration-300 shadow-sm">
                                    <td class="px-6 py-5 first:rounded-l-[2rem] border-y border-l border-slate-100">
                                        <div class="text-slate-800 font-black text-sm">{{ $stock->designation }}</div>
                                        <div class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest italic">{{ $stock->categorie }}</div>
                                    </td>

                                    <td class="px-6 py-5 border-y border-slate-100 text-center">
                                        <span class="text-2xl font-black {{ $alerte ? 'text-rose-500 animate-pulse' : 'text-slate-700' }}">
                                            {{ $stock->quantite }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 last:rounded-r-[2rem] border-y border-r border-slate-100 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <button @click="openEdit = true; isAddition = false; currentStock = { id: '{{ $stock->id }}', name: '{{ addslashes($stock->designation) }}', qty: '{{ $stock->quantite }}' }" 
                                                    class="h-11 px-4 bg-rose-50 text-rose-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all border border-rose-100">
                                                🔻 Sortie
                                            </button>

                                            <button @click="openEdit = true; isAddition = true; currentStock = { id: '{{ $stock->id }}', name: '{{ addslashes($stock->designation) }}', qty: '{{ $stock->quantite }}' }" 
                                                    class="h-11 px-4 bg-emerald-50 text-emerald-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all border border-emerald-100">
                                                ➕ Entrée
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openEdit" 
             class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-md"
             x-transition x-cloak>
            
            <div @click.away="openEdit = false" 
                 class="bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-10 border border-white/20 relative overflow-hidden">
                
                <div class="absolute top-0 left-0 w-full h-2 transition-colors duration-500"
                     :class="isAddition ? 'bg-emerald-500' : 'bg-rose-500'"></div>

                <div class="text-center mb-8">
                    <div class="h-16 w-16 rounded-3xl flex items-center justify-center text-2xl mx-auto mb-4 shadow-xl transition-all"
                         :class="isAddition ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'">
                        <span x-text="isAddition ? '📥' : '📤'"></span>
                    </div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter" x-text="isAddition ? 'Ajouter au Stock' : 'Retirer du Stock'"></h2>
                    <p class="text-indigo-500 font-bold uppercase tracking-widest text-[10px] mt-2" x-text="currentStock.name"></p>
                    
                    <div class="mt-4 inline-flex items-center gap-2 px-4 py-1.5 bg-slate-100 rounded-full">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Actuellement :</span>
                        <span class="text-sm font-black text-slate-700" x-text="currentStock.qty"></span>
                    </div>
                </div>

                <form :action="'/stock/' + currentStock.id" method="POST" x-ref="moveForm">
                    @csrf @method('PATCH')
                    
                    <div class="mb-8 p-6 bg-slate-50 rounded-[2.5rem] border-2 border-slate-100 transition-all"
                         :class="isAddition ? 'focus-within:border-emerald-500/20' : 'focus-within:border-rose-500/20'">
                        
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 text-center">
                            Quantité à <span x-text="isAddition ? 'ajouter' : 'déduire'"></span>
                        </label>
                        
                        <div class="relative">
                            <input type="number" id="qty_input" name="quantite_visuelle" placeholder="0" autofocus required
                                   class="w-full bg-white border-none rounded-2xl px-6 py-6 text-5xl font-black text-center text-slate-800 outline-none shadow-inner focus:ring-0">
                            
                            <input type="hidden" name="quantite" id="final_qty">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" @click="openEdit = false" 
                                class="flex-1 py-4 font-black text-slate-400 uppercase text-[10px] tracking-widest">Annuler</button>
                        
                        <button type="submit" 
                                @click.prevent="
                                    let val = document.getElementById('qty_input').value;
                                    document.getElementById('final_qty').value = isAddition ? val : -val;
                                    $refs.moveForm.submit();
                                "
                                class="flex-1 py-4 text-white font-black rounded-2xl shadow-xl transition active:scale-95 uppercase text-[10px] tracking-widest"
                                :class="isAddition ? 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200' : 'bg-rose-600 hover:bg-rose-700 shadow-rose-200'">
                            Confirmer <span x-text="isAddition ? 'L\'Entrée' : 'La Sortie'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>