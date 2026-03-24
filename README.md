# 🏥 Hospital Central - Gestão de Pacientes (Laravel MVC + Blade)

Este é um sistema de **Gestão Hospitalar** robusto, desenvolvido seguindo a arquitetura clássica **MVC (Model-View-Controller)**. O projeto foca em segurança, organização de banco de dados e uma interface administrativa eficiente.

## 🚀 Tecnologias e Stack Técnica

- **Framework:** Laravel 11 (PHP 8.3).
- **Frontend:** Blade Templating Engine (Server-Side Rendering).
- **Autenticação:** Laravel Breeze (Sistema completo de Login, Registro e Redefinição de Senha).
- **Estilização:** Tailwind CSS (via Vite para performance otimizada).
- **Banco de Dados:** MySQL (Relacional).
- **Interatividade:** AJAX (Vanilla JS) para filtros em tempo real e SweetAlert2 para feedbacks visuais.

## 🔐 Funcionalidades de Nível Profissional

- **Autenticação Completa:** Sistema restrito onde apenas médicos/usuários autenticados podem gerenciar pacientes.
- **CRUD Completo:** Cadastro, listagem, edição e exclusão de registros com persistência de dados.
- **Filtros Inteligentes:** Busca dinâmica por nome, status e prazos de SLA utilizando **Query Scopes**.
- **Gestão de SLA (Prazos):** Cálculo automático de tempo de permanência baseado na gravidade do paciente (Estável, Observação, Crítico).
- **Interface Responsiva:** Painel administrativo adaptável para dispositivos móveis e desktops.
- **Segurança de Rotas:** Uso de Middlewares para proteção de dados sensíveis e prevenção de acessos não autorizados.

## 🛠️ Como rodar o projeto localmente

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/hospital.git
   cd hospital
   ```

2. **Configure o ambiente e instale as dependências PHP:**
   *(É necessário ter o PHP/Composer local ou usar um container temporário para isso)*
   ```bash
   cp .env.example .env
   composer install
   ```

3. **Inicialize os containers do Docker (via Laravel Sail):**
   ```bash
   ./vendor/bin/sail up -d
   ```

4. **Gere a chave da aplicação e prepare o Banco de Dados:**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate
   ```

5. **Instale e compile os assets do Frontend (Tailwind/Vite):**
   ```bash
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run build
   ```

6. **Acesse o sistema:**
   Abra o seu navegador em `http://localhost`.
