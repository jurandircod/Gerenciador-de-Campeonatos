@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-earth-50 p-6">
  <div class="max-w-6xl mx-auto">
    <div class="bg-white/90 rounded-xl shadow-lg border border-earth-100 p-6">
      <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
          <h1 class="text-2xl md:text-3xl font-extrabold text-earth-800">Orçamento</h1>
          <p class="text-sm text-earth-700/80">Controle de receitas e despesas do evento.</p>
        </div>
        <div class="flex gap-2">
          <button id="exportCsv" class="px-4 py-2 bg-earth-600 text-white rounded">Exportar CSV</button>
          <a href="{{ route('orcamentos.store') }}" class="px-4 py-2 border rounded text-earth-700">Nova entrada</a>
        </div>
      </header>

      <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Form de cadastro rápido -->
        <div class="lg:col-span-1 bg-white p-4 rounded shadow-sm border border-earth-100">
          <h2 class="font-semibold text-lg text-earth-800 mb-3">Adicionar item</h2>
          <form action="{{ route('orcamentos.store') }}" method="POST" id="formOrc">
            @csrf
            <div class="mb-3">
              <label class="block text-sm font-medium text-earth-700">Categoria</label>
              <input name="categoria" type="text" required class="w-full p-2 border rounded mt-1" placeholder="Ex: Patrocínios, Pista, Som" value="{{ old('categoria') }}">
            </div>

            <div class="mb-3">
              <label class="block text-sm font-medium text-earth-700">Descrição</label>
              <input name="descricao" type="text" required class="w-full p-2 border rounded mt-1" placeholder="Descrição do item" value="{{ old('descricao') }}">
            </div>

            <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-sm font-medium text-earth-700">Valor previsto</label>
                <input name="valor_previsto" type="number" step="0.01" required class="w-full p-2 border rounded mt-1" value="{{ old('valor_previsto', 0) }}">
              </div>
              <div>
                <label class="block text-sm font-medium text-earth-700">Valor realizado</label>
                <input name="valor_realizado" type="number" step="0.01" class="w-full p-2 border rounded mt-1" value="{{ old('valor_realizado', 0) }}">
              </div>
            </div>

            <div class="mb-3">
              <label class="block text-sm font-medium text-earth-700">Tipo</label>
              <select name="tipo" required class="w-full p-2 border rounded mt-1">
                <option value="Receita">Receita</option>
                <option value="Despesa">Despesa</option>
              </select>
            </div>

            <div class="flex justify-end gap-2 mt-4">
              <a href="{{ route('orcamentos.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
              <button type="submit" class="px-4 py-2 bg-earth-500 text-white rounded">Salvar</button>
            </div>
          </form>

          <div class="mt-6 text-sm text-earth-700">
            <div><strong>Resumo visível:</strong></div>
            <div>Previsto: <span id="sumPrev">R$ 0,00</span></div>
            <div>Realizado: <span id="sumReal">R$ 0,00</span></div>
            <div>Saldo: <span id="sumSaldo">R$ 0,00</span></div>
          </div>
        </div>

        <!-- Lista / filtros -->
        <div class="lg:col-span-2">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <div class="flex-1 flex gap-2">
              <input id="searchOrc" placeholder="Pesquisar por categoria ou descrição" class="flex-1 p-2 border rounded" />
              <select id="filterTipo" class="p-2 border rounded w-48">
                <option value="">Todos os tipos</option>
                <option value="Receita">Receita</option>
                <option value="Despesa">Despesa</option>
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
                  <th class="p-3 text-left">Categoria</th>
                  <th class="p-3 text-left">Descrição</th>
                  <th class="p-3 text-left">Previsto</th>
                  <th class="p-3 text-left">Realizado</th>
                  <th class="p-3 text-left">Tipo</th>
                  <th class="p-3 text-center">Ações</th>
                </tr>
              </thead>
              <tbody id="orcTableBody">
                @foreach($orcamentos as $o)
                <tr class="even:bg-earth-50">
                  <td class="p-3 font-semibold">{{ $o->categoria }}</td>
                  <td class="p-3 text-sm text-earth-700">{{ \Illuminate\Support\Str::limit($o->descricao, 120) }}</td>
                  <td class="p-3" data-value="{{ $o->valor_previsto }}">R$ {{ number_format($o->valor_previsto, 2, ',', '.') }}</td>
                  <td class="p-3" data-value="{{ $o->valor_realizado }}">R$ {{ number_format($o->valor_realizado, 2, ',', '.') }}</td>
                  <td class="p-3">{{ $o->tipo }}</td>
                  <td class="p-3 text-center">
                    <a href="{{ route('orcamento.edit', $o) }}" class="px-3 py-1 border rounded text-sm">Editar</a>

                    <form action="{{ route('orcamento.destroy', $o) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Excluir esse item orçamentário?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="px-3 py-1 border rounded text-sm text-red-600">Excluir</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="mt-3 text-sm text-earth-700">Total de lançamentos: <strong>{{ $orcamentos->count() }}</strong></div>
        </div>
      </section>

    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
  :root{ --earth-50: #fbf8f6; --earth-100: #f5efe6; --earth-200: #ead9c2; --earth-300: #dfc29e; --earth-500: #a27045; --earth-700: #6b472b; }
</style>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function(){
    const search = document.getElementById('searchOrc');
    const filterTipo = document.getElementById('filterTipo');
    const clearBtn = document.getElementById('clearFilters');
    const tbody = document.getElementById('orcTableBody');
    const sumPrevEl = document.getElementById('sumPrev');
    const sumRealEl = document.getElementById('sumReal');
    const sumSaldoEl = document.getElementById('sumSaldo');

    function parseBrazilian(str){
      if(!str) return 0;
      // str like 'R$ 1.234,56' or numeric
      if(typeof str === 'number') return str;
      const cleaned = String(str).replace(/[^0-9,-]+/g,'').replace('.', '').replace(/,/g, '.');
      const num = parseFloat(cleaned);
      return isNaN(num) ? 0 : num;
    }

    function formatBR(num){
      return num.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    function recalcSums(){
      let sumPrev = 0;
      let sumReal = 0;
      Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
        if(tr.style.display === 'none') return;
        const prev = parseFloat(tr.children[2].dataset.value || 0);
        const real = parseFloat(tr.children[3].dataset.value || 0);
        sumPrev += isNaN(prev) ? 0 : prev;
        sumReal += isNaN(real) ? 0 : real;
      });
      sumPrevEl.textContent = formatBR(sumPrev);
      sumRealEl.textContent = formatBR(sumReal);
      sumSaldoEl.textContent = formatBR(sumReal - sumPrev);
    }

    function applyFilter(){
      const q = (search.value || '').trim().toLowerCase();
      const t = (filterTipo.value || '').trim().toLowerCase();

      Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
        const cat = (tr.children[0].textContent || '').toLowerCase();
        const desc = (tr.children[1].textContent || '').toLowerCase();
        const tipo = (tr.children[4].textContent || '').toLowerCase();

        const match = (!q || cat.includes(q) || desc.includes(q)) && (!t || tipo.includes(t));
        tr.style.display = match ? '' : 'none';
      });
      recalcSums();
    }

    search.addEventListener('input', applyFilter);
    filterTipo.addEventListener('change', applyFilter);
    clearBtn.addEventListener('click', ()=>{ search.value=''; filterTipo.value=''; applyFilter(); });

    // export CSV
    document.getElementById('exportCsv').addEventListener('click', ()=>{
      const headers = ['Categoria','Descricao','Valor Previsto','Valor Realizado','Tipo'];
      const rows = [];
      Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
        if(tr.style.display === 'none') return;
        const categoria = tr.children[0].textContent.trim();
        const descricao = tr.children[1].textContent.trim();
        const prev = tr.children[2].dataset.value || '0';
        const real = tr.children[3].dataset.value || '0';
        const tipo = tr.children[4].textContent.trim();
        rows.push([categoria, descricao, prev, real, tipo]);
      });
      const csv = [headers.join(','), ...rows.map(r=>r.map(c=>`"${String(c).replace(/\"/g,'""')}"`).join(','))].join('\n');
      const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
      const link = document.createElement('a'); link.href = URL.createObjectURL(blob); link.download = 'orcamento.csv'; link.click();
    });

    // inicializa somatórios
    recalcSums();
  });
</script>
@endpush