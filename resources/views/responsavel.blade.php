@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-earth-50 p-6">
        <div class="max-w-5xl mx-auto bg-white/90 p-6 rounded-xl shadow-lg border border-earth-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-earth-800">Cadastro de Responsáveis</h1>
                    <p class="text-sm text-earth-700/80 mt-1">Cadastre, pesquise e gerencie os responsáveis do evento.</p>
                </div>
                <div class="flex gap-2 items-center">
                    <button id="exportCsvBtn" class="px-3 py-2 bg-earth-600 text-white rounded shadow-sm">Exportar
                        CSV</button>
                    <button id="limparFormBtn" class="px-3 py-2 border rounded">Limpar formulário</button>
                </div>
            </div>

            <!-- Formulário -->
            @if (isset($inputs))
                <form id="formResponsavel" action="{{ route('responsaveis.update', [$inputs['id']]) }}" method="POST"
                    class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @csrf
                    <input type="hidden" name="id" value="{{ $inputs['id'] }}">
                    <div>
                        <label class="text-sm font-medium text-earth-700">Nome</label>
                        <input type="text" name="nome" value="{{ $inputs['nome'] }}" id="nome" placeholder="Nome"
                            class="w-full p-2 border rounded" required />
                        @error('nome')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-earth-700">Email</label>
                        <input type="email" name="email" value="{{ $inputs['email'] }}" id="email" placeholder="Email"
                            class="w-full p-2 border rounded" required />
                        @error('email')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-earth-700">Telefone</label>
                        <input type="text" name="telefone" value="{{ $inputs['telefone'] }}" id="telefone" placeholder="Telefone"
                            class="w-full p-2 border rounded" />
                        @error('telefone')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-earth-700">Área de responsabilidade</label>
                        <input type="text" name="area_responsabilidade" value="{{ $inputs['area_responsabilidade'] }}"
                            id="area_responsabilidade" placeholder="Área de responsabilidade" class="w-full p-2 border rounded"
                            required />
                        @error('area_responsabilidade')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                        <a href="{{ route('responsaveis.index') }}" class="px-4 py-2 border rounded">Cancelar Atualização</a>
                        <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Atualizar Responsável</button>
                    </div>
                </form>
            @else
                <form id="formResponsavel" action="{{ route('responsaveis.store') }}" method="POST"
                    class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @csrf
                    <div>
                        <label class="text-sm font-medium text-earth-700">Nome</label>
                        <input type="text" name="nome" value="{{ old('nome') }}" id="nome" placeholder="Nome"
                            class="w-full p-2 border rounded" required />
                        @error('nome')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-earth-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" id="email" placeholder="Email"
                            class="w-full p-2 border rounded" required />
                        @error('email')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-earth-700">Telefone</label>
                        <input type="text" name="telefone" value="{{ old('telefone') }}" id="telefone" placeholder="Telefone"
                            class="w-full p-2 border rounded" />
                        @error('telefone')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-earth-700">Área de responsabilidade</label>
                        <input type="text" name="area_responsabilidade" value="{{ old('area_responsabilidade') }}"
                            id="area_responsabilidade" placeholder="Área de responsabilidade" class="w-full p-2 border rounded"
                            required />
                        @error('area_responsabilidade')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                        <button type="button" id="btnClear" class="px-4 py-2 border rounded">Limpar</button>
                        <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar</button>
                    </div>
                </form>
            @endif
            <!-- Listagem -->
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xl font-semibold text-earth-800">Responsáveis cadastrados</h2>
                <div class="text-sm text-earth-600">Total: <strong id="totalCount">0</strong></div>
            </div>

            <!-- Pesquisa -->
            <div class="mb-4 flex gap-3">
                <input id="pesquisaTexto" placeholder="Pesquisar por nome, email ou área"
                    class="flex-1 p-2 border rounded" />
                <button id="limparPesquisa" class="px-3 py-2 border rounded">Limpar</button>
            </div>

            <div class="overflow-x-auto rounded border border-earth-100">
                <table class="w-full divide-y bg-white">
                    <thead class="bg-earth-300 text-earth-900">
                        <tr>
                            <th class="p-3 text-left">Nome</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Telefone</th>
                            <th class="p-3 text-left">Área</th>
                            <th class="p-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyResp" class="text-sm">
                        <!-- Carregado via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
            // Toastr config
            toastr.options = { closeButton: true, progressBar: true, positionClass: 'toast-top-right', timeOut: 5000, extendedTimeOut: 1000 };

            @if($errors->any())
                @foreach($errors->all() as $error)
                    toastr.error("{{ $error }}", 'Erro de Validação');
                @endforeach
            @endif

            document.addEventListener('DOMContentLoaded', carregarResponsaveis);
            // Table management
            let responsaveis = [];
            let visiveis = [];
            const tbody = document.getElementById('tbodyResp');
            const totalCount = document.getElementById('totalCount');

            async function carregarResponsaveis() {
                try {
                    const res = await fetch('/api/responsaveis');
                    console.log(res);
                    if (!res.ok) throw new Error('Falha ao carregar');
                    responsaveis = await res.json(); visiveis = [...responsaveis]; renderTabela();
                } catch (err) { console.error(err); toastr.error('Erro ao carregar responsáveis'); }
            }

            function renderTabela() {
                tbody.innerHTML = '';
                visiveis.forEach(r => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                                <td class="p-3">${escapeHtml(r.nome)}</td>
                                <td class="p-3">${escapeHtml(r.email)}</td>
                                <td class="p-3">${escapeHtml(r.telefone || '')}</td>
                                <td class="p-3">${escapeHtml(r.area_responsabilidade || '')}</td>
                                <td class="p-3 text-center">
                                  <a href="/responsaveis/${r.id}/edit" class="text-sm px-2 py-1 border rounded mr-2">Editar</a>
                                  <button data-id="${r.id}" class="text-red-600 hover:text-red-800 btn-delete">Excluir</button>
                                </td>
                              `;
                    tbody.appendChild(tr);
                });
                totalCount.textContent = visiveis.length;

                document.querySelectorAll('.btn-delete').forEach(b => b.addEventListener('click', () => remover(+b.dataset.id)));
            }

            function aplicarPesquisa() {
                const q = (document.getElementById('pesquisaTexto').value || '').trim().toLowerCase();
                visiveis = responsaveis.filter(r =>
                    (r.nome && r.nome.toLowerCase().includes(q)) ||
                    (r.email && r.email.toLowerCase().includes(q)) ||
                    (r.area_responsabilidade && r.area_responsabilidade.toLowerCase().includes(q))
                );
                renderTabela();
            }

            async function remover(id) {
                if (!confirm('Tem certeza que deseja excluir este responsável?')) return;
                try {
                    const token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
                    const res = await fetch(`/responsaveis/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': token, 'Content-Type': 'application/json' } });
                    if (res.ok) { toastr.success('Responsável excluído'); carregarResponsaveis(); } else { toastr.error('Erro ao excluir'); }
                } catch (err) { console.error(err); toastr.error('Erro na requisição'); }
            }

            // helpers
            function escapeHtml(text) { if (!text) return ''; return text.replace(/[&<>"']/g, function (ch) { return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": "&#39;" })[ch]; }); }

            // events
            document.getElementById('pesquisaTexto').addEventListener('input', aplicarPesquisa);
            document.getElementById('limparPesquisa').addEventListener('click', () => { document.getElementById('pesquisaTexto').value = ''; visiveis = [...responsaveis]; renderTabela(); });
            document.getElementById('btnClear').addEventListener('click', () => document.getElementById('formResponsavel').reset());
            document.getElementById('limparFormBtn').addEventListener('click', () => document.getElementById('formResponsavel').reset());

            document.getElementById('exportCsvBtn').addEventListener('click', () => {
                const headers = ['nome', 'email', 'telefone', 'area_responsabilidade'];
                const rows = responsaveis.map(r => [r.nome, r.email, r.telefone || '', r.area_responsabilidade || '']);
                const csv = [headers.join(','), ...rows.map(row => row.map(c => `"${String(c).replace(/"/g, '""')}"`).join(','))].join('\n');
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a'); link.href = URL.createObjectURL(blob); link.download = 'responsaveis.csv'; link.click();
            });

        </script>
    @endpush
@endsection