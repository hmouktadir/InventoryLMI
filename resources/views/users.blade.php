<x-app-layout>
    <style>
        .table-spaced { border-separate: separate; border-spacing: 0 0.75rem; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        [x-cloak] { display: none !important; }
        .user-disabled { opacity: 0.6; filter: grayscale(0.6); }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>

    <div x-data="{ 
        openEdit: false, 
        search: '',
        currentUser: { id: '', name: '', email: '', role: '', is_active: true } 
    }" class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success') || session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 class="fixed top-24 right-10 z-[200] transform transition-all duration-500">
                <div class="bg-white border-l-4 {{ session('success') ? 'border-emerald-500' : 'border-rose-500' }} shadow-2xl rounded-2xl p-5 flex items-center gap-4 min-w-[300px]">
                    <div class="{{ session('success') ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }} p-2 rounded-full text-lg">
                        {{ session('success') ? '✅' : '❌' }}
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
                    <div class="h-12 w-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-xl mb-4">👤</div>
                    <h2 class="text-2xl font-black text-slate-800 mb-6 tracking-tight">Nouveau Profil</h2>
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-2 ml-1">Nom Complet</label>
                            <input type="text" name="name" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none focus:ring-4 focus:ring-indigo-500/10 transition-all font-semibold" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-2 ml-1">Email</label>
                            <input type="email" name="email" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none focus:ring-4 focus:ring-indigo-500/10 transition-all font-semibold" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-2 ml-1">Rôle</label>
                            <select name="role" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none font-bold text-slate-700">
                                <option value="technicien">Technicien</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-2 ml-1">Mot de passe</label>
                            <input type="password" name="password" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 outline-none" required>
                        </div>
                        <button type="submit" class="w-full btn-grad text-white font-black py-4 rounded-2xl shadow-xl transition-all active:scale-95 uppercase text-xs">Créer</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
                    <h3 class="font-black text-slate-800 text-3xl italic">Équipe <span class="text-indigo-600">Technique</span></h3>
                    <input x-model="search" type="text" placeholder="Rechercher..." class="bg-white border-slate-200 rounded-2xl px-6 py-3 text-sm font-bold shadow-sm outline-none focus:ring-4 focus:ring-indigo-500/5">
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-spaced">
                        <tbody>
                            @foreach($users as $user)
                            <tr x-show="'{{ strtolower($user->name) }} {{ strtolower($user->email) }}'.includes(search.toLowerCase())"
                                class="bg-white hover:bg-indigo-50/40 transition-all {{ !$user->is_active ? 'user-disabled' : '' }}">
                                <td class="px-8 py-5 rounded-l-[2rem] border-y border-l border-slate-100">
                                    <div class="flex items-center">
                                        <div class="h-11 w-11 rounded-2xl flex items-center justify-center text-xs font-black mr-4 {{ $user->is_active ? 'bg-slate-900 text-white' : 'bg-rose-100 text-rose-500' }}">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 text-sm">{{ $user->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold uppercase">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 border-y border-slate-100 text-center">
                                    <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase {{ $user->role == 'admin' ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-50 text-slate-600' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 rounded-r-[2rem] border-y border-r border-slate-100 text-right">
                                    <button @click="openEdit = true; currentUser = { id: '{{ $user->id }}', name: '{{ addslashes($user->name) }}', email: '{{ $user->email }}', role: '{{ $user->role }}', is_active: {{ $user->is_active ? 'true' : 'false' }} }" 
                                            class="text-[10px] font-black uppercase bg-slate-900 text-white px-6 py-3 rounded-xl transition-all hover:bg-indigo-600">
                                        Configurer
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-16">
            <div class="glass-card rounded-[3rem] p-10 shadow-2xl relative overflow-hidden">
                <div class="flex items-center gap-4 mb-10">
                    <div class="h-12 w-12 bg-slate-900 rounded-2xl flex items-center justify-center text-xl shadow-lg">📜</div>
                    <h3 class="font-black text-slate-800 text-2xl tracking-tight italic">Journal <span class="text-indigo-600">d'Audit</span></h3>
                </div>
                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-4 custom-scrollbar">
                    @forelse(\App\Models\ActivityLog::latest()->get() as $log)
                        <div class="flex items-center justify-between p-5 bg-white/40 border border-slate-100 rounded-[2rem] hover:bg-white transition-all">
                            <div class="flex items-center gap-6 text-sm">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase border {{ $log->action == 'Bannissement' ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100' }}">
                                    {{ $log->action }}
                                </span>
                                <p class="font-bold text-slate-700">
                                    <span class="text-indigo-600">{{ $log->admin->name ?? 'Système' }}</span> → {{ $log->details }}
                                </p>
                            </div>
                            <span class="text-[11px] font-black text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-center text-slate-400 italic">Aucune activité enregistrée</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div x-show="openEdit" 
             class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-md" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-110"
             x-transition:enter-end="opacity-100 scale-100"
             x-cloak>
            
            <div @click.away="openEdit = false; showPass = false" 
                 x-data="{ showPass: false }"
                 class="relative bg-white w-full max-w-lg rounded-[3rem] shadow-2xl p-1 border border-slate-100 overflow-hidden">
                
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-purple-600 w-full"></div>

                <div class="p-8 md:p-10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 bg-slate-900 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100">🛡️</div>
                            <h2 class="text-2xl font-black text-slate-900 tracking-tighter italic">Gestion de compte</h2>
                        </div>
                        <button @click="openEdit = false" class="text-slate-300 hover:text-rose-500 transition-colors text-2xl">✕</button>
                    </div>

                    <form :action="'/users/' + currentUser.id" method="POST" class="space-y-6">
                        @csrf @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Nom Complet</label>
                                <input type="text" name="name" x-model="currentUser.name" 
                                       class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 font-bold text-slate-700 focus:bg-white focus:border-indigo-500/20 outline-none transition-all shadow-inner">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Email</label>
                                <input type="email" name="email" x-model="currentUser.email" 
                                       class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 font-bold text-slate-700 focus:bg-white focus:border-indigo-500/20 outline-none transition-all shadow-inner">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Niveau d'accréditation</label>
                            <select name="role" x-model="currentUser.role" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 font-black text-slate-700 outline-none">
                                <option value="admin">Administrateur</option>
                                <option value="technicien">Technicien</option>
                            </select>
                        </div>

                        <div class="p-6 rounded-[2.5rem] transition-all duration-500 border-2" 
                             :class="showPass ? 'bg-rose-50/20 border-rose-100 shadow-inner' : 'bg-slate-50 border-transparent'">
                            
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg" x-show="!showPass">🔒</span>
                                    <span class="text-lg animate-pulse" x-show="showPass">🔑</span>
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sécurité</label>
                                </div>
                                <button type="button" @click="showPass = !showPass" 
                                        class="text-[9px] font-black px-4 py-2 rounded-xl transition-all"
                                        :class="showPass ? 'bg-rose-500 text-white' : 'bg-slate-200 text-slate-500 hover:bg-slate-300'">
                                    <span x-text="showPass ? 'ANNULER' : 'MODIFIER LE MDP'"></span>
                                </button>
                            </div>

                            <div x-show="showPass" x-transition.origin.top>
                                <input type="password" name="password" placeholder="Saisir le nouveau hash..." 
                                       class="w-full bg-white border-2 border-rose-100 rounded-2xl px-5 py-4 outline-none font-mono text-sm shadow-sm focus:border-rose-500 transition-all">
                            </div>
                            <div x-show="!showPass" class="flex justify-center gap-1.5 opacity-30">
                                <template x-for="i in 8"><div class="h-1 w-1 rounded-full bg-slate-400"></div></template>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-5 bg-slate-900 text-white font-black rounded-[1.8rem] shadow-xl hover:bg-indigo-600 transition-all active:scale-95 text-xs uppercase tracking-widest">
                            Sauvegarder les modifications
                        </button>
                    </form>

                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <div class="flex gap-4">
                            <form :action="'/users/' + currentUser.id + '/toggle'" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full py-4 rounded-2xl font-black text-[10px] uppercase transition-all border-2"
                                        :class="currentUser.is_active ? 'border-amber-100 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white' : 'border-emerald-100 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white'">
                                    <span x-text="currentUser.is_active ? 'Désactiver' : 'Réactiver'"></span>
                                </button>
                            </form>
                            <form :action="'/users/' + currentUser.id" method="POST" class="flex-1" onsubmit="return confirm('Attention : Action irréversible. Supprimer ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full py-4 border-2 border-rose-100 text-rose-500 rounded-2xl font-black text-[10px] uppercase hover:bg-rose-500 hover:text-white transition-all">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>