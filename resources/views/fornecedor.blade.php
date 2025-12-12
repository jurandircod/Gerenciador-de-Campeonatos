@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-earth-50 p-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white/90 rounded-xl shadow-lg border border-earth-100 p-6">
                <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-earth-800">Fornecedores</h1>
                        <p class="text-sm text-earth-700/80">Gerencie fornecedores de som, alimentação, estrutura e mais.</p>
                    </div>
                    <div class="flex gap-2">
                        <button id="exportCsv" class="px-4 py-2 bg-earth-600 text-white rounded">Exportar CSV</button>
                        <a href="{{ route('fornecedores.store') }}" class="px-4 py-2 border rounded text-earth-700">Novo
                            fornecedor</a>
                    </div>
                </header>

                <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Form de cadastro rápido -->
                    <div class="lg:col-span-1 bg-white p-4 rounded shadow-sm border border-earth-100">
                        @if (isset($inputs))
                            <h2 class="font-semibold text-lg text-earth-800 mb-3">Cadastrar fornecedor</h2>
                            <form action="{{ route('fornecedores.update') }}" method="POST" id="formForn">
                                @csrf

                                <input type="hidden" name="id" value="{{ $inputs['id'] }}">
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Nome</label>
                                    <input name="nome" type="text" required class="w-full p-2 border rounded mt-1"
                                        placeholder="Nome da empresa / pessoa" value="{{ $inputs['nome'] }}">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Tipo</label>
                                    <select name="tipo" required class="w-full p-2 border rounded mt-1">
                                        <option value="{{ $inputs['tipo'] }}" selected>{{ $inputs['tipo'] }}</option>
                                        <option value="Som">Som</option>
                                        <option value="Alimentação">Alimentação</option>
                                        <option value="Estrutura">Estrutura</option>
                                        <option value="Pista">Pista</option>
                                        <option value="Outros">Outros</option>
                                    </select>
                                </div>

                                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Contato (nome)</label>
                                        <input name="contato_nome" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ $inputs['contato_nome'] }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Telefone</label>
                                        <input name="contato_telefone" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ $inputs['contato_telefone'] }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Email</label>
                                    <input name="contato_email" type="email" class="w-full p-2 border rounded mt-1"
                                        value="{{ $inputs['contato_email'] }}">
                                </div>

                                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Valor orçado</label>
                                        <input name="valor_orcamento" type="number" step="0.01"
                                            class="w-full p-2 border rounded mt-1" value="{{ $inputs['valor_orcamento'] }}"
                                            placeholder="0.00">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Status</label>
                                        <select name="status" class="w-full p-2 border rounded mt-1">
                                            <option value="{{ $inputs['status'] }}" selected>{{ $inputs['status'] }}</option>
                                            <option value="Orçamento">Orçamento</option>
                                            <option value="Contratado">Contratado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Observações</label>
                                    <textarea name="observacoes" rows="3" class="w-full p-2 border rounded mt-1"
                                        placeholder="Notas sobre orçamento/contrato">{{ $inputs['observacoes'] }}</textarea>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('fornecedores.index') }}"
                                        class="px-4 py-2 border rounded">Cancelar</a>
                                    <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar</button>
                                </div>
                            </form>
                        @else
                            <h2 class="font-semibold text-lg text-earth-800 mb-3">Cadastrar fornecedor</h2>
                            <form action="{{ route('fornecedores.store') }}" method="POST" id="formForn">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Nome</label>
                                    <input name="nome" type="text" required class="w-full p-2 border rounded mt-1"
                                        placeholder="Nome da empresa / pessoa" value="{{ old('nome') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Tipo</label>
                                    <select name="tipo" required class="w-full p-2 border rounded mt-1">
                                        <option value="Som">Som</option>
                                        <option value="Alimentação">Alimentação</option>
                                        <option value="Estrutura">Estrutura</option>
                                        <option value="Pista">Pista</option>
                                        <option value="Outros">Outros</option>
                                    </select>
                                </div>

                                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Contato (nome)</label>
                                        <input name="contato_nome" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ old('contato_nome') }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Telefone</label>
                                        <input name="contato_telefone" type="text"
                                            class="w-full p-2 border rounded mt-1" value="{{ old('contato_telefone') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Email</label>
                                    <input name="contato_email" type="email" class="w-full p-2 border rounded mt-1"
                                        value="{{ old('contato_email') }}">
                                </div>

                                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Valor orçado</label>
                                        <input name="valor_orcamento" type="number" step="0.01"
                                            class="w-full p-2 border rounded mt-1" value="{{ old('valor_orcamento') }}"
                                            placeholder="0.00">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Status</label>
                                        <select name="status" class="w-full p-2 border rounded mt-1">
                                            <option value="Orçamento">Orçamento</option>
                                            <option value="Contratado">Contratado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Observações</label>
                                    <textarea name="observacoes" rows="3" class="w-full p-2 border rounded mt-1"
                                        placeholder="Notas sobre orçamento/contrato">{{ old('observacoes') }}</textarea>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('fornecedores.index') }}"
                                        class="px-4 py-2 border rounded">Cancelar</a>
                                    <button type="submit"
                                        class="px-4 py-2 bg-earth-500 text-white rounded">Salvar</button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Lista / filtros -->
                    <div class="lg:col-span-2">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <div class="flex-1 flex gap-2">
                                <input id="searchForn" placeholder="Pesquisar por nome, contato, telefone ou observação"
                                    class="flex-1 p-2 border rounded" />
                                <select id="filterTipo" class="p-2 border rounded w-48">
                                    <option value="">Todos os tipos</option>
                                    <option value="Som">Som</option>
                                    <option value="Alimentação">Alimentação</option>
                                    <option value="Estrutura">Estrutura</option>
                                    <option value="Pista">Pista</option>
                                    <option value="Outros">Outros</option>
                                </select>
                                <select id="filterStatus" class="p-2 border rounded w-48">
                                    <option value="">Todos os status</option>
                                    <option value="Orçamento">Orçamento</option>
                                    <option value="Contratado">Contratado</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button id="clearFilters" class="px-3 py-2 border rounded">Limpar</button>
                            </div>
                        </div>

                        <div class="overflow-x-auto bg-white rounded border border-earth-100">
                            <table class="w-full min-w-[1000px]">
                                <thead class="bg-earth-700 text-earth-50 text-sm">
                                    <tr>
                                        <th class="p-3 text-left">Nome</th>
                                        <th class="p-3 text-left">Tipo</th>
                                        <th class="p-3 text-left">Contato</th>
                                        <th class="p-3 text-left">Telefone</th>
                                        <th class="p-3 text-left">Valor</th>
                                        <th class="p-3 text-left">Status</th>
                                        <th class="p-3 text-left">Observações</th>
                                        <th class="p-3 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="fornTableBody">
                                    @foreach ($fornecedores as $f)
                                        <tr class="even:bg-earth-50">
                                            <td class="p-3 font-semibold">{{ $f->nome }}</td>
                                            <td class="p-3">{{ $f->tipo }}</td>
                                            <td class="p-3 text-sm">{{ $f->contato_nome }}<br><span
                                                    class="text-xs text-earth-700">{{ $f->contato_email }}</span></td>
                                            <td class="p-3">{{ $f->contato_telefone }}</td>
                                            <td class="p-3">R$
                                                {{ number_format($f->valor_orcamento ?? 0, 2, ',', '.') }}</td>
                                            <td class="p-3">{{ $f->status }}</td>
                                            <td class="p-3 text-sm text-earth-700">
                                                {{ \Illuminate\Support\Str::limit($f->observacoes, 150) }}</td>
                                            <td class="p-3 text-center">
                                                <a href="{{ route('fornecedores.edit', $f->id) }}"
                                                    class="px-3 py-1 border rounded text-sm">Editar</a>

                                                <form action="{{ route('fornecedores.destroy', [$f->id]) }}" method="POST"
                                                    class="inline-block ml-2"
                                                    onsubmit="return confirm('Excluir esse fornecedor?');">
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

                        <div class="mt-3 text-sm text-earth-700">Total: <strong>{{ $fornecedores->count() }}</strong>
                            fornecedores</div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection

