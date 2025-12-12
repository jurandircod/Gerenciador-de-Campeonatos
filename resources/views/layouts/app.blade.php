<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Organização - Evento de Skate (Tailwind Only)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        // Custom tailwind palette (earthy tones)
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        earth: {
                            50: '#fbf8f6',
                            100: '#f5efe6',
                            200: '#ead9c2',
                            300: '#dfc29e',
                            400: '#c9a66b',
                            500: '#a27045',
                            600: '#845635',
                            700: '#6b472b',
                            800: '#5a3a22',
                            900: '#3f2b18'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* small custom for table scrollbar */
        .table-scroll::-webkit-scrollbar {
            height: 10px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="min-h-screen bg-earth-50 text-earth-800">
        <div class="flex min-h-screen">
            <!-- SIDEBAR -->
            <aside class="w-72 bg-white/95 border-r border-earth-100 hidden lg:block">
                <div class="p-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 rounded bg-earth-500 flex items-center justify-center text-white font-bold">
                            🛹
                        </div>
                        <div>
                            <div class="font-extrabold text-earth-800">Skate Organizer</div>
                            <div class="text-xs text-earth-600">Painel do evento</div>
                        </div>
                    </a>

<nav class="mt-4" x-data="{ pessoas: false, campeonato: false }">
    <h3 class="text-xs text-earth-600 uppercase tracking-wide mb-2">Navegação</h3>

    <ul class="space-y-1">

        {{-- Dashboard --}}
        <li>
            <a href="{{ route('home') }}"
               class="block px-3 py-2 rounded hover:bg-earth-50">
                Dashboard
            </a>
        </li>

        {{-- ============================
            GERENCIAR PESSOAS
        ============================= --}}
        <li>
            <button @click="pessoas = !pessoas"
                class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-earth-50 text-left">
                <span>Gerenciar Pessoas</span>
                <svg x-bind:class="pessoas ? 'rotate-90' : ''"
                     class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <ul x-show="pessoas"
                x-transition
                class="ml-4 mt-1 space-y-1 border-l pl-3 border-earth-200">
                
                <li><a href="{{ route('competidores.index') }}"
                       class="block px-3 py-2 rounded hover:bg-earth-50">Competidores</a></li>

                <li><a href="{{ route('responsaveis.index') }}"
                       class="block px-3 py-2 rounded hover:bg-earth-50">Responsáveis</a></li>

                <li><a href="{{ route('juizes.index') }}"
                       class="block px-3 py-2 rounded hover:bg-earth-50">Juízes</a></li>

                <li><a href="{{ route('fornecedores.index') }}"
                       class="block px-3 py-2 rounded hover:bg-earth-50">Fornecedores</a></li>
            </ul>
        </li>

        {{-- ============================
            GERENCIAR CAMPEONATO
        ============================= --}}
        <li>
            <button @click="campeonato = !campeonato"
                class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-earth-50 text-left">
                <span>Gerenciar Campeonato</span>
                <svg x-bind:class="campeonato ? 'rotate-90' : ''"
                     class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <ul x-show="campeonato"
                x-transition
                class="ml-4 mt-1 space-y-1 border-l pl-3 border-earth-200">

                <li><a href="{{ route('tarefas.index') }}"
                       class="block px-3 py-2 rounded hover:bg-earth-50">Tarefas</a></li>

                <li><a href="{{ route('areas.index') }}"
                       class="block px-3 py-2 rounded hover:bg-earth-50">Áreas</a></li>

                <li><a href="{{ route('patrocinadores.index') }}"
                       class="block px-3 py-2 rounded hover:bg-earth-50">Patrocinadores</a></li>

                <li><a href="{{ route('orcamentos.index') }}"
                       class="block px-3 py-2 rounded hover:bg-earth-50">Orçamento</a></li>
            </ul>
        </li>

    </ul>
</nav>


                    <div class="mt-6 pt-4 border-t border-earth-100 text-sm text-earth-600">
                        <div>Eventos: <strong class="text-earth-800">Campeonato Municipal</strong></div>
                        <div class="mt-2">Sessões: <span
                                class="inline-block bg-earth-200 text-earth-800 text-xs px-2 py-1 rounded">Qualificação</span>
                            <span class="inline-block bg-earth-50 text-earth-800 text-xs px-2 py-1 rounded">1 Etapa</span>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Mobile top nav -->
            <div class="lg:hidden fixed top-4 left-4 z-40">
                <button id="openSidebarMobile" class="p-2 bg-earth-500 text-white rounded-md shadow">☰</button>
            </div>

            <div id="mobileSidebar" class="fixed inset-0 z-50 bg-black/40 hidden lg:hidden">
                <div class="w-64 bg-white h-full p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="font-bold">Menu</div>
                        <button id="closeSidebarMobile" class="text-earth-600">✕</button>
                    </div>
                    <nav class="space-y-2">
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-earth-50">Dashboard</a>
                        <a href="{{ route('tarefas.index') }}"
                            class="block px-3 py-2 rounded hover:bg-earth-50">Tarefas</a>
                        <a href="{{ route('responsaveis.index') }}"
                            class="block px-3 py-2 rounded hover:bg-earth-50">Responsáveis</a>
                        <a href="{{ route('areas.index') }}"
                            class="block px-3 py-2 rounded hover:bg-earth-50">Áreas</a>
                        <a href="{{ route('patrocinadores.index') }}"
                            class="block px-3 py-2 rounded hover:bg-earth-50">Patrocinadores</a>
                        <a href="{{ route('fornecedores.index') }}"
                            class="block px-3 py-2 rounded hover:bg-earth-50">Fornecedores</a>
                        <a href="{{ route('juizes.index') }}"
                            class="block px-3 py-2 rounded hover:bg-earth-50">Juízes</a>
                        <a href="{{ route('orcamentos.index') }}"
                            class="block px-3 py-2 rounded hover:bg-earth-50">Orçamento</a>
                    </nav>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
</body>

@stack('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- JQUERY PRIMEIRO -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- TOASTR DEPOIS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000,
            extendedTimeOut: 1000
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    });
</script>


</html>
