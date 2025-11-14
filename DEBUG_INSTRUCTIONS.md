# Debug PHP - SGFP Functions.php

## 🐛 Configuração de Debug para functions.php linha 497+

### 📋 Métodos de Debug Disponíveis

## 1. 🔧 Debug Simples (Já Configurado)

### Arquivo de Teste Criado: `debug_functions.php`
- ✅ Simula o código da linha 497+ do functions.php
- ✅ Mostra valores de variáveis passo a passo
- ✅ Exibe a query SQL gerada
- ✅ Não requer configuração adicional

### Como usar:
```bash
# Execute no navegador:
http://localhost/SGFP/debug_functions.php

# Ou via linha de comando:
php debug_functions.php
```

---

## 2. 🎯 Debug Avançado com Xdebug (Recomendado)

### Pré-requisitos:
1. **Instalar Xdebug** (se não estiver instalado)
2. **Configurar PHP.ini**
3. **Instalar extensão PHP Debug no VSCode**

### 🚀 Instalação do Xdebug:

#### Para Windows com XAMPP/WAMP:
1. Baixe o Xdebug em: https://xdebug.org/download
2. Coloque o arquivo `php_xdebug.dll` na pasta de extensões do PHP
3. Adicione no `php.ini`:

```ini
[XDebug]
zend_extension=php_xdebug.dll
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_port=9003
xdebug.client_host=127.0.0.1
xdebug.log_level=0
```

#### Para Windows com PHP standalone:
```bash
# Verificar versão do PHP
php -v

# Baixar Xdebug compatível
# Colocar na pasta ext/ do PHP
# Configurar php.ini conforme acima
```

### 📦 Extensão VSCode:
1. Instale: **PHP Debug** by Xdebug
2. Reinicie o VSCode

---

## 3. 🔍 Debug no VSCode (Configurações Prontas)

### Arquivos criados:
- ✅ `.vscode/launch.json` - Configurações de debug
- ✅ `.vscode/settings.json` - Configurações do VSCode

### Como debugar:

#### Método 1 - Debug Web Request:
1. Coloque breakpoints na linha 497+ do `functions.php`
2. Pressione `F5` ou vá em `Run > Start Debugging`
3. Escolha "Listen for Xdebug"
4. Acesse a página web que chama o functions.php
5. O debug irá parar nos breakpoints

#### Método 2 - Debug Script Direto:
1. Abra o arquivo `functions.php`
2. Coloque breakpoints na linha 497
3. Pressione `F5`
4. Escolha "Launch currently open script"

---

## 4. 🐛 Debug Manual com var_dump e error_log

### Adicionar no functions.php linha 497:

```php
// Debug: linha 497
error_log("DEBUG: Iniciando processamento linha 497");
error_log("DEBUG: p1=" . $p1);
error_log("DEBUG: p2=" . $p2);
var_dump($_POST); // Remove após debug

$p1 = $_POST["p1"];
$p2 = $_POST["p2"];
// ... resto do código

// Debug: antes da execução
error_log("DEBUG: Query SQL: " . $exec);

include("../lib/DB.php");
$stmt = $conn->prepare($exec);

// Debug: após preparar statement
if ($stmt) {
    error_log("DEBUG: Statement preparado com sucesso");
} else {
    error_log("DEBUG: Erro ao preparar statement");
}

$stmt->execute();
error_log("DEBUG: Statement executado");
```

### Ver logs:
- **Windows IIS**: `C:\inetpub\logs\LogFiles`
- **XAMPP**: `C:\xampp\apache\logs\error.log`
- **PHP**: Verificar `error_log` no php.ini

---

## 5. 🎯 Debug Específico da Linha 497

### Pontos de interesse para debug:

```php
// LINHA 497+ - Pontos de breakpoint recomendados:

$p1= $_POST["p1"];     // ← BREAKPOINT 1: Verificar dados POST
$p2= $_POST["p2"];
// ... outras variáveis

$p2 = str_replace(":","", $p2);  // ← BREAKPOINT 2: Transformação de dados

$exec = "";
$exec .= "exec crsa.P0551_FRASCOSCAB_IA ";  // ← BREAKPOINT 3: Montagem da query
// ... montagem completa da query

include("../lib/DB.php");        // ← BREAKPOINT 4: Conexão DB
$stmt = $conn->prepare($exec);   // ← BREAKPOINT 5: Preparação
$stmt->execute();                // ← BREAKPOINT 6: Execução
```

---

## 6. 📊 Ferramentas de Debug Complementares

### Browser:
- **F12** - Developer Tools
- **Network Tab** - Ver requisições POST
- **Console** - Ver erros JavaScript

### PHP:
```php
// Verificar se dados POST existem
if (!isset($_POST["p1"])) {
    die("DEBUG: Dados POST não encontrados");
}

// Verificar conexão com banco
if (!$conn) {
    die("DEBUG: Erro de conexão com banco");
}

// Verificar erros SQL
try {
    $stmt->execute();
} catch (PDOException $e) {
    echo "DEBUG: Erro SQL: " . $e->getMessage();
}
```

---

## 🚨 Dicas Importantes:

1. **Remover debugs** em produção
2. **Fazer backup** antes de modificar functions.php
3. **Testar em ambiente de desenvolvimento** primeiro
4. **Verificar logs de erro** do servidor web
5. **Usar git** para controle de versão das mudanças

---

## 📞 Solução de Problemas:

### Xdebug não funciona:
1. Verificar se está carregado: `php -m | findstr xdebug`
2. Verificar configuração: `php -i | findstr xdebug`
3. Reiniciar servidor web após mudanças
4. Verificar firewall/antivírus bloqueando porta 9003

### VSCode não para nos breakpoints:
1. Verificar se arquivo está mapeado corretamente
2. Conferir configuração de pathMappings
3. Verificar se Xdebug está sendo chamado pela web

---

*Debug configurado para SGFP - functions.php linha 497+*