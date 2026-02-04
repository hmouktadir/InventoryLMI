<nav class="sticky top-4 z-[100] mx-auto max-w-[95%] lg:max-w-7xl" 
     x-data="{ openPrets: false, openStock: false }">
    
    <div class="relative rounded-[2.5rem] border border-white/40 bg-white/60 p-2 backdrop-blur-2xl shadow-lg">
        
        <div class="relative flex h-16 items-center justify-between px-4 lg:px-8">
            
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-4">
                    <img class="h-10 w-10 rounded-xl shadow-lg group-hover:scale-110 transition-transform" 
                         src="{{ asset('images/logo.jpg') }}" alt="Logo">
                    <div class="flex flex-col">
                        <span class="font-black text-slate-900 text-2xl tracking-tighter">LFILM</span>
                        <span class="text-[8px] font-black uppercase tracking-[0.3em] text-slate-400">inventaire Centralisé IT</span>
                    </div>
                </a>

                <div class="hidden lg:flex ml-16 items-center gap-2">
                    
                    <div class="relative" @mouseenter="openPrets = true" @mouseleave="openPrets = false">
                        <button type="button" 
                                class="relative z-[120] flex items-center gap-2 px-6 py-2.5 rounded-full text-[11px] font-black uppercase tracking-widest transition-all duration-300"
                                :class="openPrets ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-100'">
                            <span>Mouvements</span>
                            <svg class="w-3 h-3 transition-transform" :class="openPrets ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openPrets" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             @click.away="openPrets = false"
                             x-cloak 
                             class="absolute top-0 left-0 w-80 pt-16 z-[110]">
                            <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-2xl p-3">
                                <a href="{{ route('prets.index') }}" class="flex items-center p-4 rounded-[1.8rem] hover:bg-slate-900 hover:text-white transition-all group">
                                    <span class="text-xl mr-4 group-hover:scale-110 transition-transform">🤝</span>
                                    <div>
                                        <div class="text-[13px] font-black italic">Prêts Individuels</div>
                                        <div class="text-[9px] opacity-60 uppercase font-bold">Sorties Directes</div>
                                    </div>
                                </a>
                                <a href="{{ route('salles.index') }}" class="mt-1 flex items-center p-4 rounded-[1.8rem] hover:bg-slate-900 hover:text-white transition-all group">
                                    <span class="text-xl mr-4 group-hover:scale-110 transition-transform">🏫</span>
                                    <div>
                                        <div class="text-[13px] font-black italic">Audit Salles</div>
                                        <div class="text-[9px] opacity-60 uppercase font-bold">Équipements Fixes</div>
                                    </div>
                                </a>
                                <div class="my-2 h-px bg-slate-100"></div>
                                <a href="{{ route('prets.historique') }}" class="block text-center py-2 text-[10px] font-black text-indigo-500 hover:text-indigo-700 uppercase tracking-widest">
                                    Archives Historiques →
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="relative" @mouseenter="openStock = true" @mouseleave="openStock = false">
                        <button type="button" 
                                class="relative z-[120] flex items-center gap-2 px-6 py-2.5 rounded-full text-[11px] font-black uppercase tracking-widest transition-all duration-300"
                                :class="openStock ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-100'">
                            <span>Inventaire</span>
                            <svg class="w-3 h-3 transition-transform" :class="openStock ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openStock" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             @click.away="openStock = false"
                             x-cloak 
                             class="absolute top-0 left-0 w-80 pt-16 z-[110]">
                            <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-2xl p-3">
                                <a href="{{ route('stock.index') }}" class="flex items-center p-4 rounded-[1.8rem] hover:bg-slate-900 hover:text-white transition-all group">
                                    <span class="text-xl mr-4 group-hover:scale-110 transition-transform">🔋</span>
                                    <div>
                                        <div class="text-[13px] font-black italic">Consommables</div>
                                        <div class="text-[9px] opacity-60 uppercase font-bold">Gestion Stock</div>
                                    </div>
                                </a>
                                <a href="{{ route('stock.history') }}" class="mt-1 flex items-center p-4 rounded-[1.8rem] hover:bg-slate-900 hover:text-white transition-all group">
                                    <span class="text-xl mr-4 group-hover:scale-110 transition-transform">📜</span>
                                    <div>
                                        <div class="text-[13px] font-black italic">Flux Log</div>
                                        <div class="text-[9px] opacity-60 uppercase font-bold">Traçabilité</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 p-1.5 pr-5 bg-white border border-slate-200 rounded-full hover:shadow-md transition-all outline-none">
                            <div class="h-9 w-9 rounded-full bg-slate-900 flex items-center justify-center text-white font-black text-xs">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:flex flex-col text-left">
                                <span class="text-[11px] font-black text-slate-900 leading-none">{{ Auth::user()->name }}</span>
                                <span class="text-[8px] font-black text-indigo-500 uppercase tracking-widest mt-1">{{ Auth::user()->role }}</span>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-2 space-y-1">
                            <x-dropdown-link :href="route('profile.edit')" class="rounded-xl font-bold">⚙️ Paramètres</x-dropdown-link>
                            @if(strtolower(Auth::user()->role) === 'admin')
                                <x-dropdown-link :href="route('users.index')" class="rounded-xl font-bold text-indigo-600">🛡️ Admin</x-dropdown-link>
                            @endif
                            <div class="h-px bg-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left p-3 text-red-500 font-black text-[10px] uppercase tracking-widest hover:bg-red-50 rounded-xl transition-all">🚪 Déconnexion</button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>
</nav>