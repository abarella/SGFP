# 🐛 GUIA COMPLETO DE DEBUG - functions.php linha 497+

## ✅ Configuração Completa de Debug Realizada

### 📁 Arquivos Criados para Debug:

1. **`.vscode/launch.json`** - Configurações de debug do VSCode
2. **`.vscode/settings.json`** - Configurações do projeto
3. **`debug_functions.php`** - Debug simples e rápido
4. **`debug_functions_advanced.php`** - Debug detalhado linha a linha
5. **`debug_code_to_insert.php`** - Código para inserir no functions.php original
6. **`DEBUG_INSTRUCTIONS.md`** - Instruções completas de debug

---

## 🎯 COMO DEBUGAR LINHA A LINHA - MÉTODOS DISPONÍVEIS

### 1. 🔥 DEBUG IMEDIATO (Mais Rápido)

```bash
# Execute no terminal:
php debug_functions_advanced.php

# Ou acesse no navegador:
http://localhost/SGFP/debug_functions_advanced.php
```

**Resultado**: Mostra exatamente o que acontece em cada linha do código da linha 497+

---

### 2. 🎯 DEBUG NO VSCODE COM BREAKPOINTS

#### Passo 1: Colocar Breakpoints
1. Abra `functions.php` no VSCode
2. Clique na margem esquerda na linha 497 (aparece um ponto vermelho)
3. Coloque breakpoints nas linhas que quiser analisar:
   - Linha 497: `$p1= $_POST["p1"];`
   - Linha 495: `$p2 = str_replace(":","", $p2);`
   - Linha 517: `include("../lib/DB.php");`
   - Linha 519: `$stmt = $conn->prepare($exec);`
   - Linha 520: `$stmt->execute();`

#### Passo 2: Iniciar Debug
1. Pressione `F5` ou vá em `Run > Start Debugging`
2. Escolha "Listen for Xdebug"
3. Acesse a página que chama o functions.php
4. O código irá parar nos breakpoints

#### Passo 3: Navegar no Debug
- **F10**: Próxima linha (Step Over)
- **F11**: Entrar na função (Step Into)
- **Shift+F11**: Sair da função (Step Out)
- **F5**: Continuar execução

---

### 3. 🛠️ DEBUG DIRETO NO functions.php

#### Inserir código de debug no functions.php original:

```php
// Adicionar na linha 497 do functions.php:
$DEBUG_MODE = true; // ← Definir como false em produção

if ($DEBUG_MODE) {
    error_log("DEBUG [" . date('Y-m-d H:i:s') . "] Linha 497: p1=$p1, p2=$p2");
}
```

#### Ver logs de debug:
```bash
# Windows - verificar logs do PHP
tail -f C:\Windows\Temp\php-errors.log

# Ou verificar logs do IIS/Apache
```

---

## 🔍 PONTOS CRÍTICOS PARA DEBUG

### 📊 Dados de Entrada (Linha 490-494):
```php
$p1= $_POST["p1"];     // ← ID da análise
$p2= $_POST["p2"];     // ← Hora (formato HH:MM:SS)
$p3= $_POST["p3"];     // ← pH
$p4= $_POST["p4"];     // ← Observações
$p5= $_POST["p5"];     // ← Número PST
$p6= $_POST["p6"];     // ← Usuário
$p7= $_POST["p7"];     // ← Senha
$p8= $_POST["p8"];     // ← Aspecto ID
```

### ⚡ Transformação de Dados (Linha 495):
```php
$p2 = str_replace(":","", $p2);  // ← Remove ":" da hora
// 14:30:00 vira 143000
```

### 📝 Montagem da Query (Linha 498-511):
```php
$exec = "exec crsa.P0551_FRASCOSCAB_IA ...";  // ← Query SQL completa
```

### 💾 Execução no Banco (Linha 517-520):
```php
include("../lib/DB.php");          // ← Conexão
$stmt = $conn->prepare($exec);     // ← Preparação
$stmt->execute();                  // ← Execução
```

---

## 🚨 PROBLEMAS COMUNS E SOLUÇÕES

### ❌ Erro: "Undefined index"
**Causa**: Dados POST não estão chegando
**Debug**: `var_dump($_POST);` antes da linha 497

### ❌ Erro: "SQL Server connection"
**Causa**: Problemas de conexão com banco
**Debug**: Verificar `lib/DB.php` e credenciais

### ❌ Erro: "Syntax error in SQL"
**Causa**: Query malformada
**Debug**: `echo $exec;` antes de executar

### ❌ Breakpoints não funcionam
**Causa**: Xdebug não configurado
**Solução**: Usar debug manual com `error_log()`

---

## 📱 TESTE RÁPIDO - CENÁRIOS

### Cenário 1: Dados Válidos
```php
$_POST = [
    'p1' => '1',
    'p2' => '14:30:00',
    'p3' => '7.2',
    'p4' => 'Teste OK',
    'p5' => '12345',
    'p6' => '1',
    'p7' => 'senha123',
    'p8' => '2'
];
```

### Cenário 2: Hora Inválida
```php
$_POST['p2'] = 'invalid_time';  // ← Teste erro
```

### Cenário 3: Dados Faltando
```php
unset($_POST['p1']);  // ← Teste campo obrigatório
```

---

## 🎯 PRÓXIMOS PASSOS

1. **Execute o debug avançado**: `php debug_functions_advanced.php`
2. **Coloque breakpoints** no VSCode (linha 497, 495, 517, 519, 520)
3. **Teste cenários específicos** modificando os dados
4. **Verifique logs** para debug contínuo
5. **Remova debugs** antes de colocar em produção

---

## 📞 Status Atual:

- ✅ Configurações de debug criadas
- ✅ Arquivos de teste funcionando
- ✅ Breakpoints configurados
- ✅ Debug avançado disponível
- ✅ Documentação completa

**Você está pronto para debugar linha a linha o código da linha 497+ do functions.php!**

---

*Debug configurado com sucesso! 🎉*