@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-earth-50 p-6">
    <div class="max-w-6xl mx-auto">
      <div class="bg-white/90 rounded-xl shadow-lg border border-earth-100 p-6">
        <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
          <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-earth-800">Áreas de Responsabilidade</h1>
            <p class="text-sm text-earth-700/80">Cadastre as áreas do evento e vincule o responsável.</p>
          </div>
          <div class="flex gap-2">
            <a href="{{ route('responsaveis.index') }}" class="px-4 py-2 border rounded text-earth-700">Responsáveis</a>
            <button id="exportCsv" class="px-4 py-2 bg-earth-600 text-white rounded">Exportar CSV</button>
          </div>
        </header>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
          <!-- Form de cadastro -->
          <div class="lg:col-span-1 bg-white p-4 rounded shadow-sm border border-earth-100">
            <h2 class="font-semibold text-lg text-earth-800 mb-3">Cadastrar nova área</h2>
            @if (isset($inputs))
              <form action="{{ route('areas.update') }}" method="POST" id="formArea">
                @csrf
                <input type="hidden" name="id" value="{{$inputs['id']}}">
                <div class="mb-3">
                  <label class="block text-sm font-medium text-earth-700">Nome da área</label>
                  <input name="nome" type="text" value="{{$inputs['nome']}}" required class="w-full p-2 border rounded mt-1"
                    placeholder="Ex: Pista, Patrocínios">
                </div>

                <div class="mb-3">
                  <label class="block text-sm font-medium text-earth-700">Descrição</label>
                  <textarea name="descricao" value="{{$inputs['descricao']}}" rows="3" class="w-full p-2 border rounded mt-1"
                    placeholder="Opcional">{{$inputs['descricao']}}</textarea>
                </div>

                <div class="mb-3">
                  <label class="block text-sm font-medium text-earth-700">Responsável</label>
                  <select name="responsavel_id" value="{{$inputs['responsavel_id']}}" required class="w-full p-2 border rounded mt-1">
                    <option value="">-- Selecionar --</option>
                    @foreach($responsaveis as $resp)
                      <option value="{{ $resp->id }}" {{ $inputs['responsavel_id'] == $resp->id ? 'selected' : '' }}>
                        {{ $resp->nome }} — {{ $resp->area_responsabilidade ?? '' }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                  <a href="{{ route('areas.index') }}" class="px-4 py-2 border rounded">Cancelar Atualização</a>
                  <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Atualizar Area</button>
                </div>
              </form>
            @else
              <form action="{{ route('areas.store') }}" method="POST" id="formArea">
                @csrf
                <div class="mb-3">
                  <label class="block text-sm font-medium text-earth-700">Nome da área</label>
                  <input name="nome" type="text" required class="w-full p-2 border rounded mt-1"
                    placeholder="Ex: Pista, Patrocínios" value="{{ old('nome') }}">
                </div>

                <div class="mb-3">
                  <label class="block text-sm font-medium text-earth-700">Descrição</label>
                  <textarea name="descricao" rows="3" class="w-full p-2 border rounded mt-1"
                    placeholder="Opcional">{{ old('descricao') }}</textarea>
                </div>

                <div class="mb-3">
                  <label class="block text-sm font-medium text-earth-700">Responsável</label>
                  <select name="responsavel_id" required class="w-full p-2 border rounded mt-1">
                    <option value="">-- Selecionar --</option>
                    @foreach($responsaveis as $resp)
                      <option value="{{ $resp->id }}" {{ old('responsavel_id') == $resp->id ? 'selected' : '' }}>
                        {{ $resp->nome }} — {{ $resp->area_responsabilidade ?? '' }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                  <a href="{{ route('areas.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                  <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar área</button>
                </div>
              </form>
            @endif
          </div>

          <!-- Pesquisa / filtros -->
          <div class="lg:col-span-2">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
              <div class="flex-1 flex gap-2">
                <input id="searchArea" placeholder="Pesquisar por nome, descrição ou responsável"
                  class="flex-1 p-2 border rounded" />
                <select id="filterResp" class="p-2 border rounded w-56">
                  <option value="">Todos os responsáveis</option>
                  @foreach($responsaveis as $resp)
                    <option value="{{ $resp->nome }}">{{ $resp->nome }}</option>
                  @endforeach
                </select>
              </div>
              <div class="flex gap-2">
                <button id="clearFilters" class="px-3 py-2 border rounded">Limpar</button>
              </div>
            </div>

            <div class="overflow-x-auto bg-white rounded border border-earth-100">
              <table class="w-full min-w-[800px]">
                <thead class="bg-earth-700 text-earth-50 text-sm">
                  <tr>
                    <th class="p-3 text-left">Nome</th>
                    <th class="p-3 text-left">Descrição</th>
                    <th class="p-3 text-left">Responsável</th>
                    <th class="p-3 text-center">Ações</th>
                  </tr>
                </thead>
                <tbody id="areasTableBody">
                  @foreach($areas as $area)
                    <tr class="even:bg-earth-50">
                      <td class="p-3">{{ $area->nome }}</td>
                      <td class="p-3 text-sm text-earth-700">{{ 
                        \Illuminate\Support\Str::limit($area->descricao, 120) }}</td>
                      <td class="p-3">{{ $area->responsavel->nome ?? '—' }}</td>
                      <td class="p-3 text-center">
                        <a href="{{ route('areas.edit', [$area->id]) }}" class="px-3 py-1 border rounded text-sm">Editar</a>

                        <form action="{{ route('areas.destroy', [$area->id]) }}" method="POST" class="inline-block ml-2"
                          onsubmit="return confirm('Excluir essa área?');">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="id" value="{{ $area->id }}">
                          <button type="submit" class="px-3 py-1 border rounded text-sm text-red-600">Excluir</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="mt-3 text-sm text-earth-700">Total: <strong>{{ $areas->count() }}</strong> áreas</div>
          </div>
        </section>

      </div>
    </div>
  </div>

@endsection

@push('styles')
  <style>
    /* mantém a paleta terrosa caso o layout principal não defina */
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
    // busca client-side (filtra linhas da tabela)
    document.addEventListener('DOMContentLoaded', function () {
      const search = document.getElementById('searchArea');
      const filterResp = document.getElementById('filterResp');
      const clearBtn = document.getElementById('clearFilters');
      const tbody = document.getElementById('areasTableBody');

      function applyFilter() {
        const q = (search.value || '').trim().toLowerCase();
        const r = (filterResp.value || '').trim().toLowerCase();
        Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
          const nome = (tr.children[0].textContent || '').toLowerCase();
          const desc = (tr.children[1].textContent || '').toLowerCase();
          const resp = (tr.children[2].textContent || '').toLowerCase();
          const match = (!q || nome.includes(q) || desc.includes(q) || resp.includes(q)) && (!r || resp.includes(r));
          tr.style.display = match ? '' : 'none';
        });
      }

      search.addEventListener('input', applyFilter);
      filterResp.addEventListener('change', applyFilter);
      clearBtn.addEventListener('click', () => { search.value = ''; filterResp.value = ''; applyFilter(); });

      // export CSV (client-side, based on table rows)
      document.getElementById('exportCsv').addEventListener('click', () => {
        const headers = ['Nome', 'Descricao', 'Responsavel'];
        const rows = [];
        Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
          if (tr.style.display === 'none') return; // pular linhas ocultas
          const cells = Array.from(tr.children).slice(0, 3).map(td => td.textContent.trim());
          rows.push(cells);
        });
        const csv = [headers.join(','), ...rows.map(r => r.map(c => `"${String(c).replace(/\"/g, '""')}"`).join(','))].join('\n');
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a'); link.href = URL.createObjectURL(blob); link.download = 'areas.csv'; link.click();
      });
    });
  </script>
@endpush