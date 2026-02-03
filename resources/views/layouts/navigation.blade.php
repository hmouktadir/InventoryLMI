<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/60" 
     x-data="{ openPrets: false, openStock: false, mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 transition-all">
                    <div class="relative">
                        <img class="h-10 w-auto rounded-xl shadow-indigo-100 shadow-lg group-hover:scale-110 transition-transform duration-300" 
                             src="{{ asset('images/logo.jpg') }}" alt="Logo">
                        <div class="absolute inset-0 rounded-xl border border-white/20"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-slate-900 tracking-tight text-xl leading-none">LFILM</span>
                        <span class="text-[10px] text-indigo-500 font-bold tracking-widest uppercase">Gestion IT</span>
                    </div>
                </a>

                <div class="hidden md:flex ml-12 space-x-1">
                    
                    <div class="relative" @mouseenter="openPrets = true" @mouseleave="openPrets = false">
                        <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200"
                                :class="openPrets ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:bg-slate-50'">
                            <span>Prêts & Salles</span>
                            <svg class="w-4 h-4 transition-transform duration-300" :class="openPrets ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openPrets" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-cloak 
                             class="absolute top-full left-0 w-72 mt-1 bg-white border border-slate-100 shadow-xl shadow-indigo-500/10 rounded-2xl overflow-hidden p-2 ring-1 ring-slate-900/5">
                            <a href="{{ route('prets.index') }}" class="flex items-center p-3 rounded-xl hover:bg-indigo-50 group transition-all">
                                <div class="p-2 bg-indigo-100 rounded-lg group-hover:bg-white transition-colors">📦</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-slate-800">Prêts Employés</div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter">Attribution directe</div>
                                </div>
                            </a>
                            <a href="{{ route('salles.index') }}" class="flex items-center p-3 rounded-xl hover:bg-emerald-50 group transition-all">
                                <div class="p-2 bg-emerald-100 rounded-lg group-hover:bg-white transition-colors">🏫</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-slate-800">Équipement Salles</div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter">Gestion parc fixe</div>
                                </div>
                            </a>
                            <div class="h-px bg-slate-100 my-2"></div>
                            <a href="{{ route('prets.historique') }}" class="flex items-center p-3 rounded-xl hover:bg-slate-50 group transition-all">
                                <div class="text-sm font-bold text-slate-500 ml-2 italic">Voir l'historique complet...</div>
                            </a>
                        </div>
                    </div>

                    <div class="relative" @mouseenter="openStock = true" @mouseleave="openStock = false">
                        <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200"
                                :class="openStock ? 'bg-amber-50 text-amber-600' : 'text-slate-500 hover:bg-slate-50'">
                            <span>Inventaire</span>
                            <svg class="w-4 h-4 transition-transform duration-300" :class="openStock ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openStock" x-transition x-cloak 
                             class="absolute top-full left-0 w-72 mt-1 bg-white border border-slate-100 shadow-xl rounded-2xl overflow-hidden p-2 ring-1 ring-slate-900/5">
                            <a href="{{ route('stock.index') }}" class="flex items-center p-3 rounded-xl hover:bg-amber-50 group transition-all">
                                <div class="p-2 bg-amber-100 rounded-lg group-hover:bg-white">🛒</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-slate-800">Consommables</div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter">État du stock réel</div>
                                </div>
                            </a>
                            <a href="{{ route('stock.history') }}" class="flex items-center p-3 rounded-xl hover:bg-slate-50 group transition-all">
                                <div class="p-2 bg-slate-100 rounded-lg group-hover:bg-white">📜</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-slate-800">Historique MAJ</div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter">Traces des techniciens</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center bg-slate-100/50 p-1 rounded-2xl border border-slate-200/50">
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 pl-3 pr-2 py-1.5 transition-all outline-none">
                                <div class="flex flex-col items-end">
                                    <span class="text-xs font-black text-slate-800 leading-none">{{ Auth::user()->name }}</span>
                                    <span class="text-[9px] font-bold text-indigo-500 uppercase tracking-widest">{{ Auth::user()->role }}</span>
                                </div>
                                <div class="h-8 w-8 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-indigo-200">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-xs text-slate-400 font-bold uppercase tracking-widest">Mon Compte</div>
                           <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 font-bold text-slate-700">
    <span>⚙️</span> {{ __('Paramètres Profil') }}
</x-dropdown-link>

                            @if(strtolower(Auth::user()->role) === 'admin')
                                <div class="border-t border-slate-100 my-1"></div>
                                <x-dropdown-link :href="route('users.index')" class="text-indigo-600 font-bold flex items-center gap-2">
                                    <span>🛡️</span> {{ __('Console Admin') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full text-left font-bold text-red-600 hover:text-red-800 transition-colors">
                                    <span>🚪</span> {{ __('Déconnexion') }}
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

        </div>
    </div>
</nav>