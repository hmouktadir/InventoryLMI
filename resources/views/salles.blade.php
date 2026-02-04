<x-app-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
        /* Style pour espacer les lignes du tableau */
        .table-spaced { border-separate: separate; border-spacing: 0 0.75rem; }
    </style>

    <div x-data="{ 
            search: '', 
            openEdit: false, 
            currentEquip: { id: '', salle: '', materiel: '', etat: '' } 
         }" 
         class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-card rounded-3xl p-8 shadow-xl sticky top-24">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Équiper une salle</h2>
                    <form action="{{ route('salles.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nom de la salle</label>
                            <input type="text" name="nom_salle" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-4 focus:ring-indigo-500/10" placeholder="ex: Salle 101" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Localisation (Site)</label>
                            <select name="site" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-4 focus:ring-indigo-500/10 font-bold text-slate-700" required>
                                <option value="" disabled selected>Choisir un site...</option>
                                <option value="Lycée">Lycée</option>
                                <option value="Collège">Collège</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Matériel</label>
                            <select name="materiel" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none" required>
                                <option value="" disabled selected>Choisir un article...</option>
                                @foreach($articlesDisponibles as $article)
                                    <option value="{{ $article->designation }}">
                                        {{ $article->designation }} (Stock: {{ $article->quantite }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-indigo-500 uppercase tracking-widest mb-2">État initial</label>
                            <select name="etat" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 outline-none font-bold text-slate-700 pointer-events-none appearance-none">
                                <option value="a été remplacée" selected>a été remplacée</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full btn-grad text-white font-bold py-4 rounded-xl shadow-lg hover:opacity-90 transition-all">
                            Affecter à la salle
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="px-2">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="font-black text-slate-800 text-2xl tracking-tight">Inventaire <span class="text-indigo-600">Salles</span></h3>
                        
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <div class="relative flex-1 md:w-64">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">🔍</span>
                                <input x-model="search" type="text" placeholder="Filtrer..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-bold outline-none focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                            <a href="{{ route('salles.export') }}" 
                                class="p-2.5 bg-emerald-500 text-white rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-600 transition-all active:scale-95" title="Exporter Excel">
                                📊
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-spaced">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-[0.2em] font-black">
                                    <th class="px-6 py-2 text-left">📍 Salle</th>
                                    <th class="px-6 py-2 text-left">🖥️ Matériel</th>
                                    <th class="px-6 py-2 text-left">👤 Technicien</th>
                                    <th class="px-6 py-2 text-center">État</th>
                                    <th class="px-6 py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($equipements as $equip)
                                <tr class="group bg-white hover:bg-indigo-50/40 transition-all duration-300 shadow-sm hover:shadow-md"
                                    x-show="search === '' || '{{ strtolower($equip->nom_salle) }}'.includes(search.toLowerCase()) || '{{ strtolower($equip->materiel) }}'.includes(search.toLowerCase()) || '{{ strtolower($equip->technicien) }}'.includes(search.toLowerCase())">
                                    
                                    <td class="px-6 py-4 first:rounded-l-3xl border-y border-l border-slate-100 group-hover:border-indigo-100">
                                        <div class="text-[10px] text-indigo-400 font-black uppercase">{{ $equip->created_at->format('d/m/Y') }}</div>
                                        <div class="text-slate-800 font-black text-sm">{{ $equip->nom_salle }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 border-y border-slate-100 group-hover:border-indigo-100">
                                        <span class="text-slate-600 text-sm font-bold italic">{{ $equip->materiel }}</span>
                                    </td>
                                    
                                    <td class="px-6 py-4 border-y border-slate-100 group-hover:border-indigo-100">
                                        <div class="flex items-center gap-2">
                                            <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200 shadow-inner">👤</div>
                                            <span class="text-slate-700 text-xs font-black">{{ $equip->technicien ?? 'Système' }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 border-y border-slate-100 group-hover:border-indigo-100 text-center">
                                        @if($equip->etat == 'Fonctionnel')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-600 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                                FONCTIONNEL
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-600 border border-indigo-200">
                                                {{ strtoupper($equip->etat) }}
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 last:rounded-r-3xl border-y border-r border-slate-100 group-hover:border-indigo-100 text-right">
                                        <div class="flex justify-end gap-1">
                                            <button @click="openEdit = true; currentEquip = { id: '{{ $equip->id }}', salle: '{{ addslashes($equip->nom_salle) }}', materiel: '{{ addslashes($equip->materiel) }}', etat: '{{ $equip->etat }}' }" 
                                                    class="p-2 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-all">✏️</button>
                                            
                                            <form action="{{ route('salles.destroy', $equip->id) }}" method="POST" onsubmit="return confirm('Supprimer ?');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="text-slate-300 text-5xl mb-4 text-center">📂</div>
                                        <p class="text-slate-400 font-bold italic">Aucune donnée trouvée.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak x-transition>
            <div @click.away="openEdit = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-10 border border-white/20">
                <div class="text-center mb-8">
                    <div class="h-16 w-16 bg-indigo-100 text-indigo-600 rounded-3xl flex items-center justify-center text-2xl mx-auto mb-4">⚙️</div>
                    <h2 class="text-2xl font-black text-slate-800">Mise à jour</h2>
                    <p class="text-indigo-500 font-bold uppercase tracking-widest text-xs mt-2" x-text="currentEquip.salle"></p>
                </div>

                <form :action="'/salles/' + currentEquip.id" method="POST" class="space-y-6">
                    @csrf @method('PATCH')
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">Désignation Matériel</label>
                        <input type="text" name="materiel" x-model="currentEquip.materiel" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 outline-none focus:border-indigo-500/20 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">État actuel</label>
                        <select name="etat" x-model="currentEquip.etat" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 outline-none font-bold text-slate-700 focus:border-indigo-500/20 focus:bg-white transition-all">
                            <option value="Fonctionnel">Fonctionnel</option>
                            <option value="a été remplacée">a été remplacée</option>
                        </select>
                    </div>
                    
                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="openEdit = false" class="flex-1 py-4 font-black text-slate-400 hover:bg-slate-50 rounded-2xl transition-all">Annuler</button>
                        <button type="submit" class="flex-1 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-indigo-600 transition-all active:scale-95">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>