@push('styles')
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('searchForn');
            const filterTipo = document.getElementById('filterTipo');
            const filterStatus = document.getElementById('filterStatus');
            const clearBtn = document.getElementById('clearFilters');
            const tbody = document.getElementById('fornTableBody');

            function applyFilter() {
                const q = (search.value || '').trim().toLowerCase();
                const t = (filterTipo.value || '').trim().toLowerCase();
                const s = (filterStatus.value || '').trim().toLowerCase();

                Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                    const nome = (tr.children[0].textContent || '').toLowerCase();
                    const tipo = (tr.children[1].textContent || '').toLowerCase();
                    const contato = (tr.children[2].textContent || '').toLowerCase();
                    const tel = (tr.children[3].textContent || '').toLowerCase();
                    const valor = (tr.children[4].textContent || '').toLowerCase();
                    const status = (tr.children[5].textContent || '').toLowerCase();
                    const obs = (tr.children[6].textContent || '').toLowerCase();

                    const match = (!q || nome.includes(q) || tipo.includes(q) || contato.includes(q) || tel
                            .includes(q) || valor.includes(q) || obs.includes(q)) &&
                        (!t || tipo.includes(t)) &&
                        (!s || status.includes(s));

                    tr.style.display = match ? '' : 'none';
                });
            }

            search.addEventListener('input', applyFilter);
            filterTipo.addEventListener('change', applyFilter);
            filterStatus.addEventListener('change', applyFilter);
            clearBtn.addEventListener('click', () => {
                search.value = '';
                filterTipo.value = '';
                filterStatus.value = '';
                applyFilter();
            });

            // export CSV
            document.getElementById('exportCsv').addEventListener('click', () => {
                const headers = ['Nome', 'Tipo', 'ContatoNome', 'ContatoEmail', 'Telefone', 'Valor',
                    'Status', 'Observacoes'
                ];
                const rows = [];
                Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                    if (tr.style.display === 'none') return;
                    const nome = tr.children[0].textContent.trim();
                    const tipo = tr.children[1].textContent.trim();
                    const contatoNome = tr.children[2].childNodes[0] ? tr.children[2].childNodes[0]
                        .textContent.trim() : '';
                    const contatoEmail = tr.children[2].querySelector('span') ? tr.children[2]
                        .querySelector('span').textContent.trim() : '';
                    const telefone = tr.children[3].textContent.trim();
                    const valor = tr.children[4].textContent.trim();
                    const status = tr.children[5].textContent.trim();
                    const obs = tr.children[6].textContent.trim();
                    rows.push([nome, tipo, contatoNome, contatoEmail, telefone, valor, status,
                    obs]);
                });
                const csv = [headers.join(','), ...rows.map(r => r.map(c =>
                    `"${String(c).replace(/\"/g,'""')}"`).join(','))].join('\n');
                const blob = new Blob([csv], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'fornecedores.csv';
                link.click();
            });
        });
    </script>
@endpush
