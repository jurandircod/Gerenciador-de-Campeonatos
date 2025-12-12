<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de Responsáveis</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --earth-50: #f8f6f1;
            --earth-100: #e8e3d7;
            --earth-300: #c5b59b;
            --earth-500: #a58863;
            --earth-700: #5a4632;
            --earth-800: #3a2f25;
        }
    </style>
</head>

<body class="bg-[var(--earth-50)] min-h-screen p-6">

    <div class="max-w-5xl mx-auto bg-white/90 p-6 rounded-xl shadow-lg border border-[var(--earth-100)]">
        <h1 class="text-2xl font-semibold text-[var(--earth-800)] mb-6">Cadastro de Responsáveis</h1>

        <!-- Formulário -->
        <form id="formResponsavel" action="{{ route('responsaveis.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            @csrf
            <div>
                <label class="text-sm font-medium text-[var(--earth-700)]">Nome</label>
                <input type="text" name="nome" value="{{ old('nome') }}" id="nome" class="w-full p-2 border rounded" required />
                @error('nome')
                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-[var(--earth-700)]">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" id="email" class="w-full p-2 border rounded" required />
                @error('email')
                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-[var(--earth-700)]">Telefone</label>
                <input type="text" name="telefone" value="{{ old('telefone') }}" id="telefone" class="w-full p-2 border rounded" />
                @error('telefone')
                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-[var(--earth-700)]">Área de responsabilidade</label>
                <input type="text" name="area_responsabilidade" value="{{ old('area_responsabilidade') }}" id="area_responsabilidade" class="w-full p-2 border rounded" required />
                @error('area_responsabilidade')
                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                <button type="button" id="limpar" class="px-4 py-2 border rounded">Limpar</button>
                <button type="submit" class="px-4 py-2 bg-[var(--earth-500)] text-white rounded">Salvar</button>
            </div>
        </form>

        <!-- Listagem -->
        <h2 class="text-xl font-semibold text-[var(--earth-800)] mb-3">Responsáveis cadastrados</h2>

        <!-- Pesquisa -->
        <div class="mb-4 flex gap-3">
            <input id="pesquisaTexto" placeholder="Pesquisar por nome, email ou área" class="flex-1 p-2 border rounded" />
            <button id="limparPesquisa" class="px-3 py-2 border rounded">Limpar</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border rounded">
                <thead class="bg-[var(--earth-300)] text-white">
                    <tr>
                        <th class="p-2 text-left">Nome</th>
                        <th class="p-2 text-left">Email</th>
                        <th class="p-2 text-left">Telefone</th>
                        <th class="p-2 text-left">Área</th>
                        <th class="p-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="tbodyResp" class="divide-y">
                    <!-- Aqui será carregado via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Configuração do Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": 5000,
            "extendedTimeOut": 1000
        };

        // Exibir mensagens da sessão
        @if(session('success'))
            toastr.success("{{ session('success') }}", 'Sucesso!');
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", 'Erro!');
        @endif

        @if(session('warning'))
            toastr.warning("{{ session('warning') }}", 'Atenção!');
        @endif

        @if(session('info'))
            toastr.info("{{ session('info') }}", 'Informação');
        @endif

        // Exibir erros de validação
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}", 'Erro de Validação');
            @endforeach
        @endif
    </script>

    <!-- JavaScript para gerenciar a tabela -->
    <script>
        let responsaveis = [];
        let visiveis = [];

        const tbody = document.getElementById("tbodyResp");

        // Função para carregar responsáveis do servidor
        async function carregarResponsaveis() {
            try {
                const response = await fetch('/api/responsaveis'); // Você precisará criar esta rota API
                if (response.ok) {
                    responsaveis = await response.json();
                    visiveis = [...responsaveis];
                    renderTabela();
                }
            } catch (error) {
                console.error('Erro ao carregar responsáveis:', error);
            }
        }

        function renderTabela() {
            tbody.innerHTML = "";
            visiveis.forEach((r, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td class="p-2">${r.nome}</td>
                        <td class="p-2">${r.email}</td>
                        <td class="p-2">${r.telefone || ''}</td>
                        <td class="p-2">${r.area_responsabilidade || ''}</td>
                        <td class="p-2 text-center">
                            <button onclick="remover(${r.id})" class="text-red-600 hover:text-red-800">Excluir</button>
                        </td>
                    </tr>`;
            });
        }

        function aplicarPesquisa() {
            const q = document.getElementById("pesquisaTexto").value.toLowerCase();
            visiveis = responsaveis.filter(r =>
                (r.nome && r.nome.toLowerCase().includes(q)) ||
                (r.email && r.email.toLowerCase().includes(q)) ||
                (r.area_responsabilidade && r.area_responsabilidade.toLowerCase().includes(q))
            );
            renderTabela();
        }

        async function remover(id) {
            if (confirm('Tem certeza que deseja excluir este responsável?')) {
                try {
                    const response = await fetch(`/responsaveis/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (response.ok) {
                        // Atualizar a lista após exclusão
                        carregarResponsaveis();
                        toastr.success('Responsável excluído com sucesso!');
                    } else {
                        toastr.error('Erro ao excluir responsável');
                    }
                } catch (error) {
                    toastr.error('Erro na requisição: ' + error.message);
                }
            }
        }

        // Event Listeners
        document.getElementById('pesquisaTexto').addEventListener('input', aplicarPesquisa);

        document.getElementById('limparPesquisa').addEventListener('click', () => {
            document.getElementById('pesquisaTexto').value = '';
            visiveis = [...responsaveis];
            renderTabela();
        });

        document.getElementById('limpar').addEventListener('click', () => {
            document.getElementById('formResponsavel').reset();
        });

        // Carregar responsáveis quando a página carregar
        document.addEventListener('DOMContentLoaded', carregarResponsaveis);
    </script>

    <!-- Bootstrap JS (opcional, se não for usar os componentes do Bootstrap) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

</body>
</html>