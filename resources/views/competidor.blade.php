@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-earth-50 p-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white/90 rounded-xl shadow-lg border border-earth-100 p-6">

                <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-earth-800">Competidores</h1>
                        <p class="text-sm text-earth-700/80">Cadastre participantes, gerencie categorias e status de
                            inscrição.</p>
                    </div>
                    <div class="flex gap-2">
                        <button id="exportCsv" class="px-4 py-2 bg-earth-600 text-white rounded">Exportar CSV</button>

                    </div>
                </header>

                <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Form de cadastro rápido -->
                    <div class="lg:col-span-1 bg-white p-4 rounded shadow-sm border border-earth-100">
                        @if (isset($inputs))
                            <h2 class="font-semibold text-lg text-earth-800 mb-3">Atualizar Competidor</h2>
                            <form action="{{ route('competidores.update')}}" method="POST" id="formCompetidor">
                                @csrf
                              <input type="hidden" name="id" value="{{ $inputs['id'] }}">
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Nome</label>
                                    <input name="nome" type="text" required class="w-full p-2 border rounded mt-1"
                                        value="{{ $inputs['nome'] }}" placeholder="Nome completo">
                                    @error('nome')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Email</label>
                                    <input name="email" type="email" required class="w-full p-2 border rounded mt-1"
                                        value="{{ $inputs['email'] }}" placeholder="email@exemplo.com">
                                    @error('email')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Telefone</label>
                                        <input name="telefone" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ $inputs['telefone'] }}" placeholder="(44) 9xxxx-xxxx">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Data de nascimento</label>
                                        <input name="data_nascimento" type="date" required
                                            class="w-full p-2 border rounded mt-1" value="{{ $inputs['data_nascimento'] }}">
                                        @error('data_nascimento')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Categoria</label>
                                        <select name="categoria" class="w-full p-2 border rounded mt-1">
                                            <option value="Iniciante" {{ $inputs['categoria'] == 'Iniciante' ? 'selected' : '' }}>
                                                Iniciante</option>
                                            <option value="Amador"
                                                {{ $inputs['categoria'] == 'Amador' ? 'selected' : '' }}>Amador</option>
                                            <option value="Profissional"
                                                {{ $inputs['categoria'] == 'Profissional' ? 'selected' : '' }}>Profissional
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Status inscrição</label>
                                        <select name="status_inscricao" class="w-full p-2 border rounded mt-1">
                                            <option value="Pendente"
                                                {{ $inputs['status_inscricao'] == 'Pendente' ? 'selected' : '' }}>
                                                Pendente</option>
                                            <option value="Confirmada"
                                                {{ $inputs['status_inscricao'] == 'Confirmada' ? 'selected' : '' }}>Confirmada
                                            </option>
                                            <option value="Cancelada"
                                                {{ $inputs['status_inscricao'] == 'Cancelada' ? 'selected' : '' }}>Cancelada
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Cidade</label>
                                        <input name="cidade" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ $inputs['cidade'] }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Estado</label>
                                        <input name="estado" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ $inputs['estado'] }}">
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('competidores.index') }}"
                                        class="px-4 py-2 border rounded">Cancelar</a>
                                    <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar
                                        competidor</button>
                                </div>
                            </form>
                        @else
                            <h2 class="font-semibold text-lg text-earth-800 mb-3">Cadastrar competidor</h2>
                            <form action="{{ route('competidores.store') }}" method="POST" id="formCompetidor">
                                @csrf

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Nome</label>
                                    <input name="nome" type="text" required class="w-full p-2 border rounded mt-1"
                                        value="{{ old('nome') }}" placeholder="Nome completo">
                                    @error('nome')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Email</label>
                                    <input name="email" type="email" required class="w-full p-2 border rounded mt-1"
                                        value="{{ old('email') }}" placeholder="email@exemplo.com">
                                    @error('email')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Telefone</label>
                                        <input name="telefone" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ old('telefone') }}" placeholder="(44) 9xxxx-xxxx">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Data de nascimento</label>
                                        <input name="data_nascimento" type="date" required
                                            class="w-full p-2 border rounded mt-1" value="{{ old('data_nascimento') }}">
                                        @error('data_nascimento')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Categoria</label>
                                        <select name="categoria" class="w-full p-2 border rounded mt-1">
                                            <option value="Iniciante" {{ old('categoria') == 'Iniciante' ? 'selected' : '' }}>
                                                Iniciante</option>
                                            <option value="Amador"
                                                {{ old('categoria', 'Amador') == 'Amador' ? 'selected' : '' }}>Amador</option>
                                            <option value="Profissional"
                                                {{ old('categoria') == 'Profissional' ? 'selected' : '' }}>Profissional
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Status inscrição</label>
                                        <select name="status_inscricao" class="w-full p-2 border rounded mt-1">
                                            <option value="Pendente"
                                                {{ old('status_inscricao', 'Pendente') == 'Pendente' ? 'selected' : '' }}>
                                                Pendente</option>
                                            <option value="Confirmada"
                                                {{ old('status_inscricao') == 'Confirmada' ? 'selected' : '' }}>Confirmada
                                            </option>
                                            <option value="Cancelada"
                                                {{ old('status_inscricao') == 'Cancelada' ? 'selected' : '' }}>Cancelada
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Cidade</label>
                                        <input name="cidade" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ old('cidade') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-earth-700">Estado</label>
                                        <input name="estado" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ old('estado') }}">
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('competidores.index') }}"
                                        class="px-4 py-2 border rounded">Cancelar</a>
                                    <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar
                                        competidor</button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Lista / filtros -->
                    <div class="lg:col-span-2">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <div class="flex-1 flex gap-2">
                                <input id="searchComp" placeholder="Pesquisar por nome, email ou cidade"
                                    class="flex-1 p-2 border rounded" />
                                <select id="filterCategoria" class="p-2 border rounded w-44">
                                    <option value="">Todas as categorias</option>
                                    <option value="Iniciante">Iniciante</option>
                                    <option value="Amador">Amador</option>
                                    <option value="Profissional">Profissional</option>
                                </select>

                                <select id="filterStatus" class="p-2 border rounded w-44">
                                    <option value="">Todos os status</option>
                                    <option value="Pendente">Pendente</option>
                                    <option value="Confirmada">Confirmada</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <button id="clearFilters" class="px-3 py-2 border rounded">Limpar</button>
                            </div>
                        </div>

                        <div class="overflow-x-auto bg-white rounded border border-earth-100">
                            <table class="w-full min-w-[900px]">
                                <thead class="bg-earth-700 text-earth-50 text-sm">
                                    <tr>
                                        <th class="p-3 text-left">Nome</th>
                                        <th class="p-3 text-left">Categoria</th>
                                        <th class="p-3 text-left">Data Nasc</th>
                                        <th class="p-3 text-left">Cidade / Estado</th>
                                        <th class="p-3 text-left">Status</th>
                                        <th class="p-3 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="compTableBody">
                                    @foreach ($competidores as $c)
                                        <tr class="even:bg-earth-50">
                                            <td class="p-3 font-semibold">{{ $c->nome }}</td>
                                            <td class="p-3">{{ $c->categoria }}</td>
                                            <td class="p-3 text-sm">{{ optional($c->data_nascimento)->format('d/m/Y') }}
                                            </td>
                                            <td class="p-3 text-sm">{{ $c->cidade ?? '—' }} @if ($c->estado)
                                                    / {{ $c->estado }}
                                                @endif
                                            </td>
                                            <td class="p-3">{{ $c->status_inscricao }}</td>
                                            <td class="p-3 text-center">
                                                <a href="{{ route('competidores.edit', $c->id) }}"
                                                    class="px-3 py-1 border rounded text-sm">Editar</a>

                                                <form action="{{ route('competidores.destroy', $c->id) }}" method="POST"
                                                    class="inline-block ml-2"
                                                    onsubmit="return confirm('Excluir esse competidor?');">
                                                    @csrf
                                            
                                                    <button type="submit"
                                                        class="px-3 py-1 border rounded text-sm text-red-600">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 text-sm text-earth-700">Total: <strong>{{ $competidores->count() }}</strong>
                            competidores</div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        :root {
            --earth-50: #fbf8f6;
            --earth-100: #f5efe6;
            --earth-200: #ead9c2;
            --earth-300: #dfc29e;
            --earth-500: #a27045;
            --earth-700: #6b472b;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toastr (session flashes will be displayed if set in controller)
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
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

            // Filters and search (client-side)
            const search = document.getElementById('searchComp');
            const filterCategoria = document.getElementById('filterCategoria');
            const filterStatus = document.getElementById('filterStatus');
            const clearBtn = document.getElementById('clearFilters');
            const tbody = document.getElementById('compTableBody');

            function applyFilter() {
                const q = (search.value || '').trim().toLowerCase();
                const cat = (filterCategoria.value || '').trim().toLowerCase();
                const st = (filterStatus.value || '').trim().toLowerCase();

                Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                    const nome = (tr.children[0].textContent || '').toLowerCase();
                    const categoria = (tr.children[1].textContent || '').toLowerCase();
                    const data = (tr.children[2].textContent || '').toLowerCase();
                    const local = (tr.children[3].textContent || '').toLowerCase();
                    const status = (tr.children[4].textContent || '').toLowerCase();

                    const match = (!q || nome.includes(q) || local.includes(q) || data.includes(q)) &&
                        (!cat || categoria.includes(cat)) &&
                        (!st || status.includes(st));

                    tr.style.display = match ? '' : 'none';
                });
            }

            search?.addEventListener('input', applyFilter);
            filterCategoria?.addEventListener('change', applyFilter);
            filterStatus?.addEventListener('change', applyFilter);
            clearBtn?.addEventListener('click', () => {
                search.value = '';
                filterCategoria.value = '';
                filterStatus.value = '';
                applyFilter();
            });

            // Export CSV (based on visible rows)
            document.getElementById('exportCsv')?.addEventListener('click', () => {
                const headers = ['nome', 'email', 'telefone', 'data_nascimento', 'categoria', 'cidade',
                    'estado', 'status_inscricao'
                ];
                const rows = [];
                Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                    if (tr.style.display === 'none') return;
                    const nome = tr.children[0].textContent.trim();
                    const categoria = tr.children[1].textContent.trim();
                    const data = tr.children[2].textContent.trim();
                    const local = tr.children[3].textContent.trim();
                    const status = tr.children[4].textContent.trim();
                    // email/telefone aren't visible in table cells by default; if you want them add hidden columns or change table.
                    rows.push([nome, '', '', data, categoria, local, '', status]);
                });
                const csv = [headers.join(','), ...rows.map(r => r.map(c =>
                    `"${String(c).replace(/"/g,'""')}"`).join(',')).join('\n')];
                const blob = new Blob([csv.join('\n')], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'competidores.csv';
                link.click();
            });

        });
    </script>
@endpush
