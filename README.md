# SGFP - Sistema de Gerenciamento de Folha de Produção

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=flat-square&logo=php)](https://php.net)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=flat-square&logo=javascript)](https://javascript.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-4.x-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)
[![IPEN](https://img.shields.io/badge/IPEN-Nuclear%20Institute-00A86B?style=flat-square)](https://ipen.br)

Sistema web para gerenciamento e controle de produção de radiofármacos desenvolvido para o **Instituto de Pesquisas Energéticas e Nucleares (IPEN)**.

---

## 📋 Sobre o Projeto

O **SGFP** é um sistema especializado no controle da produção de radiofármacos, permitindo o acompanhamento completo de folhas de produção, desde a preparação inicial até a distribuição final dos produtos radioativos.

### 🎯 Objetivos
- Controlar e documentar processos de produção de radiofármacos
- Garantir rastreabilidade completa dos lotes produzidos
- Facilitar o cumprimento de normas regulatórias
- Otimizar o fluxo de trabalho da produção
- Manter registros seguros e auditáveis

---

## 🔬 Funcionalidades Principais

### 📊 **Dashboard e Monitoramento**
- Gráfico de produção dos últimos 5 anos
- Indicadores de performance em tempo real
- Visão geral do status da produção

### 🧪 **Distribuição de Radiofármacos (R.P.)**
O sistema controla a produção de diversos radiofármacos:

#### **GAL-IPEN (Citrato de Gálio GA-67)**
- Controle de folha de produção específica
- Gerenciamento de diluições
- Cálculos de atividade e concentração
- Controle de calibração

#### **IOD-IPEN-131 (Iodeto de Sódio I-131)**
- Folha de produção para Iodo-131
- Controle de embalagem primária
- Liberação de área de trabalho
- Informações sobre radioisótopos

#### **CARD-IPEN (Cloreto de Tálio TL-201)**
- Produção de Tálio-201
- Controle específico de materiais
- Reconciação de materiais TALIO

#### **GERADOR IPEN-TEC**
- Controle de geradores de Tecnécio
- Monitoramento de produção

#### **CAPS-IPEN**
- Controle de cápsulas de Iodo-131

### 🔧 **Módulos de Controle**

#### **📝 Folha de Produção**
- **Amostras**: Controle de amostras coletadas
- **Cabeçalho da Folha**: Informações gerais da produção
- **Definição de Série**: Configuração de séries de produção
- **Definição de Série por Intervalo**: Controle por intervalos
- **Definição de Série por Lote**: Controle específico por lote
- **Diluições**: Controle de diluições (Geral, Gálio, Tálio)
- **Embalagem Primária**: Controle de embalagens
- **Equipamentos**: Gestão de equipamentos utilizados
- **Fracionamento Cliente**: Controle de fracionamento
- **Garantia da Qualidade (GQ)**: Controles de qualidade
- **Informações Radioativas**: Dados sobre radioisótopos
- **Liberação de Área de Trabalho**: Controle de liberação
- **Limpeza de Cela**: Registros de limpeza
- **Materiais**: Controle de materiais e reagentes
- **Observações**: Anotações gerais
- **Operadores**: Gestão de operadores
- **Pedido Interno**: Controle de pedidos internos
- **Reconciação de Materiais**: Reconciliação por produto
- **Rendimento do Processo**: Cálculo de rendimentos
- **Solicitações**: Controle de solicitações

#### **📅 Escala de Trabalho**
- **Tarefas**: Definição e controle de tarefas
- **Escala Semanal**: Planejamento semanal de trabalho
- **Responsáveis**: Atribuição de responsabilidades

#### **🔍 Consultas e Relatórios**
- **Blindagem X Pasta**: Verificação de blindagens
- **Acompanhamento de Lotes**: Rastreamento de lotes
- **Relatórios de Produção**: Diversos tipos de relatórios

#### **🔧 Outros Módulos**
- **Verificação de Cela**: Checklist de verificação
- **Upload de Arquivos**: Gestão de documentos
- **Navegação de Folha**: Navegação entre folhas

---

## 🏗️ Arquitetura do Sistema

### **Frontend**
- **HTML5/CSS3**: Interface responsiva
- **Bootstrap 4**: Framework CSS
- **JavaScript/jQuery**: Interatividade
- **DataTables**: Tabelas avançadas
- **Font Awesome**: Ícones
- **SweetAlert2**: Alertas elegantes
- **Toastr**: Notificações

### **Backend**
- **PHP 7.4+**: Linguagem principal
- **PDO**: Acesso a banco de dados
- **SQL Server**: Banco de dados principal
- **Stored Procedures**: Lógica de negócio

### **Arquivos Principais**
```
├── index.php              # Página principal
├── header.php             # Cabeçalho padrão
├── footer.php             # Rodapé padrão
├── functions.php          # Funções principais
├── functionsOutros.php    # Funções auxiliares
├── login.php              # Sistema de autenticação
├── seguranca.php          # Sistema de segurança
├── app/                   # Módulos principais
├── appOutros/             # Módulos auxiliares
├── lib/                   # Bibliotecas
├── css/                   # Estilos
├── js/                    # Scripts JavaScript
├── img/                   # Imagens
└── plugins/               # Plugins externos
```

---

## 🚀 Instalação e Configuração

### **Pré-requisitos**
- PHP 7.4 ou superior
- SQL Server 2016 ou superior
- IIS ou Apache
- Extensões PHP: PDO, pdo_sqlsrv

### **Configuração do Banco de Dados**
1. Configure a conexão em `lib/DB.php`
2. Execute as procedures listadas em `Docs/Procedures.txt`
3. Configure as tabelas necessárias

### **Configuração do Servidor Web**
```bash
# Para IIS (Windows)
# Configure o site no IIS Manager
# Aponte para o diretório do projeto

# Para Apache
# Configure um VirtualHost
# Habilite mod_rewrite se necessário
```

### **Variáveis de Ambiente**
Configure as seguintes variáveis no sistema:
- `$_SG['rf']`: Caminho raiz do sistema
- `$_SESSION['PATH_RELATORIO']`: Caminho dos relatórios

---

## 🔐 Sistema de Segurança

### **Autenticação**
- Login obrigatório para acesso
- Validação de senha
- Controle de sessão
- Proteção contra acesso direto

### **Autorização**
- Diferentes níveis de usuário
- Controle de acesso por funcionalidade
- Auditoria de ações

### **Funcionalidades de Segurança**
```php
// Proteção de páginas
protegePagina();

// Validação de senha
ValidaSenha($usuario, $senha);

// Controle de sessão
session_start();
include("seguranca.php");
```

---

## 📊 Produtos Suportados

| Código | Nome | Descrição |
|--------|------|-----------|
| GA-67 | CIT-Ga-67 | Citrato de Gálio GA-67 |
| I-131 | IODO-131 | Iodeto de Sódio I-131 |
| TLCL3 | CL-Tl-201 | Cloreto de Tálio TL-201 |
| IPEN-TEC | GERADOR-Tc | Gerador IPEN-TEC |
| CAPSULA | I-131-CAP | Iodo-131 Cápsula |
| P-32-S-1 | ACI-P-32 | Ácido Fosfórico-32 |
| SM-153 | EDTMPSm153 | EDTMP-Samário-153 |

---

## 🛠️ Desenvolvimento

### **Estrutura de Desenvolvimento**
```
Ambiente de Desenvolvimento: http://des-sgfp.ipen.br
Ambiente de Produção: [Configurar conforme necessário]
```

### **Padrões de Código**
- PSR-4 para autoloading
- Comentários em português
- Nomenclatura descritiva
- Separação de responsabilidades

### **Banco de Dados**
- Schema: `sgcr.crsa`
- Procedures prefixadas com `P` ou `usp`
- Tabelas prefixadas com `T`
- Versionamento de procedures

---

## 📈 Relatórios

### **Tipos de Relatório**
- **Relatório de Produção GÁLIO**: `RelatProducaoGALIO`
- **Relatório de Produção IODO**: `RelatProducaoIODO`
- **Relatório de Produção TÁLIO**: `RelatProducaoTALIO`
- **Folha de Produção**: `fm-cr-p03.11-01v7`

### **Exportação**
- PDF
- Excel
- CSV
- Impressão direta

---

## 🔄 Atualizações Recentes

### **Últimas Funcionalidades Adicionadas**
- ✅ Sistema de acompanhamento de lotes
- ✅ Controle de blindagem vs pasta
- ✅ Módulos de Gálio específicos
- ✅ Definição de séries por lote
- ✅ Melhorias na interface de usuário

### **Correções**
- ✅ Resolução de conflitos de merge
- ✅ Correção em cálculos de diluição
- ✅ Ajustes para ambiente de produção
- ✅ Persistência de limpeza da cela

---

## 👨‍💻 Equipe e Contribuição

### **Desenvolvido por**
- **Instituto de Pesquisas Energéticas e Nucleares (IPEN)**
- **Departamento de TI - Sistemas**

### **GitLab**
```bash
git clone https://gitlab.ipen.br/ti-sistemas/sgfp-fonte.git
```

### **Como Contribuir**
1. Fork o projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

---

## 📞 Suporte

### **Contato**
- **IPEN - Instituto de Pesquisas Energéticas e Nucleares**
- **Departamento**: TI - Sistemas
- **Ambiente de Desenvolvimento**: http://des-sgfp.ipen.br

### **Documentação Adicional**
- Documentação de Etiquetas: `/docs/ProjetoEtiquetas/index.html`
- Procedures: `Docs/Procedures.txt`

---

## 📄 Licença

Este projeto é propriedade do **Instituto de Pesquisas Energéticas e Nucleares (IPEN)** e está sujeito às políticas internas da instituição.

---

## 🏆 Reconhecimentos

Sistema desenvolvido para atender às necessidades específicas de produção de radiofármacos do IPEN, contribuindo para a segurança e qualidade na produção de produtos radioativos para uso médico e de pesquisa.

---

*Última atualização: Outubro 2025*