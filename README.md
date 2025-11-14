# SGFP-Fonte

Sistema corporativo utilizado pelo IPEN para planejar, registrar e rastrear todas as etapas da folha de produção de radiofármacos. Centraliza os dados de produção dos radioisótopos (ex.: Iodo-131, Gálio-67, Tálio-201), integra-se ao banco SGCR e gera relatórios operacionais e regulatórios.

## Visão geral das funcionalidades
- **Dashboard operacional** – gráfico de produção dos últimos anos alimentado pela procedure `crsa.uspDashboardSGFP`, exibido na página inicial através do componente Chart.js (`content_ipen.php` + `footer.php`).
- **Distribuição R.P.** – listagem interativa de lotes por produto (`app/lista.php`) com filtros de ano/lote, ações para editar a folha, emitir a folha oficial (SSRS) e gerar relatórios de produção.
- **Fluxo completo da folha** – o menu contextual (`app/navFolha.php`) conduz cada etapa: limpeza de cela, liberação de área, conferência de equipamentos/materiais, dados do radioisótopo, pedido interno, amostras, procedimentos/diluições, reconciliação, rendimento, operadores, observações, fracionamento, solicitações e registros de CQ/GQ.
- **Procedimentos específicos por radioisótopo** – conjuntos de telas diferenciados para Iodo, Tálio e Gálio, incluindo esterilização/autoclavagem, controle de procedimentos especiais e reconciliações exclusivas.
- **Gestão de pedidos extras** – modal dentro da listagem de lotes que permite inserir pedidos fora da programação, validando dados de atividade, calibração e volumes.
- **Controle de qualidade e garantia** – captura de resultados e responsáveis das áreas de CQ e GQ, com histórico por lote e integração a relatórios SSRS.
- **Escalas e responsáveis** – cadastros de tarefas (`app/escala_tarefas.php`) e agenda semanal (`app/escala_semanal.php`), vinculando lotes, produtos, intervalos e responsáveis (procedures `uspPEscalaUsuarios`, `uspPEscalaSemanal_Duplica`).
- **Consultas industriais** – ferramentas auxiliares (`appOutros/`) como Verificação de Cela e Blindagem x Pasta.
- **Documentação de etiquetas** – acesso rápido ao projeto de etiquetas em `Docs/ProjetoEtiquetas`.
- **Administração de usuários** – módulo completo (`appUsuarios/`) para sistemas, programas, grupos, áreas, direitos por usuário e redefinição de senha, com validação de senha via stored procedures (`functionsUsuario.php`).

## Arquitetura e tecnologias
- **Backend**: PHP 7+ sobre IIS/Apache em Windows, sessões protegidas por `seguranca.php`.
- **Banco de dados**: Microsoft SQL Server (`lib/DB.php`), procedimentos armazenados listados em `Docs/Procedures.txt`.
- **Camada de apresentação**: AdminLTE 3, Bootstrap 4, Font Awesome, Bootstrap Select, OverlayScrollbars, SweetAlert2, Toastr.
- **Visualização e dados**: DataTables (com exportação Copy/Excel/PDF/ColVis), Chart.js e relatórios SSRS consumidos via `$_SESSION['PATH_RELATORIO']`.

## Estrutura de diretórios
- `app/` – telas principais da folha (LimpezaCela, Equipamentos, Materiais, Diluicoes*, ReconMateriais*, RendProcesso, etc.).
- `appUsuarios/` – CRUDs de sistemas, programas, grupos, direitos e usuários.
- `appOutros/` – consultas complementares e utilitários.
- `dist/`, `plugins/`, `css/`, `js/`, `build/` – assets do tema AdminLTE e bibliotecas front-end.
- `Docs/` – formulários, procedimentos e artefatos regulatórios (inclui `Procedures.txt` com a lista de stored procedures utilizadas).
- `lib/DB.php` – conexão PDO com SQL Server (ajuste para o servidor/local desejado antes de subir o sistema).

## Fluxo típico da folha
1. **Selecionar produto/lote** em `Distribuição R.P.` para abrir a lista de partidas planejadas.
2. **Editar a folha** e percorrer as abas da produção (Limpeza, Liberação, Equipamentos, Materiais, Diluicoes, Reconciliação, Rendimento, Operadores etc., conforme `app/navFolha.php`).
3. **Registrar controles** de CQ, GQ, observações e fracionamento do cliente.
4. **Emitir relatórios** oficiais e folha assinada via SSRS.
5. **Atualizar escalas** e responsáveis quando necessário.

## Configuração e execução
1. **Pré-requisitos**: PHP 7.4+, extensões `pdo_sqlsrv`, IIS/Apache configurado, acesso ao SQL Server com o banco `sgcr`.
2. **Configurar conexão**: ajustar `serverName`, `databaseName`, `uid` e `pwd` em `lib/DB.php`.
3. **Configurar paths**: variáveis globais em `seguranca.php`/`functions.php` devem apontar para `$_SG['rf']` (raiz pública) e `$_SESSION['PATH_RELATORIO']` (endpoint do SSRS).
4. **Publicar assets**: garantir que `dist/`, `plugins/`, `css/`, `js/` estejam acessíveis; caso necessário recompilar estilos no diretório `build/`.
5. **Permissões**: habilitar escrita para diretórios que recebem uploads (`uploads/`) e leitura para `Docs/`.
6. **Acesso**: abrir `index.php`; o login é validado via `functionsUsuario.php` com as procedures `uspP1110_USUARIOS*`.

## Desenvolvimento
- **Dependências front-end** já versionadas (AdminLTE, DataTables, Chart.js); use `build/` e `dist/` como referência para customizações.
- **Padronização**: arquivos PHP seguem estrutura header → conteúdo → footer; inclua `seguranca.php` para restringir acesso.
- **Banco**: preferir chamadas a stored procedures (consultar `Docs/Procedures.txt` antes de criar novas queries).
- **UI**: todos os grids usam DataTables com exportações habilitadas (`header.php`/`footer.php`); reutilize o mesmo padrão de inicialização para novas tabelas.
- **Relatórios**: novas integrações SSRS podem seguir o padrão de `app/lista.php` (ações `I1`/`I2` abrindo URLs parametrizadas).

## Próximas melhorias sugeridas
- Centralizar variáveis sensíveis (credenciais, PATH_RELATORIO) via dotenv ou secrets store.
- Criar testes automatizados para validações críticas (ex.: pedidos extras, reconciliações).
- Documentar APIs/Procedures expostas pelo banco para facilitar manutenção.