@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-earth-50 p-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white/90 rounded-xl shadow-lg border border-earth-100 p-6">
                <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-earth-800">Tarefas / Cronograma</h1>
                        <p class="text-sm text-earth-700/80">Cadastre tarefas, defina responsável, área, prioridade e
                            acompanhe o
                            status.</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('areas.index') }}" class="px-4 py-2 border rounded text-earth-700">Áreas</a>
                        <a href="{{ route('responsaveis.index') }}"
                            class="px-4 py-2 border rounded text-earth-700">Responsáveis</a>
                        <button id="exportCsv" class="px-4 py-2 bg-earth-600 text-white rounded">Exportar CSV</button>
                    </div>
                </header>

                <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Form de cadastro -->
                    <div class="lg:col-span-1 bg-white p-4 rounded shadow-sm border border-earth-100">
                        @if (isset($inputs))
                            <h2 class="font-semibold text-lg text-earth-800 mb-3">Editar Tarefa</h2>
                            <form action="{{ route('tarefas.update', $inputs['id']) }}" method="POST" id="formTarefa">
                                @csrf

                                <input type="hidden" name="id" value="{{ $inputs['id'] }}">
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Título</label>
                                    <input name="titulo" type="text" required class="w-full p-2 border rounded mt-1"
                                        placeholder="Ex: Montagem da pista" value="{{ $inputs['titulo'] }}">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Descrição</label>
                                    <textarea name="descricao" rows="3" class="w-full p-2 border rounded mt-1" placeholder="Detalhes (opcional)">{{ $inputs['descricao'] }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Responsável</label>
                                        <select name="responsavel_id" required class="w-full p-2 border rounded mt-1">
                                            <option value="">-- Selecionar --</option>
                                            @foreach ($responsaveis as $resp)
                                                <option value="{{ $resp->id }}"
                                                    {{ $inputs['responsavel_id'] == $resp->id ? 'selected' : '' }}>
                                                    {{ $resp->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Área</label>
                                        <select name="area_id" required class="w-full p-2 border rounded mt-1">
                                            <option value="">-- Selecionar --</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}"
                                                    {{ $inputs['area_id'] == $area->id ? 'selected' : '' }}>
                                                    {{ $area->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Prazo</label>
                                        <input name="prazo" type="date" required class="w-full p-2 border rounded mt-1"
                                            value="{{ $inputs['prazo'] }}" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Prioridade</label>
                                        <select name="prioridade" class="w-full p-2 border rounded mt-1">
                                            <option value="Alta" {{ $inputs['prioridade'] == 'Alta' ? 'selected' : '' }}>
                                                Alta</option>
                                            <option value="Média"
                                                {{ $inputs['prioridade'] == 'Média' ? 'selected' : '' }}>Média</option>
                                            <option value="Baixa"
                                                {{ $inputs['prioridade'] == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Status</label>
                                        <select name="status" class="w-full p-2 border rounded mt-1">
                                            <option value="Pendente">Pendente</option>
                                            <option value="Em Andamento">Em Andamento</option>
                                            <option value="Concluída">Concluída</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('tarefas.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                                    <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Atualizar
                                        Tarefa</button>
                                </div>
                            </form>
                        @else
                            <h2 class="font-semibold text-lg text-earth-800 mb-3">Nova tarefa</h2>
                            <form action="{{ route('tarefas.store') }}" method="POST" id="formTarefa">
                                @csrf

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Título</label>
                                    <input name="titulo" type="text" required class="w-full p-2 border rounded mt-1"
                                        placeholder="Ex: Montagem da pista" value="{{ old('titulo') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Descrição</label>
                                    <textarea name="descricao" rows="3" class="w-full p-2 border rounded mt-1" placeholder="Detalhes (opcional)">{{ old('descricao') }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Responsável</label>
                                        <select name="responsavel_id" required class="w-full p-2 border rounded mt-1">
                                            <option value="">-- Selecionar --</option>
                                            @foreach ($responsaveis as $resp)
                                                <option value="{{ $resp->id }}"
                                                    {{ old('responsavel_id') == $resp->id ? 'selected' : '' }}>
                                                    {{ $resp->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Área</label>
                                        <select name="area_id" required class="w-full p-2 border rounded mt-1">
                                            <option value="">-- Selecionar --</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}"
                                                    {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                                    {{ $area->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Prazo</label>
                                        <input name="prazo" type="date" required
                                            class="w-full p-2 border rounded mt-1" value="{{ old('prazo') }}" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Prioridade</label>
                                        <select name="prioridade" class="w-full p-2 border rounded mt-1">
                                            <option value="Alta" {{ old('prioridade') == 'Alta' ? 'selected' : '' }}>
                                                Alta</option>
                                            <option value="Média" {{ old('prioridade') == 'Média' ? 'selected' : '' }}>
                                                Média</option>
                                            <option value="Baixa" {{ old('prioridade') == 'Baixa' ? 'selected' : '' }}>
                                                Baixa</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Status</label>
                                        <select name="status" class="w-full p-2 border rounded mt-1">
                                            <option value="Pendente">Pendente</option>
                                            <option value="Em Andamento">Em Andamento</option>
                                            <option value="Concluída">Concluída</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('tarefas.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                                    <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar
                                        tarefa</button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Pesquisa / filtros -->
                    <div class="lg:col-span-2">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <div class="flex-1 flex gap-2">
                                <input id="searchTask" placeholder="Pesquisar por título, responsável ou área"
                                    class="flex-1 p-2 border rounded" />
                                <select id="filterArea" class="p-2 border rounded w-56">
                                    <option value="">Todas as áreas</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->nome }}">{{ $area->nome }}</option>
                                    @endforeach
                                </select>
                                <select id="filterResp" class="p-2 border rounded w-56">
                                    <option value="">Todos os responsáveis</option>
                                    @foreach ($responsaveis as $resp)
                                        <option value="{{ $resp->nome }}">{{ $resp->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <select id="filterStatus" class="p-2 border rounded">
                                    <option value="">Todos os status</option>
                                    <option value="Pendente">Pendente</option>
                                    <option value="Em Andamento">Em Andamento</option>
                                    <option value="Concluída">Concluída</option>
                                </select>
                                <button id="clearFilters" class="px-3 py-2 border rounded">Limpar</button>
                            </div>
                        </div>

                        <div class="overflow-x-auto bg-white rounded border border-earth-100">
                            <table class="w-full min-w-[1000px]">
                                <thead class="bg-earth-700 text-earth-50 text-sm">
                                    <tr>
                                        <th class="p-3 text-left">Título</th>
                                        <th class="p-3 text-left">Descrição</th>
                                        <th class="p-3 text-left">Responsável</th>
                                        <th class="p-3 text-left">Área</th>
                                        <th class="p-3 text-left">Prazo</th>
                                        <th class="p-3 text-left">Prioridade</th>
                                        <th class="p-3 text-left">Status</th>
                                        <th class="p-3 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="tasksTableBody">
                                    @foreach ($tarefas as $tarefa)
                                        <tr class="even:bg-earth-50">
                                            <td class="p-3 font-semibold">{{ $tarefa->titulo }}</td>
                                            <td class="p-3 text-sm text-earth-700">
                                                {{ \Illuminate\Support\Str::limit($tarefa->descricao, 120) }}
                                            </td>
                                            <td class="p-3">{{ $tarefa->responsavel->nome ?? '—' }}</td>
                                            <td class="p-3">{{ $tarefa->area->nome ?? '—' }}</td>
                                            <td class="p-3 text-sm">{{ $tarefa->prazo }}</td>
                                            <td class="p-3">
                                                <form action="{{ route('tarefas.update', $tarefa->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    <select name="prioridade" onchange="this.form.submit()"
                                                        class="px-2 py-1 rounded text-xs font-semibold {{ $tarefa->prioridade == 'Alta' ? 'bg-red-100 text-red-800' : ($tarefa->prioridade == 'Média' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                        <option value="Alta"
                                                            {{ $tarefa->prioridade == 'Alta' ? 'selected' : '' }}>Alta
                                                        </option>
                                                        <option value="Média"
                                                            {{ $tarefa->prioridade == 'Média' ? 'selected' : '' }}>Média
                                                        </option>
                                                        <option value="Baixa"
                                                            {{ $tarefa->prioridade == 'Baixa' ? 'selected' : '' }}>Baixa
                                                        </option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="p-3">
                                                <form action="{{ route('tarefas.update', $tarefa->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="px-2 py-1 rounded text-xs font-semibold {{ $tarefa->status == 'Concluída' ? 'bg-green-100 text-green-800' : ($tarefa->status == 'Em Andamento' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                        <option value="Pendente"
                                                            {{ $tarefa->status == 'Pendente' ? 'selected' : '' }}>Pendente
                                                        </option>
                                                        <option value="Em Andamento"
                                                            {{ $tarefa->status == 'Em Andamento' ? 'selected' : '' }}>Em
                                                            Andamento</option>
                                                        <option value="Concluída"
                                                            {{ $tarefa->status == 'Concluída' ? 'selected' : '' }}>
                                                            Concluída
                                                        </option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="p-3 text-center">
                                                <a href="{{ route('tarefas.edit', $tarefa) }}"
                                                    class="px-3 py-1 border rounded text-sm">Editar</a>

                                                <form action="{{ route('tarefas.destroy', [$tarefa->id]) }}"
                                                    method="POST" class="inline-block ml-2"
                                                    onsubmit="return confirm('Excluir essa tarefa?');">
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

                        <div class="mt-3 text-sm text-earth-700">Total: <strong>{{ $tarefas->count() }}</strong> tarefas
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* paleta terrosa local */
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('searchTask');
            const filterArea = document.getElementById('filterArea');
            const filterResp = document.getElementById('filterResp');
            const filterStatus = document.getElementById('filterStatus');
            const clearBtn = document.getElementById('clearFilters');
            const tbody = document.getElementById('tasksTableBody');

            function applyFilter() {
                const q = (search.value || '').trim().toLowerCase();
                const a = (filterArea.value || '').trim().toLowerCase();
                const r = (filterResp.value || '').trim().toLowerCase();
                const s = (filterStatus.value || '').trim().toLowerCase();

                Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                    const titulo = (tr.children[0].textContent || '').toLowerCase();
                    const desc = (tr.children[1].textContent || '').toLowerCase();
                    const resp = (tr.children[2].textContent || '').toLowerCase();
                    const area = (tr.children[3].textContent || '').toLowerCase();
                    const status = (tr.children[6].querySelector('select') ? tr.children[6].querySelector(
                        'select').value.toLowerCase() : '');

                    const match = (!q || titulo.includes(q) || desc.includes(q) || resp.includes(q) || area
                            .includes(q)) &&
                        (!a || area.includes(a)) &&
                        (!r || resp.includes(r)) &&
                        (!s || status.includes(s));

                    tr.style.display = match ? '' : 'none';
                });
            }

            search.addEventListener('input', applyFilter);
            filterArea.addEventListener('change', applyFilter);
            filterResp.addEventListener('change', applyFilter);
            filterStatus.addEventListener('change', applyFilter);
            clearBtn.addEventListener('click', () => {
                search.value = '';
                filterArea.value = '';
                filterResp.value = '';
                filterStatus.value = '';
                applyFilter();
            });

            // export CSV
            document.getElementById('exportCsv').addEventListener('click', () => {
                const headers = ['Título', 'Descrição', 'Responsável', 'Área', 'Prazo', 'Prioridade',
                    'Status'
                ];
                const rows = [];
                Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                    if (tr.style.display === 'none') return;
                    const titulo = tr.children[0].textContent.trim();
                    const desc = tr.children[1].textContent.trim();
                    const resp = tr.children[2].textContent.trim();
                    const area = tr.children[3].textContent.trim();
                    const prazo = tr.children[4].textContent.trim();
                    const prioridade = tr.children[5].textContent.trim();
                    const status = tr.children[6].querySelector('select') ? tr.children[6]
                        .querySelector('select').value.trim() : '';
                    rows.push([titulo, desc, resp, area, prazo, prioridade, status]);
                });
                const csv = [headers.join(','), ...rows.map(r => r.map(c =>
                    `"${String(c).replace(/\"/g, '""')}"`).join(','))].join('\n');
                const blob = new Blob([csv], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'tarefas.csv';
                link.click();
            });
        });
    </script>
@endpush
