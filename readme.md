# 🛹 Organização de Evento de Skate

Sistema web para **gestão completa de eventos e campeonatos de skate**, permitindo organizar tarefas, competidores, juízes, patrocinadores e acompanhar dados financeiros do evento em um dashboard moderno e responsivo.

---

## 📌 Sobre o projeto

Este projeto foi desenvolvido para facilitar a **organização de campeonatos de skate**, centralizando todas as informações importantes em um único painel administrativo.

Com ele é possível:
- Organizar **sessões** e **campeonatos**
- Gerenciar **tarefas operacionais** do evento
- Cadastrar e identificar **competidores**
- Controlar **juízes** e **patrocinadores**
- Visualizar **valores arrecadados**
- Filtrar e acompanhar dados em tempo real
- Utilizar um dashboard limpo, responsivo e intuitivo

O sistema foi construído utilizando **Laravel**, com foco em clareza visual, produtividade e fácil manutenção.

---

## 🚀 Funcionalidades principais

### 📋 Gestão de tarefas
- Criar, editar e excluir tarefas
- Definir responsável, área, prazo, prioridade e status
- Filtros por responsável e texto
- Visualização em tabela (desktop) e cards (mobile)

### 🏆 Dashboard de Campeonatos
- Lista de **competidores**
- Lista de **juízes**
- Lista de **patrocinadores**
- Visualização de **valores arrecadados**
- Identificação rápida de dados importantes
- Interface separada acessada via botão **"Campeonatos"**

### 📊 Dashboard geral
- Total de tarefas
- Tarefas concluídas
- Prazos próximos
- Interface clara e objetiva

### 📱 Responsividade
- Layout adaptado para desktop, tablet e celular
- Cards no mobile e tabelas no desktop

### 📁 Exportação
- Exportação de dados em **CSV**

---

## 🧱 Tecnologias utilizadas

- **PHP 8.2.x**
- **Laravel 11**
- **Blade Templates**
- **Tailwind CSS**
- **JavaScript (Vanilla)**
- **MySQL**
- **Composer**
- **HTML5 / CSS3**

---

## ⚙️ Requisitos do sistema

Antes de instalar, você precisa ter:

- PHP >= 8.2
- Composer
- MySQL
- Node.js e npm (opcional, caso compile assets)
- Extensões PHP:
  - pdo
  - pdo_mysql
  - mbstring
  - openssl
  - tokenizer
  - xml
  - gd (opcional, para exportações)

---

## 🛠️ Instalação do projeto

### 1️⃣ Clone o repositório
```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio


## Telas

### Dashboard principal
![Dashboard](./screenshots/dashboard.png)

### Gestão de Tarefas
![Tarefas](./screenshots/tarefas.png)

### Dashboard de Campeonatos
![Campeonatos](./screenshots/campeonatos.png)

### Competidores
![Competidores](./screenshots/competidores.png)

### Patrocinadores
![Patrocinadores](./screenshots/patrocinadores.png)
