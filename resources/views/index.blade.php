@extends('layouts.app')

@section('content')

<!-- MAIN CONTENT -->
<main class="flex-1 p-4 md:p-6">
  <div class="max-w-7xl mx-auto">
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
      <div>
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold">🛹 Organização - Evento de Skate</h1>
        <p class="text-sm text-earth-700/80 mt-1">Painel central — sessões e campeonatos organizados por área.</p>
      </div>

      <div class="flex flex-col sm:flex-row gap-2 items-stretch sm:items-center">
        <div class="hidden md:flex items-center gap-2 border rounded px-3 py-1 bg-white mr-0 sm:mr-2">
          <label class="text-xs text-earth-600 mr-2">Exibir</label>
          <button id="tabSessions" class="px-3 py-1 rounded text-sm bg-earth-500 text-white">Sessões</button>
          <button id="tabChampionships" class="px-3 py-1 rounded text-sm">Campeonatos</button>
        </div>

        <div class="flex gap-2 w-full sm:w-auto">
          <button id="exportCsvBtn"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-earth-600 hover:bg-earth-700 text-white px-4 py-2 rounded-lg shadow">
            ⬇ Exportar CSV
          </button>

          <button id="clearStorageBtn"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-earth-300 px-4 py-2 rounded-lg text-earth-700 hover:bg-earth-100">
            Limpar dados
          </button>
        </div>
      </div>
    </header>

    <!-- SEÇÃO SESSÕES (Tarefas) - VISÍVEL POR PADRÃO -->
    <div id="sessionsSection">
      <!-- quick stats -->
      <!-- <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="p-4 rounded-lg bg-white/95 border border-earth-100 shadow-sm">
          <div class="text-sm text-earth-600">Tarefas totais</div>
          <div id="statTotal" class="text-2xl font-bold text-earth-800">{{ $tarefas->count() }}</div>
          <div class="text-xs text-earth-600 mt-1">Atualizado localmente</div>
        </div>

        <div class="p-4 rounded-lg bg-white/95 border border-earth-100 shadow-sm">
          <div class="text-sm text-earth-600">Concluídas</div>
          <div id="statDone" class="text-2xl font-bold text-green-700">
            {{ $tarefas->where('status', 'Concluída')->count() }}
          </div>
          <div class="text-xs text-earth-600 mt-1">Última verificação: agora</div>
        </div>

        <div class="p-4 rounded-lg bg-white/95 border border-earth-100 shadow-sm">
          <div class="text-sm text-earth-600">Prazos próximos</div>
          <div id="statDue" class="text-2xl font-bold text-earth-800">
            {{ $tarefas->where('prazo', '>', now()->format('Y-m-d'))->count() }}
          </div>
          <div class="text-xs text-earth-600 mt-1">Nos próximos 7 dias</div>
        </div>
      </section> -->

      <section class="flex flex-col lg:flex-row gap-4 mb-6 mt-4">
        <!-- Filtros compactos -->
        <aside class="w-full lg:w-auto bg-white/95 p-4 rounded border border-earth-100 shadow-sm">
          <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-end">
            <!-- Campo de pesquisa -->
            <div class="flex-1 min-w-0 w-full sm:w-auto">
              <label class="text-sm font-medium text-earth-700 block">Pesquisar</label>
              <input id="searchText" placeholder="Tarefa ou responsável"
                class="mt-1 p-2 border rounded-md w-full text-sm" />
            </div>
            
            <!-- Filtro por responsável -->
            <div class="flex-1 min-w-0 w-full sm:w-auto">
              <label class="text-sm font-medium text-earth-700 block">Responsável</label>
              <select id="filterResponsavel" class="mt-1 p-2 border rounded-md w-full text-sm">
                <option value="">Todos</option>
                @foreach($responsaveis as $responsavel)
                  <option value="{{ $responsavel->id }}">{{ $responsavel->nome }}</option>
                @endforeach
              </select>
            </div>
            
            <!-- Botões lado a lado -->
            <div class="flex gap-2 w-full sm:w-auto mt-2 sm:mt-0">
              <button id="applyFilterBtn" type="button" 
                class="flex-1 sm:flex-none px-4 py-2 bg-earth-500 text-white rounded-md text-sm whitespace-nowrap">
                Aplicar
              </button>
              <button id="clearFilterBtn" type="button" 
                class="flex-1 sm:flex-none px-4 py-2 border rounded-md text-sm whitespace-nowrap">
                Limpar
              </button>
            </div>
          </div>
        </aside>

        <!-- Cards -->
        <div class="flex-1 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3" id="cardsContainerPlaceholder">
          <!-- cards gerados via JS -->
        </div>
      </section>

      <!-- main workspace -->
      <section class="bg-white/95 p-4 rounded-lg shadow border border-earth-100">
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
          <h2 class="font-bold text-lg">Adicionar nova tarefa</h2>
          <div class="text-sm text-earth-600">Use o formulário para criar tarefas rápidas — ajuste depois se precisar.
          </div>
        </div>

        <form id="taskForm" action="{{route('tarefas.store')}}" method="POST"
          class="grid grid-cols-1 md:grid-cols-6 gap-3">
          @csrf
          <input id="titulo" placeholder="Titulo da tarefa" name="titulo" value="{{ old('titulo') }}"
            class="p-2 border rounded-md md:col-span-2 w-full" />

          <select id="responsavel" name="responsavel_id" class="p-2 border rounded-md md:col-span-1 w-full">
            <option value="" selected disabled>Selecione um responsável</option>
            @foreach($responsaveis as $responsavel)
              <option value="{{ $responsavel->id }}" {{ old('responsavel_id') == $responsavel->id ? 'selected' : '' }}>
                {{ $responsavel->nome }}
              </option>
            @endforeach
          </select>

          <select id="area" name="area_id" class="p-2 border rounded-md md:col-span-1 w-full">
            <option value="" selected disabled>Selecione uma área de atuação</option>
            @foreach($areas as $area)
              <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nome }}</option>
            @endforeach
          </select>

          <input type="text" hidden id="prioridade" name="prioridade" value="Média"
            class="p-2 border rounded-md md:col-span-1 w-full">
          <input type="text" hidden id="status" name="status" value="Pendente"
            class="p-2 border rounded-md md:col-span-1 w-full">

          <input id="tarefa" placeholder="Descrição da tarefa" name="descricao" value="{{ old('descricao') }}"
            class="p-2 border rounded-md md:col-span-2 w-full" />
          <input id="prazo" type="date" name="prazo" value="{{ old('prazo') }}"
            class="p-2 border rounded-md md:col-span-1 w-full" />
          <button type="submit"
            class="flex items-center justify-center gap-2 bg-earth-500 hover:bg-earth-600 text-white px-4 py-2 rounded-md md:col-span-1 w-full sm:w-auto">
            ➕ Adicionar
          </button>
        </form>

        <!-- TABLE (desktop) -->
        <div class="mt-6 overflow-x-auto table-scroll hidden md:block">
          <table class="w-full min-w-[900px]">
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
              @foreach($tarefas as $tarefa)
                <tr class="even:bg-earth-50 task-row" 
                    data-titulo="{{ strtolower($tarefa->titulo) }}"
                    data-descricao="{{ strtolower($tarefa->descricao) }}"
                    data-responsavel="{{ $tarefa->responsavel_id }}"
                    data-responsavel-nome="{{ strtolower($tarefa->responsavel->nome ?? '') }}">
                  <td class="p-3 font-semibold">{{ $tarefa->titulo }}</td>
                  <td class="p-3 text-sm text-earth-700">{{ \Illuminate\Support\Str::limit($tarefa->descricao, 120) }}</td>
                  <td class="p-3">{{ $tarefa->responsavel->nome ?? '—' }}</td>
                  <td class="p-3">{{ $tarefa->area->nome ?? '—' }}</td>
                  <td class="p-3 text-sm">{{ $tarefa->prazo ? \Carbon\Carbon::parse($tarefa->prazo)->format('d/m/Y') : '—' }}</td>
                  <td class="p-3">
                    <form action="{{ route('tarefas.update', $tarefa->id) }}" method="POST" class="inline-block">
                      @csrf
                      <select name="prioridade" onchange="this.form.submit()"
                        class="px-2 py-1 rounded text-xs font-semibold {{ $tarefa->prioridade == 'Alta' ? 'bg-red-100 text-red-800' : ($tarefa->prioridade == 'Média' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        <option value="Alta" {{ $tarefa->prioridade == 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Média" {{ $tarefa->prioridade == 'Média' ? 'selected' : '' }}>Média</option>
                        <option value="Baixa" {{ $tarefa->prioridade == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                      </select>
                    </form>
                  </td>
                  <td class="p-3">
                    <form action="{{ route('tarefas.update', $tarefa->id) }}" method="POST" class="inline-block">
                      @csrf
                      <select name="status" onchange="this.form.submit()"
                        class="px-2 py-1 rounded text-xs font-semibold {{ $tarefa->status == 'Concluída' ? 'bg-green-100 text-green-800' : ($tarefa->status == 'Em Andamento' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        <option value="Pendente" {{ $tarefa->status == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="Em Andamento" {{ $tarefa->status == 'Em Andamento' ? 'selected' : '' }}>Em Andamento
                        </option>
                        <option value="Concluída" {{ $tarefa->status == 'Concluída' ? 'selected' : '' }}>Concluída</option>
                      </select>
                    </form>
                  </td>
                  <td class="p-3 text-center">
                    <a href="{{ route('tarefas.edit', $tarefa) }}" class="px-3 py-1 border rounded text-sm">Editar</a>

                    <form action="{{ route('tarefas.destroy', [$tarefa->id]) }}" method="POST" class="inline-block ml-2"
                      onsubmit="return confirm('Excluir essa tarefa?');">
                      @csrf
                      <button type="submit" class="px-3 py-1 border rounded text-sm text-red-600">Excluir</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- MOBILE: card list (shown on small screens) -->
        <div id="mobileTasksContainer" class="md:hidden mt-6 space-y-3">
          @foreach($tarefas as $tarefa)
            <article class="bg-earth-50 border border-earth-100 p-3 rounded-lg shadow-sm task-card" 
                    data-titulo="{{ strtolower($tarefa->titulo) }}"
                    data-descricao="{{ strtolower($tarefa->descricao) }}"
                    data-responsavel="{{ $tarefa->responsavel_id }}"
                    data-responsavel-nome="{{ strtolower($tarefa->responsavel->nome ?? '') }}">
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="font-semibold text-earth-800">{{ $tarefa->titulo }}</h3>
                  <p class="text-sm text-earth-700 mt-1">{{ \Illuminate\Support\Str::limit($tarefa->descricao, 180) }}</p>
                </div>
                <div class="text-xs text-earth-600 text-right ml-2">
                  <div>{{ $tarefa->prazo ? \Carbon\Carbon::parse($tarefa->prazo)->format('d/m/Y') : '—' }}</div>
                  <div class="mt-2">
                    <span
                      class="inline-block px-2 py-1 rounded text-xs {{ $tarefa->prioridade == 'Alta' ? 'bg-red-100 text-red-800' : ($tarefa->prioridade == 'Média' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                      {{ $tarefa->prioridade }}
                    </span>
                  </div>
                </div>
              </div>

              <div class="mt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div class="text-sm text-earth-700">
                  <div>Responsável: <strong>{{ $tarefa->responsavel->nome ?? '—' }}</strong></div>
                  <div>Área: <strong>{{ $tarefa->area->nome ?? '—' }}</strong></div>
                  <div>Prazo: <strong>{{ $tarefa->prazo ? \Carbon\Carbon::parse($tarefa->prazo)->format('d/m/Y') : '—' }}</strong></div>
                  <div>Descrição: <strong>{{ $tarefa->descricao ?? '—' }}</strong></div>
                </div>

                <div class="flex items-center gap-2">
                  <a href="{{ route('tarefas.edit', $tarefa) }}" class="px-3 py-1 border rounded text-sm">Editar</a>

                  <form action="{{ route('tarefas.destroy', [$tarefa->id]) }}" method="POST" class="inline-block"
                    onsubmit="return confirm('Excluir essa tarefa?');">
                    @csrf
                    <button type="submit" class="px-3 py-1 border rounded text-sm text-red-600">Excluir</button>
                  </form>
                </div>
              </div>
            </article>
          @endforeach
        </div>
      </section>
    </div> {{-- end sessionsSection --}}

    <!-- SEÇÃO CAMPEONATOS - ESCONDIDA POR PADRÃO -->
    <div id="championshipSection" class="hidden">
      {{-- Overview cards --}}
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-4">
        <div class="p-4 rounded-lg bg-earth-50 border border-earth-100 shadow-sm">
          <div class="text-sm text-earth-600">Competidores</div>
          <div class="text-2xl font-bold text-earth-800">{{ $competidores->count() ?? 0 }}</div>
          <div class="text-xs text-earth-600 mt-1">Inscritos</div>
        </div>

        <div class="p-4 rounded-lg bg-earth-50 border border-earth-100 shadow-sm">
          <div class="text-sm text-earth-600">Juízes</div>
          <div class="text-2xl font-bold text-earth-800">{{ $juizes->count() ?? 0 }}</div>
          <div class="text-xs text-earth-600 mt-1">Convidados / Confirmados</div>
        </div>

        <div class="p-4 rounded-lg bg-earth-50 border border-earth-100 shadow-sm">
          <div class="text-sm text-earth-600">Patrocinadores</div>
          <div class="text-2xl font-bold text-earth-800">{{ $patrocinadores->count() ?? 0 }}</div>
          <div class="text-xs text-earth-600 mt-1">Apoiadores</div>
        </div>

        <div class="p-4 rounded-lg bg-earth-50 border border-earth-100 shadow-sm">
          <div class="text-sm text-earth-600">Valor arrecadado</div>
          <div class="text-2xl font-bold text-earth-800">R$ {{ number_format($patrocinadores->sum('valor_patrocinio') ?? 0, 2, ',', '.') }}</div>
          <div class="text-xs text-earth-600 mt-1">Soma de patrocínios</div>
        </div>
      </div>

      {{-- Championship controls (search, export) --}}
      <div class="flex items-center justify-between gap-3 mb-4">
        <div class="flex items-center gap-2 w-full max-w-lg">
          <input id="searchChamp" placeholder="Pesquisar por nome, tipo ou cidade" class="p-2 border rounded w-full" />
          <select id="filterChampType" class="p-2 border rounded">
            <option value="">Todos</option>
            <option value="competidor">Competidor</option>
            <option value="juiz">Juiz</option>
            <option value="patrocinador">Patrocinador</option>
          </select>
        </div>

        <div class="flex gap-2">
          <button id="exportChampCsv" class="px-3 py-2 bg-earth-600 text-white rounded">Exportar CSV</button>
          <button id="backToSessions" class="px-3 py-2 border rounded">Voltar</button>
        </div>
      </div>

      {{-- Unified table: Competidores | Juízes | Patrocinadores --}}
      <div class="overflow-x-auto bg-white rounded border border-earth-100">
        <table class="w-full min-w-[900px]">
          <thead class="bg-earth-700 text-earth-50 text-sm">
            <tr>
              <th class="p-3 text-left">Nome</th>
              <th class="p-3 text-left">Tipo</th>
              <th class="p-3 text-left">Contato</th>
              <th class="p-3 text-left">Categoria / Status</th>
              <th class="p-3 text-left">Cidade / Estado</th>
              <th class="p-3 text-left">Valor (R$)</th>
              <th class="p-3 text-center">Ações</th>
            </tr>
          </thead>
          <tbody id="champTableBody">
            {{-- Competidores --}}
            @foreach($competidores as $c)
              <tr class="even:bg-earth-50" data-type="competidor" data-label="{{ strtolower($c->nome.' '.$c->cidade.' '.$c->categoria) }}">
                <td class="p-3 font-semibold">{{ $c->nome }}</td>
                <td class="p-3">Competidor</td>
                <td class="p-3 text-sm">{{ $c->email }}<br/><span class="text-xs text-earth-600">{{ $c->telefone ?? '' }}</span></td>
                <td class="p-3">{{ $c->categoria }} / {{ $c->status_inscricao }}</td>
                <td class="p-3 text-sm">{{ $c->cidade ?? '—' }} @if($c->estado) / {{ $c->estado }} @endif</td>
                <td class="p-3 text-sm">—</td>
                <td class="p-3 text-center">
                  <a href="{{ route('competidores.edit', $c) }}" class="px-3 py-1 border rounded text-sm">Editar</a>
                </td>
              </tr>
            @endforeach

            {{-- Juízes --}}
            @foreach($juizes as $j)
              <tr class="even:bg-earth-50" data-type="juiz" data-label="{{ strtolower($j->nome.' '.$j->experiencia) }}">
                <td class="p-3 font-semibold">{{ $j->nome }}</td>
                <td class="p-3">Juiz</td>
                <td class="p-3 text-sm">{{ $j->email }}<br/><span class="text-xs text-earth-600">{{ $j->telefone ?? '' }}</span></td>
                <td class="p-3 text-sm">Experiência: {{ \Illuminate\Support\Str::limit($j->experiencia, 80) }}</td>
                <td class="p-3 text-sm">—</td>
                <td class="p-3 text-sm">—</td>
                <td class="p-3 text-center">
                  <a href="{{ route('juizes.edit', $j) }}" class="px-3 py-1 border rounded text-sm">Editar</a>
                </td>
              </tr>
            @endforeach

            {{-- Patrocinadores --}}
            @foreach($patrocinadores as $p)
              <tr class="even:bg-earth-50" data-type="patrocinador" data-label="{{ strtolower($p->nome.' '.$p->contato_nome) }}">
                <td class="p-3 font-semibold">{{ $p->nome }}</td>
                <td class="p-3">Patrocinador</td>
                <td class="p-3 text-sm">{{ $p->contato_email ?? '' }}<br/><span class="text-xs text-earth-600">{{ $p->contato_telefone ?? '' }}</span></td>
                <td class="p-3 text-sm">{{ $p->status }}</td>
                <td class="p-3 text-sm">—</td>
                <td class="p-3 text-sm">R$ {{ number_format($p->valor_patrocinio ?? 0,2,',','.') }}</td>
                <td class="p-3 text-center">
                  <a href="{{ route('patrocinadores.edit', $p) }}" class="px-3 py-1 border rounded text-sm">Editar</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div> {{-- end championshipSection --}}

    <footer class="mt-6 text-sm text-earth-700/80">Direitos reservados &copy; {{ date('Y') }} BrooklynSkateShop.</footer>
  </div>
</main>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Elementos das tabs
    const tabSessions = document.getElementById('tabSessions');
    const tabChampionships = document.getElementById('tabChampionships');
    const sessionsSection = document.getElementById('sessionsSection');
    const championshipSection = document.getElementById('championshipSection');
    const backToSessionsBtn = document.getElementById('backToSessions');
    
    // Função para alternar entre as seções
    function showSessions() {
      // Mostrar seção de sessões
      sessionsSection.classList.remove('hidden');
      championshipSection.classList.add('hidden');
      
      // Atualizar tabs
      if (tabSessions && tabChampionships) {
        tabSessions.classList.add('bg-earth-500', 'text-white');
        tabChampionships.classList.remove('bg-earth-500', 'text-white');
      }
    }
    
    function showChampionships() {
      // Mostrar seção de campeonatos
      championshipSection.classList.remove('hidden');
      sessionsSection.classList.add('hidden');
      
      // Atualizar tabs
      if (tabSessions && tabChampionships) {
        tabChampionships.classList.add('bg-earth-500', 'text-white');
        tabSessions.classList.remove('bg-earth-500', 'text-white');
      }
    }
    
    // Event listeners para as tabs
    if (tabSessions) {
      tabSessions.addEventListener('click', showSessions);
    }
    
    if (tabChampionships) {
      tabChampionships.addEventListener('click', showChampionships);
    }
    
    if (backToSessionsBtn) {
      backToSessionsBtn.addEventListener('click', showSessions);
    }
    
    // mobile sidebar
    document.getElementById('openSidebarMobile')?.addEventListener('click', () => { 
      document.getElementById('mobileSidebar').classList.remove('hidden'); 
    });
    
    document.getElementById('closeSidebarMobile')?.addEventListener('click', () => { 
      document.getElementById('mobileSidebar').classList.add('hidden'); 
    });
    
    document.getElementById('mobileSidebar')?.addEventListener('click', (e) => { 
      if (e.target.id === 'mobileSidebar') document.getElementById('mobileSidebar').classList.add('hidden'); 
    });

    // Filtro de tarefas (para sessões)
    const searchInput = document.getElementById('searchText');
    const responsavelSelect = document.getElementById('filterResponsavel');
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const clearFilterBtn = document.getElementById('clearFilterBtn');
    
    if (applyFilterBtn) {
      applyFilterBtn.addEventListener('click', applyFilters);
    }
    
    if (searchInput) {
      searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
          applyFilters();
        }
      });
    }
    
    if (clearFilterBtn) {
      clearFilterBtn.addEventListener('click', function() {
        searchInput.value = '';
        responsavelSelect.value = '';
        applyFilters();
      });
    }
    
    function applyFilters() {
      const searchTerm = searchInput.value.toLowerCase().trim();
      const responsavelId = responsavelSelect.value;
      
      // Filtrar linhas da tabela (desktop)
      const tableRows = document.querySelectorAll('#tasksTableBody .task-row');
      let visibleTableRows = 0;
      
      tableRows.forEach(row => {
        const titulo = row.getAttribute('data-titulo') || '';
        const descricao = row.getAttribute('data-descricao') || '';
        const responsavel = row.getAttribute('data-responsavel') || '';
        const responsavelNome = row.getAttribute('data-responsavel-nome') || '';
        
        let showRow = true;
        
        // Filtro por texto
        if (searchTerm) {
          const matchesSearch = titulo.includes(searchTerm) || 
                               descricao.includes(searchTerm) || 
                               responsavelNome.includes(searchTerm);
          if (!matchesSearch) {
            showRow = false;
          }
        }
        
        // Filtro por responsável
        if (responsavelId && responsavel !== responsavelId) {
          showRow = false;
        }
        
        // Mostrar ou esconder a linha
        if (showRow) {
          row.style.display = '';
          visibleTableRows++;
        } else {
          row.style.display = 'none';
        }
      });
      
      // Filtrar cards mobile
      const mobileCards = document.querySelectorAll('#mobileTasksContainer .task-card');
      let visibleMobileCards = 0;
      
      mobileCards.forEach(card => {
        const titulo = card.getAttribute('data-titulo') || '';
        const descricao = card.getAttribute('data-descricao') || '';
        const responsavel = card.getAttribute('data-responsavel') || '';
        const responsavelNome = card.getAttribute('data-responsavel-nome') || '';
        
        let showCard = true;
        
        // Filtro por texto
        if (searchTerm) {
          const matchesSearch = titulo.includes(searchTerm) || 
                               descricao.includes(searchTerm) || 
                               responsavelNome.includes(searchTerm);
          if (!matchesSearch) {
            showCard = false;
          }
        }
        
        // Filtro por responsável
        if (responsavelId && responsavel !== responsavelId) {
          showCard = false;
        }
        
        // Mostrar ou esconder o card
        if (showCard) {
          card.style.display = '';
          visibleMobileCards++;
        } else {
          card.style.display = 'none';
        }
      });
      
      // Atualizar estatísticas visíveis
      updateVisibleStats(visibleTableRows || visibleMobileCards);
    }
    
    function updateVisibleStats(visibleCount) {
      const statTotalElement = document.getElementById('statTotal');
      if (statTotalElement) {
        statTotalElement.textContent = visibleCount;
      }
    }
    
    // Aplicar filtros automaticamente quando a página carrega
    if (searchInput || responsavelSelect) {
      applyFilters();
    }
    
    // Filtro para campeonatos
    const searchChampInput = document.getElementById('searchChamp');
    const filterChampType = document.getElementById('filterChampType');
    
    if (searchChampInput) {
      searchChampInput.addEventListener('keyup', applyChampFilters);
    }
    
    if (filterChampType) {
      filterChampType.addEventListener('change', applyChampFilters);
    }
    
    function applyChampFilters() {
      const searchTerm = searchChampInput.value.toLowerCase().trim();
      const filterType = filterChampType.value;
      
      const rows = document.querySelectorAll('#champTableBody tr');
      
      rows.forEach(row => {
        const rowType = row.getAttribute('data-type');
        const rowLabel = row.getAttribute('data-label') || '';
        
        let showRow = true;
        
        // Filtro por tipo
        if (filterType && rowType !== filterType) {
          showRow = false;
        }
        
        // Filtro por texto
        if (searchTerm && !rowLabel.includes(searchTerm)) {
          showRow = false;
        }
        
        // Mostrar ou esconder a linha
        row.style.display = showRow ? '' : 'none';
      });
    }
    
    // Export CSV buttons
    const exportCsvBtn = document.getElementById('exportCsvBtn');
    const exportChampCsv = document.getElementById('exportChampCsv');
    
    if (exportCsvBtn) {
      exportCsvBtn.addEventListener('click', function() {
        alert('Exportando dados das sessões em CSV...');
        // Aqui você implementaria a lógica de exportação
      });
    }
    
    if (exportChampCsv) {
      exportChampCsv.addEventListener('click', function() {
        alert('Exportando dados dos campeonatos em CSV...');
        // Aqui você implementaria a lógica de exportação
      });
    }
  });
</script>
@endpush

@endsection