<x-app-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
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
                                <option value="à remplacer" selected>à remplacer</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full btn-grad text-white font-bold py-4 rounded-xl shadow-lg hover:opacity-90 transition-all">
                            Affecter à la salle
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    
                    <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center bg-slate-50/50 gap-4">
                        <h3 class="font-bold text-slate-800 text-lg italic">Inventaire des Salles</h3>
    
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">🔍</span>
                            <input 
                                x-model="search" 
                                type="text" 
                                placeholder="Chercher salle, objet, tech..." 
                                class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold outline-none focus:ring-4 focus:ring-indigo-500/10 transition-all"
                            >
                        </div>
                        <a href="{{ route('salles.export') }}" 
                            class="flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white text-xs font-black uppercase rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-600 transition-all active:scale-95">
                            <span class="text-lg">📊</span> Exporter Excel
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-widest border-b border-slate-50">
                                    <th class="px-8 py-4">Date & Salle</th>
                                    <th class="px-8 py-4">Matériel</th>
                                    <th class="px-8 py-4">Technicien</th>
                                    <th class="px-8 py-4 text-center">État</th>
                                    <th class="px-8 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($equipements as $equip)
                                <tr class="hover:bg-slate-50 transition-all"
                                    x-show="search === '' || 
                                           '{{ strtolower($equip->nom_salle) }}'.includes(search.toLowerCase()) || 
                                           '{{ strtolower($equip->materiel) }}'.includes(search.toLowerCase()) || 
                                           '{{ strtolower($equip->technicien) }}'.includes(search.toLowerCase())">
                                    
                                    <td class="px-8 py-5">
                                        <div class="text-[10px] text-slate-400 font-bold">{{ $equip->created_at->format('d/m/Y') }}</div>
                                        <div class="text-slate-700 font-bold text-sm">{{ $equip->nom_salle }}</div>
                                    </td>
                                    
                                    <td class="px-8 py-5">
                                        <div class="text-slate-600 text-sm font-medium">{{ $equip->materiel }}</div>
                                    </td>
                                    
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-2">
                                            <div class="h-7 w-7 rounded-full bg-indigo-50 flex items-center justify-center text-[10px] font-bold text-indigo-500 border border-indigo-100">
                                                👤
                                            </div>
                                            <span class="text-slate-600 text-sm font-bold">{{ $equip->technicien ?? 'Non assigné' }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase 
                                            {{ $equip->etat == 'Fonctionnel' ? 'bg-emerald-100 text-emerald-600' : 'bg-indigo-100 text-indigo-600' }}">
                                            {{ $equip->etat }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-8 py-5 text-right flex justify-end gap-2">
                                        <button @click="openEdit = true; currentEquip = { id: '{{ $equip->id }}', salle: '{{ addslashes($equip->nom_salle) }}', materiel: '{{ addslashes($equip->materiel) }}', etat: '{{ $equip->etat }}' }" 
                                                class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors">✏️</button>
                                        
                                        <form action="{{ route('salles.destroy', $equip->id) }}" method="POST" onsubmit="return confirm('Supprimer cet équipement ?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-medium italic">
                                        Aucun équipement enregistré pour le moment.
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
            <div @click.away="openEdit = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 border border-white/20">
                <h2 class="text-xl font-bold text-slate-800 mb-1 text-center">Mise à jour</h2>
                <p class="text-sm text-center text-indigo-500 font-black mb-6 uppercase tracking-widest" x-text="currentEquip.salle"></p>

                <form :action="'/salles/' + currentEquip.id" method="POST">
                    @csrf @method('PATCH')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Désignation Matériel</label>
                            <input type="text" name="materiel" x-model="currentEquip.materiel" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500/20">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">État actuel</label>
                            <select name="etat" x-model="currentEquip.etat" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 outline-none font-bold text-slate-700">
                                <option value="Fonctionnel">Fonctionnel</option>
                                <option value="A été remplacé">A été remplacé</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-8">
                        <button type="button" @click="openEdit = false" class="flex-1 py-3 font-bold text-slate-400 hover:text-slate-600 transition-colors">Annuler</button>
                        <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>