@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-earth-50 p-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white/90 rounded-xl shadow-lg border border-earth-100 p-6">
                <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-earth-800">Juízes</h1>
                        <p class="text-sm text-earth-700/80">Cadastre e gerencie os juízes convidados para o campeonato.</p>
                    </div>
                </header>

                <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Form de cadastro rápido -->
                    <div class="lg:col-span-1 bg-white p-4 rounded shadow-sm border border-earth-100">
                        @if (isset($inputs))
                            <h2 class="font-semibold text-lg text-earth-800 mb-3">Cadastrar juiz</h2>
                            <form action="{{ route('juizes.update')}}" method="POST" id="formJuiz">
                                @csrf
                                <input type="hidden" name="id" value="{{ $inputs['id'] }}">
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Nome</label>
                                    <input name="nome" type="text" required class="w-full p-2 border rounded mt-1"
                                        placeholder="Nome completo" value="{{ $inputs['nome'] }}">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Email</label>
                                    <input name="email" type="email" required class="w-full p-2 border rounded mt-1"
                                        placeholder="email@exemplo.com" value="{{ $inputs['email'] }}">
                                </div>

                                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Telefone</label>
                                        <input name="telefone" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ $inputs['telefone'] }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Status</label>
                                        <select name="status" class="w-full p-2 border rounded mt-1">
                                            <option value="{{ $inputs['status'] }}">{{ $inputs['status'] }}</option>
                                            <option value="Convidado">Convidado</option>
                                            <option value="Confirmado">Confirmado</option>
                                            <option value="Recusado">Recusado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Experiência</label>
                                    <textarea name="experiencia" rows="3" class="w-full p-2 border rounded mt-1"
                                        placeholder="Breve descrição de experiência">{{ $inputs['experiencia'] }}</textarea>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('juizes.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                                    <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar
                                        juiz</button>
                                </div>
                            </form>
                        @else
                            <h2 class="font-semibold text-lg text-earth-800 mb-3">Cadastrar juiz</h2>
                            <form action="{{ route('juizes.store') }}" method="POST" id="formJuiz">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Nome</label>
                                    <input name="nome" type="text" required class="w-full p-2 border rounded mt-1"
                                        placeholder="Nome completo" value="{{ old('nome') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Email</label>
                                    <input name="email" type="email" required class="w-full p-2 border rounded mt-1"
                                        placeholder="email@exemplo.com" value="{{ old('email') }}">
                                </div>

                                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Telefone</label>
                                        <input name="telefone" type="text" class="w-full p-2 border rounded mt-1"
                                            value="{{ old('telefone') }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-earth-700">Status</label>
                                        <select name="status" class="w-full p-2 border rounded mt-1">
                                            <option value="Convidado">Convidado</option>
                                            <option value="Confirmado">Confirmado</option>
                                            <option value="Recusado">Recusado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-earth-700">Experiência</label>
                                    <textarea name="experiencia" rows="3" class="w-full p-2 border rounded mt-1"
                                        placeholder="Breve descrição de experiência">{{ old('experiencia') }}</textarea>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('juizes.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                                    <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar
                                        juiz</button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Lista / filtros -->
                    <div class="lg:col-span-2">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <div class="flex-1 flex gap-2">
                                <input id="searchJuiz" placeholder="Pesquisar por nome, email ou experiência"
                                    class="flex-1 p-2 border rounded" />
                                <select id="filterStatus" class="p-2 border rounded w-56">
                                    <option value="">Todos os status</option>
                                    <option value="Convidado">Convidado</option>
                                    <option value="Confirmado">Confirmado</option>
                                    <option value="Recusado">Recusado</option>
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
                                        <th class="p-3 text-left">Email</th>
                                        <th class="p-3 text-left">Telefone</th>
                                        <th class="p-3 text-left">Experiência</th>
                                        <th class="p-3 text-left">Status</th>
                                        <th class="p-3 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="juizTableBody">
                                    @foreach ($juizes as $j)
                                        <tr class="even:bg-earth-50">
                                            <td class="p-3 font-semibold">{{ $j->nome }}</td>
                                            <td class="p-3 text-sm">{{ $j->email }}</td>
                                            <td class="p-3">{{ $j->telefone }}</td>
                                            <td class="p-3 text-sm text-earth-700">
                                                {{ \Illuminate\Support\Str::limit($j->experiencia, 150) }}</td>
                                            <td class="p-3">{{ $j->status }}</td>
                                            <td class="p-3 text-center">
                                                <a href="{{ route('juizes.edit', $j->id) }}"
                                                    class="px-3 py-1 border rounded text-sm">Editar</a>

                                                <form action="{{ route('juizes.destroy', $j->id) }}" method="POST"
                                                    class="inline-block ml-2"
                                                    onsubmit="return confirm('Excluir esse juiz?');">
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

                        <div class="mt-3 text-sm text-earth-700">Total: <strong>{{ $juizes->count() }}</strong> juízes
                        </div>
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
            const search = document.getElementById('searchJuiz');
            const filterStatus = document.getElementById('filterStatus');
            const clearBtn = document.getElementById('clearFilters');
            const tbody = document.getElementById('juizTableBody');

            function applyFilter() {
                const q = (search.value || '').trim().toLowerCase();
                const s = (filterStatus.value || '').trim().toLowerCase();

                Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                    const nome = (tr.children[0].textContent || '').toLowerCase();
                    const email = (tr.children[1].textContent || '').toLowerCase();
                    const tel = (tr.children[2].textContent || '').toLowerCase();
                    const exp = (tr.children[3].textContent || '').toLowerCase();
                    const status = (tr.children[4].textContent || '').toLowerCase();

                    const match = (!q || nome.includes(q) || email.includes(q) || tel.includes(q) || exp
                        .includes(q)) && (!s || status.includes(s));
                    tr.style.display = match ? '' : 'none';
                });
            }

            search.addEventListener('input', applyFilter);
            filterStatus.addEventListener('change', applyFilter);
            clearBtn.addEventListener('click', () => {
                search.value = '';
                filterStatus.value = '';
                applyFilter();
            });

            // export CSV
            document.getElementById('exportCsv').addEventListener('click', () => {
                const headers = ['Nome', 'Email', 'Telefone', 'Experiencia', 'Status'];
                const rows = [];
                Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                    if (tr.style.display === 'none') return;
                    const nome = tr.children[0].textContent.trim();
                    const email = tr.children[1].textContent.trim();
                    const telefone = tr.children[2].textContent.trim();
                    const exp = tr.children[3].textContent.trim();
                    const status = tr.children[4].textContent.trim();
                    rows.push([nome, email, telefone, exp, status]);
                });
                const csv = [headers.join(','), ...rows.map(r => r.map(c =>
                    `"${String(c).replace(/\"/g,'""')}"`).join(','))].join('\n');
                const blob = new Blob([csv], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'juizes.csv';
                link.click();
            });
        });
    </script>
@endpush
