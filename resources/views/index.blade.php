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

      <!-- quick stats -->
      <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
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
      </section>

      <!-- Filters + cards -->
      <section class="flex flex-col lg:flex-row gap-4 mb-6">
        <div class="flex-1 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4" id="cardsContainerPlaceholder">
          <!-- cards gerados via JS -->
        </div>

        <aside class="w-full lg:w-80 bg-white/95 p-4 rounded border border-earth-100 shadow-sm">
          <div class="mb-3">
            <label class="text-sm font-medium text-earth-700">Pesquisar</label>
            <input id="searchText" placeholder="Pesquisar por tarefa ou responsável"
              class="mt-2 p-2 border rounded-md w-full" />
          </div>
          <div class="mb-3">
            <label class="text-sm font-medium text-earth-700">Filtrar por responsável</label>
            <select id="filterResponsavel" class="mt-2 p-2 border rounded-md w-full">
              <option value="">Todos</option>
              @foreach($responsaveis as $responsavel)
                <option value="{{ $responsavel->id }}">{{ $responsavel->nome }}</option>
              @endforeach
            </select>
          </div>
          <div class="flex gap-2 mt-3">
            <button id="applyFilterBtn" type="button"
              class="flex-1 p-2 bg-earth-500 text-white rounded-md">Aplicar</button>
            <button id="clearFilterBtn" type="button" class="flex-1 p-2 border rounded-md">Limpar</button>
          </div>
        </aside>
      </section>

      <!-- main workspace -->
      <section class="bg-white/95 p-4 rounded-lg shadow border border-earth-100">
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
          <h2 class="font-bold text-lg">Adicionar nova tarefa</h2>
          <div class="text-sm text-earth-600">Use o formulário para criar tarefas rápidas — ajuste depois se precisar.
          </div>
        </div>

        <form id="taskForm" class="grid grid-cols-1 md:grid-cols-6 gap-3">
          <select id="responsavel" class="p-2 border rounded-md md:col-span-1 w-full">
            @foreach($responsaveis as $responsavel)
              <option value="{{ $responsavel->id }}">{{ $responsavel->nome }}</option>
            @endforeach
          </select>

          
          <select id="area" class="p-2 border rounded-md md:col-span-1 w-full">
            @foreach($areas as $area)
              <option value="{{ $area->id }}">{{ $area->nome }}</option>
            @endforeach
          </select>

          <input id="tarefa" placeholder="Descrição da tarefa" class="p-2 border rounded-md md:col-span-2 w-full" />
          <input id="prazo" type="date" class="p-2 border rounded-md md:col-span-1 w-full" />
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
                <tr class="even:bg-earth-50">
                  <td class="p-3 font-semibold">{{ $tarefa->titulo }}</td>
                  <td class="p-3 text-sm text-earth-700">{{ \Illuminate\Support\Str::limit($tarefa->descricao, 120) }}</td>
                  <td class="p-3">{{ $tarefa->responsavel->nome ?? '—' }}</td>
                  <td class="p-3">{{ $tarefa->area->nome ?? '—' }}</td>
                  <td class="p-3 text-sm">{{ optional($tarefa->prazo)->format('d/m/Y') }}</td>
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
                        <option value="Em Andamento" {{ $tarefa->status == 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
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
        <div class="md:hidden mt-6 space-y-3">
          @foreach($tarefas as $tarefa)
            <article class="bg-earth-50 border border-earth-100 p-3 rounded-lg shadow-sm">
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="font-semibold text-earth-800">{{ $tarefa->titulo }}</h3>
                  <p class="text-sm text-earth-700 mt-1">{{ \Illuminate\Support\Str::limit($tarefa->descricao, 180) }}</p>
                </div>
                <div class="text-xs text-earth-600 text-right ml-2">
                  <div>{{ optional($tarefa->prazo)->format('d/m/Y') }}</div>
                  <div class="mt-2">
                    <span class="inline-block px-2 py-1 rounded text-xs {{ $tarefa->prioridade == 'Alta' ? 'bg-red-100 text-red-800' : ($tarefa->prioridade=='Média' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                      {{ $tarefa->prioridade }}
                    </span>
                  </div>
                </div>
              </div>

              <div class="mt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div class="text-sm text-earth-700">
                  <div>Responsável: <strong>{{ $tarefa->responsavel->nome ?? '—' }}</strong></div>
                  <div>Área: <strong>{{ $tarefa->area->nome ?? '—' }}</strong></div>
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

      <footer class="mt-6 text-sm text-earth-700/80">Dica: os dados são salvos no navegador (localStorage). Use "Limpar dados" para resetar.</footer>
    </div>
  </main>


  @push('scripts')
    <script>
      // mobile sidebar
      document.getElementById('openSidebarMobile')?.addEventListener('click', () => { document.getElementById('mobileSidebar').classList.remove('hidden'); });
      document.getElementById('closeSidebarMobile')?.addEventListener('click', () => { document.getElementById('mobileSidebar').classList.add('hidden'); });
      document.getElementById('mobileSidebar')?.addEventListener('click', (e) => { if (e.target.id === 'mobileSidebar') document.getElementById('mobileSidebar').classList.add('hidden'); });

      // tabs (visual only)
      const tabSessions = document.getElementById('tabSessions');
      const tabChampionships = document.getElementById('tabChampionships');
      tabSessions?.addEventListener('click', () => { tabSessions.classList.add('bg-earth-500', 'text-white'); tabChampionships.classList.remove('bg-earth-500', 'text-white'); });
      tabChampionships?.addEventListener('click', () => { tabChampionships.classList.add('bg-earth-500', 'text-white'); tabSessions.classList.remove('bg-earth-500', 'text-white'); });
    </script>
  @endpush

@endsection
