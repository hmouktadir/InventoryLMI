<x-app-layout>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .hover-float:hover { animation: float 3s ease-in-out infinite; }
        
        /* Gradients Premium */
        .bg-gradient-indigo { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); }
        .bg-gradient-amber { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .bg-gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .bg-gradient-emerald { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }

        /* Scrollbar Minimaliste */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
        
        /* Effet Glassmorphism Global */
        .glass-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>

    <div class="max-w-[1600px] mx-auto p-6 space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <a href="{{ route('prets.index') }}" class="group relative glass-card p-7 rounded-[2.5rem] shadow-xl border border-white/60 overflow-hidden transition-all duration-500 hover:-translate-y-2">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-center mb-8">
                        <div class="p-4 bg-gradient-indigo rounded-2xl shadow-lg shadow-indigo-200 hover-float text-white">
                            <span class="text-2xl">🤝</span>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Live Status</span>
                            <div class="h-2 w-2 rounded-full bg-indigo-500 animate-pulse mt-1"></div>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-4xl font-black text-slate-800 tracking-tighter">{{ $pretsCount ?? 0 }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Prêts en cours</p>
                    </div>
                </div>
                <div class="absolute -right-6 -bottom-8 text-[10rem] opacity-[0.03] rotate-12 group-hover:rotate-0 transition-transform duration-700">🤝</div>
            </a>

            <a href="{{ route('stock.index') }}" class="group relative glass-card p-7 rounded-[2.5rem] shadow-xl border border-white/60 overflow-hidden transition-all duration-500 hover:-translate-y-2">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-amber-500/10 rounded-full blur-3xl group-hover:bg-amber-500/20 transition-all"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-center mb-8">
                        <div class="p-4 bg-gradient-amber rounded-2xl shadow-lg shadow-amber-200 hover-float text-white">
                            <span class="text-2xl">⚠️</span>
                        </div>
                        <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Attention</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-4xl font-black text-slate-800 tracking-tighter">{{ $lowStockCount ?? 0 }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Stock Critique</p>
                    </div>
                </div>
                <div class="absolute -right-6 -bottom-8 text-[10rem] opacity-[0.03] rotate-12 group-hover:rotate-0 transition-transform duration-700">📦</div>
            </a>

            <a href="{{ route('salles.index') }}" class="group relative glass-card p-7 rounded-[2.5rem] shadow-xl border border-white/60 overflow-hidden transition-all duration-500 hover:-translate-y-2">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-all"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-center mb-8">
                        <div class="p-4 bg-gradient-blue rounded-2xl shadow-lg shadow-blue-200 hover-float text-white">
                            <span class="text-2xl">🏫</span>
                        </div>
                        <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Sites</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-4xl font-black text-slate-800 tracking-tighter">4</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Établissements</p>
                    </div>
                </div>
                <div class="absolute -right-6 -bottom-8 text-[10rem] opacity-[0.03] rotate-12 group-hover:rotate-0 transition-transform duration-700">🏫</div>
            </a>

            <div class="group relative glass-card p-7 rounded-[2.5rem] shadow-xl border border-white/60 overflow-hidden transition-all duration-500 hover:-translate-y-2">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-600/20 transition-all"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-center mb-8">
                        <div class="p-4 bg-gradient-emerald rounded-2xl shadow-lg shadow-emerald-200 hover-float text-white">
                            <span class="text-2xl">⚙️</span>
                        </div>
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Système</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-4xl font-black text-slate-800 tracking-tighter">100%</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Opérationnel</p>
                    </div>
                </div>
                <div class="absolute -right-6 -bottom-8 text-[10rem] opacity-[0.03] rotate-12 group-hover:rotate-0 transition-transform duration-700">⚙️</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="glass-card relative p-8 rounded-[3rem] border border-white/60 shadow-2xl overflow-hidden group">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px] group-hover:bg-indigo-500/20 transition-all duration-700"></div>
                <h3 class="text-xl font-black text-slate-800 mb-10 flex items-center gap-3 font-italic">
                    <span class="flex h-10 w-10 items-center justify-center bg-white rounded-xl shadow-sm">📍</span>
                    Répartition par Site
                </h3>
                <div class="relative h-72">
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-5xl font-black text-slate-800 tracking-tighter">{{ array_sum($dataGraph) }}</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Objets</span>
                    </div>
                    <canvas id="siteChart"></canvas>
                </div>
                <div class="mt-10 grid grid-cols-2 gap-4">
                    @foreach(['Lycée', 'Collège', 'B1', 'B2'] as $index => $siteName)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-white/50 border border-transparent hover:border-white hover:shadow-sm transition-all">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full {{ ['bg-indigo-500', 'bg-blue-400', 'bg-rose-400', 'bg-emerald-400'][$index] }}"></span>
                            <span class="text-[11px] font-bold text-slate-600 uppercase">{{ $siteName }}</span>
                        </div>
                        <span class="text-xs font-black text-slate-400">{{ $dataGraph[$index] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="glass-card relative p-8 rounded-[3rem] border border-white/60 shadow-2xl overflow-hidden {{ $lowStockCount > 0 ? 'bg-red-50/50' : '' }}">
                @if($lowStockCount > 0)
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-500/20 rounded-full blur-[50px] animate-pulse"></div>
                @endif
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-4 {{ $lowStockCount > 0 ? 'bg-red-500' : 'bg-emerald-500' }} rounded-2xl shadow-lg text-white">
                            {!! $lowStockCount > 0 ? '⚠️' : '✅' !!}
                        </div>
                        <span class="text-[10px] font-black {{ $lowStockCount > 0 ? 'text-red-600' : 'text-emerald-600' }} uppercase tracking-widest">
                            {{ $lowStockCount > 0 ? 'Réapprovisionnement requis' : 'Inventaire Optimal' }}
                        </span>
                    </div>
                    <div class="mb-8">
                        <h3 class="text-5xl font-black text-slate-800 tracking-tighter">{{ $lowStockCount }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">Articles en zone rouge</p>
                    </div>
                    <div class="space-y-3 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($articlesCritiques as $article)
                            <div class="flex items-center justify-between p-4 bg-white/60 rounded-2xl border border-red-100 hover:border-red-300 transition-all">
                                <div>
                                    <span class="text-sm font-black text-slate-700 block">{{ $article->designation }}</span>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="text-sm font-black text-red-600">{{ $article->quantite }} restants</span>
                                    <div class="w-16 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-red-500 h-full" style="width: {{ min(($article->quantite / 10) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <span class="text-4xl block mb-2">🎉</span>
                                <p class="text-[10px] font-bold text-emerald-600 uppercase">Tout est en ordre !</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('siteChart').getContext('2d');
            
            // Gradients pour le Donut
            const createGrad = (color1, color2) => {
                const g = ctx.createLinearGradient(0, 0, 0, 400);
                g.addColorStop(0, color1); g.addColorStop(1, color2);
                return g;
            };

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Lycée', 'Collège', 'B1', 'B2'],
                    datasets: [{
                        data: @json($dataGraph),
                        backgroundColor: [
                            createGrad('#6366f1', '#a855f7'),
                            createGrad('#3b82f6', '#2dd4bf'),
                            createGrad('#fb7185', '#e11d48'),
                            createGrad('#34d399', '#059669')
                        ],
                        borderWidth: 0,
                        borderRadius: 20,
                        spacing: 8,
                        cutout: '82%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 15,
                            cornerRadius: 12,
                            callbacks: {
                                label: (context) => ` ${context.raw} équipements`
                            }
                        }
                    },
                    animation: { animateScale: true, duration: 2000, easing: 'easeOutQuart' }
                }
            });
        });
    </script>
</x-app-layout>