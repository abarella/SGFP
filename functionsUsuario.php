<?php

/**
 * Funções auxiliares para operações relacionadas aos módulos de usuários.
 *
 * Cada função centraliza a execução das stored procedures utilizadas nas
 * antigas telas em ASP, expondo resultados como arrays associativos para que
 * as novas telas PHP possam consumir e renderizar com facilidade.
 */

declare(strict_types=1);

use SimpleXMLElement;

if (!defined('FUNCTIONS_USUARIO_LOADED')) {
    define('FUNCTIONS_USUARIO_LOADED', true);
}

require_once __DIR__ . '/lib/DB.php';

/**
 * @param array<int, array<string, mixed>> $linhas
 * @return array<int, array<string, mixed>>
 */
function normalizarResultadoProcedures(array $linhas): array
{
    if (empty($linhas)) {
        return [];
    }

    $primeiraLinha = $linhas[0];
    if (!is_array($primeiraLinha) || count($primeiraLinha) !== 1) {
        return $linhas;
    }

    $valor = reset($primeiraLinha);
    if (!is_string($valor)) {
        return $linhas;
    }

    $valor = trim($valor);
    if ($valor === '' || $valor[0] !== '<') {
        return $linhas;
    }

    $convertido = converterXmlRawParaArray($valor);
    return $convertido !== [] ? $convertido : $linhas;
}

/**
 * @return array<int, array<string, string>>
 */
function converterXmlRawParaArray(string $xmlRaw): array
{
    $conteudo = trim($xmlRaw);
    if ($conteudo === '') {
        return [];
    }

    if (!function_exists('simplexml_load_string')) {
        return [];
    }

    // Garante que haja um elemento raiz único para que o SimpleXML consiga fazer o parse.
    if (stripos($conteudo, '<root') === false) {
        $conteudo = '<root>' . $conteudo . '</root>';
    }

    $anterior = function_exists('libxml_use_internal_errors') ? libxml_use_internal_errors(true) : null;
    $xml = simplexml_load_string($conteudo);
    if ($xml === false) {
        if (function_exists('libxml_clear_errors')) {
            libxml_clear_errors();
        }
        if (function_exists('libxml_use_internal_errors')) {
            libxml_use_internal_errors($anterior);
        }
        return [];
    }
    if (function_exists('libxml_clear_errors')) {
        libxml_clear_errors();
    }
    if (function_exists('libxml_use_internal_errors')) {
        libxml_use_internal_errors($anterior);
    }

    $resultado = [];

    /** @var SimpleXMLElement $nodo */
    foreach ($xml->children() as $nodo) {
        $linha = [];

        foreach ($nodo->attributes() as $atributo => $valor) {
            $linha[(string) $atributo] = (string) $valor;
        }

        foreach ($nodo->children() as $filhoNome => $filhoValor) {
            $linha[(string) $filhoNome] = (string) $filhoValor;
        }

        if (!empty($linha)) {
            $resultado[] = $linha;
        }
    }

    if (empty($resultado) && $xml instanceof SimpleXMLElement) {
        $linha = [];
        foreach ($xml->attributes() as $atributo => $valor) {
            $linha[(string) $atributo] = (string) $valor;
        }

        foreach ($xml->children() as $filhoNome => $filhoValor) {
            $linha[(string) $filhoNome] = (string) $filhoValor;
        }

        if (!empty($linha)) {
            $resultado[] = $linha;
        }
    }

    return $resultado;
}

/**
 * Executa uma stored procedure retornando um array associativo.
 *
 * @param string $tsql TSQL com a chamada completa da procedure.
 * @param array<string, mixed> $params Parâmetros nomeados para o PDO.
 * @return array<int, array<string, mixed>>
 */
function executarProcedureLista(string $tsql, array $params = []): array
{
    global $conn;

    $stmt = $conn->prepare($tsql);
    foreach ($params as $param => $value) {
        if ($value === null) {
            $stmt->bindValue($param, $value, PDO::PARAM_NULL);
        } elseif (is_int($value)) {
            $stmt->bindValue($param, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($param, $value, PDO::PARAM_STR);
        }
    }

    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    return normalizarResultadoProcedures($dados);
}

/**
 * Executa uma stored procedure que não precisa retornar dados tabulados.
 *
 * @param string $tsql
 * @param array<string, mixed> $params
 * @return void
 */
function executarProcedureSemResultado(string $tsql, array $params = []): void
{
    global $conn;

    $stmt = $conn->prepare($tsql);
    foreach ($params as $param => $value) {
        if ($value === null) {
            $stmt->bindValue($param, $value, PDO::PARAM_NULL);
        } elseif (is_int($value)) {
            $stmt->bindValue($param, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($param, $value, PDO::PARAM_STR);
        }
    }

    $stmt->execute();
}

/**
 * Retorna todos os sistemas ativos.
 *
 * @param string $status
 * @param int $ordem
 * @return array<int, array<string, mixed>>
 */
function listarSistemas(string $status = 'A', int $ordem = 1): array
{
    global $conn;

    $tsql = 'exec crsa.P1104_SISTEMA @p1104_Status = :status, @ordem = :ordem';

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':ordem', $ordem, PDO::PARAM_INT);
    $stmt->execute();

    // A procedure retorna XML, então precisamos concatenar todas as linhas
    $xmlResult = '';
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        // Tenta todas as colunas numéricas
        foreach ($row as $coluna) {
            if (!empty(trim((string) $coluna))) {
                $xmlResult .= $coluna;
            }
        }
    }
    
    // Se não encontrou nada com FETCH_NUM, tenta FETCH_ASSOC
    if (empty(trim($xmlResult))) {
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach ($row as $coluna) {
                if (!empty(trim((string) $coluna))) {
                    $xmlResult .= $coluna;
                }
            }
        }
    }

    // Se não retornou nada, retorna array vazio
    if (empty(trim($xmlResult))) {
        return [];
    }

    // Processa o XML usando a função existente
    $resultado = converterXmlRawParaArray($xmlResult);
    
    // Se o resultado estiver vazio, pode ser que o XML tenha uma estrutura diferente
    // Tenta processar diretamente sem wrapper root se já tiver root
    if (empty($resultado) && stripos($xmlResult, '<row') !== false) {
        // Tenta processar como XML direto se já tiver estrutura de rows
        $anterior = function_exists('libxml_use_internal_errors') ? libxml_use_internal_errors(true) : null;
        $xml = simplexml_load_string($xmlResult);
        if ($xml !== false) {
            $resultado = [];
            foreach ($xml->children() as $nodo) {
                $linha = [];
                foreach ($nodo->attributes() as $atributo => $valor) {
                    $linha[(string) $atributo] = (string) $valor;
                }
                if (!empty($linha)) {
                    $resultado[] = $linha;
                }
            }
        }
        if (function_exists('libxml_clear_errors')) {
            libxml_clear_errors();
        }
        if (function_exists('libxml_use_internal_errors')) {
            libxml_use_internal_errors($anterior);
        }
    }
    
    return $resultado;
}

/**
 * Retorna os programas vinculados a um sistema.
 *
 * @param int|null $sistemaId
 * @param string $status
 * @return array<int, array<string, mixed>>
 */
function listarProgramas(?int $sistemaId, string $status = 'A', int $ordem = 0): array
{
    global $conn;

    // Usa o mesmo nome da procedure do arquivo original (minúsculo)
    $tsql = 'set nocount on;exec crsa.P1103_programas @p1104_sistemaid = :sistemaId, @P1103_status = :status, @ordem = :ordem';

    try {
        $stmt = $conn->prepare($tsql);
        $stmt->bindValue(':sistemaId', $sistemaId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':ordem', $ordem, PDO::PARAM_INT);
        $stmt->execute();

        // A procedure retorna XML, então precisamos concatenar todas as linhas
        $xmlResult = '';
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            // Tenta todas as colunas numéricas
            foreach ($row as $coluna) {
                if (!empty(trim((string) $coluna))) {
                    $xmlResult .= $coluna;
                }
            }
        }
        
        // Se não encontrou nada com FETCH_NUM, tenta FETCH_ASSOC
        if (empty(trim($xmlResult))) {
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $coluna) {
                    if (!empty(trim((string) $coluna))) {
                        $xmlResult .= $coluna;
                    }
                }
            }
        }

        // Se não retornou nada, retorna array vazio
        if (empty(trim($xmlResult))) {
            return [];
        }

        // Processa o XML usando a função existente
        $resultado = converterXmlRawParaArray($xmlResult);
        
        // Se o resultado estiver vazio, pode ser que o XML tenha uma estrutura diferente
        if (empty($resultado) && stripos($xmlResult, '<row') !== false) {
            // Tenta processar como XML direto se já tiver estrutura de rows
            $anterior = function_exists('libxml_use_internal_errors') ? libxml_use_internal_errors(true) : null;
            $xml = simplexml_load_string($xmlResult);
            if ($xml !== false) {
                $resultado = [];
                foreach ($xml->children() as $nodo) {
                    $linha = [];
                    foreach ($nodo->attributes() as $atributo => $valor) {
                        $linha[(string) $atributo] = (string) $valor;
                    }
                    if (!empty($linha)) {
                        $resultado[] = $linha;
                    }
                }
            }
            if (function_exists('libxml_clear_errors')) {
                libxml_clear_errors();
            }
            if (function_exists('libxml_use_internal_errors')) {
                libxml_use_internal_errors($anterior);
            }
        }
        
        return $resultado;
    } catch (PDOException $e) {
        // Log do erro para debug
        error_log('Erro ao listar programas: ' . $e->getMessage());
        throw $e;
    }
}

/**
 * Retorna todos os grupos.
 *
 * @param string $status
 * @param int $ordem
 * @return array<int, array<string, mixed>>
 */
function listarGrupos(string $status = 'A', int $ordem = 1): array
{
    global $conn;

    $tsql = 'exec crsa.P0052_GRUPO @p052_status = :status, @ordem = :ordem';

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':ordem', $ordem, PDO::PARAM_INT);
    $stmt->execute();

    // A procedure retorna XML, então precisamos concatenar todas as linhas
    $xmlResult = '';
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        if (isset($row[0])) {
            $xmlResult .= $row[0];
        }
    }

    // Se não retornou nada, retorna array vazio
    if (empty(trim($xmlResult))) {
        return [];
    }

    // Processa o XML usando a função existente
    return converterXmlRawParaArray($xmlResult);
}

/**
 * Inclui um novo grupo.
 *
 * @param string $nome
 * @param int $areaId
 * @param int $menuId
 * @param int $usuarioExecutorId
 * @param string $senhaExecutor
 * @return array<int, array<string, mixed>>
 */
function inserirGrupo(
    string $nome,
    int $areaId,
    int $menuId,
    int $usuarioExecutorId,
    string $senhaExecutor
): array {
    global $conn;

    $tsql = "DECLARE @resulta INT, @mensa VARCHAR(100);
             EXEC crsa.P0052_GRUPO_I 
                 @p052_GRUPO = :nome, 
                 @p052_areaid = :areaId, 
                 @p052_menuid = :menuId, 
                 @senha = :senha, 
                 @p052_cdusuario = :usuarioExecutor,
                 @resulta = @resulta OUTPUT, 
                 @mensa = @mensa OUTPUT;
             SELECT @resulta AS resulta, @mensa AS mensa;";

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':areaId', $areaId, PDO::PARAM_INT);
    $stmt->bindValue(':menuId', $menuId, PDO::PARAM_INT);
    $stmt->bindValue(':senha', $senhaExecutor, PDO::PARAM_STR);
    $stmt->bindValue(':usuarioExecutor', $usuarioExecutorId, PDO::PARAM_INT);
    
    $stmt->execute();
    $stmt->nextRowset();
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado === false) {
        return [];
    }
    
    return [$resultado];
}

/**
 * Atualiza um grupo existente.
 *
 * @param int $grupoId
 * @param string $nome
 * @param int $areaId
 * @param int $menuId
 * @param string $status
 * @param string|null $dataUsuario
 * @param int $usuarioExecutorId
 * @param string $senhaExecutor
 * @return array<int, array<string, mixed>>
 */
function atualizarGrupo(
    int $grupoId,
    string $nome,
    int $areaId,
    int $menuId,
    string $status,
    ?string $dataUsuario,
    int $usuarioExecutorId,
    string $senhaExecutor
): array {
    global $conn;

    // Formata a data no formato yyyyMMdd hh:mm para SQL Server
    // Se dataUsuario estiver vazia ou null, usa a data atual
    if (empty($dataUsuario)) {
        $dataFormatada = date('Ymd H:i');
    } else {
        // Tenta converter a data para o formato esperado
        $dataLimpa = preg_replace('/[^0-9\s:]/', '', $dataUsuario);
        $dataLimpa = trim($dataLimpa);
        
        if (empty($dataLimpa)) {
            $dataFormatada = date('Ymd H:i');
        } else {
            $timestamp = strtotime($dataLimpa);
            if ($timestamp !== false) {
                $dataFormatada = date('Ymd H:i', $timestamp);
            } else {
                $dataFormatada = date('Ymd H:i');
            }
        }
    }

    $tsql = "DECLARE @resulta INT, @mensa VARCHAR(100), @NovaData VARCHAR(100);
             EXEC crsa.P0052_GRUPO_U 
                 @p052_GRUPOcd = :grupoId, 
                 @p052_GRUPO = :nome, 
                 @p052_sigla = NULL, 
                 @p052_areaid = :areaId, 
                 @p052_menuid = :menuId, 
                 @senha = :senha, 
                 @p052_cdusuario = :usuarioExecutor, 
                 @p052_datausu = :dataUsuario, 
                 @p052_status = :status,
                 @resulta = @resulta OUTPUT, 
                 @mensa = @mensa OUTPUT,
                 @NovaData = @NovaData OUTPUT;
             SELECT @resulta AS resulta, @mensa AS mensa, @NovaData AS NovaData;";

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':grupoId', $grupoId, PDO::PARAM_INT);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':areaId', $areaId, PDO::PARAM_INT);
    $stmt->bindValue(':menuId', $menuId, PDO::PARAM_INT);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':dataUsuario', $dataFormatada, PDO::PARAM_STR);
    $stmt->bindValue(':senha', $senhaExecutor, PDO::PARAM_STR);
    $stmt->bindValue(':usuarioExecutor', $usuarioExecutorId, PDO::PARAM_INT);
    
    $stmt->execute();
    $stmt->nextRowset();
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado === false) {
        return [];
    }
    
    return [$resultado];
}

/**
 * Lista áreas para seleção nos formulários de grupo.
 *
 * @param string $status
 * @return array<int, array<string, mixed>>
 */
function listarAreasGerenciais(string $status = 'A', int $ordem = 0): array
{
    global $conn;

    $tsql = 'exec crsa.P0052_AREA @p052_status = :status, @ordem = :ordem';

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':ordem', $ordem, PDO::PARAM_INT);
    $stmt->execute();

    // A procedure retorna XML, então precisamos concatenar todas as linhas
    $xmlResult = '';
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        if (isset($row[0])) {
            $xmlResult .= $row[0];
        }
    }

    // Se não retornou nada, retorna array vazio
    if (empty(trim($xmlResult))) {
        return [];
    }

    // Processa o XML usando a função existente
    return converterXmlRawParaArray($xmlResult);
}

function listarAreasCadastroGrupo(string $status = 'A'): array
{
    return listarAreasGerenciais($status, 0);
}

function inserirArea(
    string $nome,
    string $sigla,
    int $usuarioExecutorId,
    string $senhaExecutor
): array {
    global $conn;

    $tsql = "DECLARE @resulta INT, @mensa VARCHAR(100);
             EXEC crsa.P0052_AREA_I 
                 @p052_AREA = :nome, 
                 @p052_area_sigla = :sigla, 
                 @senha = :senha, 
                 @p052_cdusuario = :usuarioExecutor,
                 @resulta = @resulta OUTPUT, 
                 @mensa = @mensa OUTPUT;
             SELECT @resulta AS resulta, @mensa AS mensa;";

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':sigla', $sigla, PDO::PARAM_STR);
    $stmt->bindValue(':senha', $senhaExecutor, PDO::PARAM_STR);
    $stmt->bindValue(':usuarioExecutor', $usuarioExecutorId, PDO::PARAM_INT);
    
    $stmt->execute();
    $stmt->nextRowset();
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado === false) {
        return [];
    }
    
    return [$resultado];
}

function atualizarArea(
    int $areaId,
    string $nome,
    string $sigla,
    string $status,
    ?string $dataUsuario,
    int $usuarioExecutorId,
    string $senhaExecutor
): array {
    global $conn;

    // Formata a data no formato yyyyMMdd hh:mm para SQL Server
    // Se dataUsuario estiver vazia ou null, usa a data atual
    if (empty($dataUsuario)) {
        $dataFormatada = date('Ymd H:i');
    } else {
        // Tenta converter a data para o formato esperado
        // Remove caracteres não numéricos e espaços extras
        $dataLimpa = preg_replace('/[^0-9\s:]/', '', $dataUsuario);
        $dataLimpa = trim($dataLimpa);
        
        // Se ainda estiver vazia após limpeza, usa data atual
        if (empty($dataLimpa)) {
            $dataFormatada = date('Ymd H:i');
        } else {
            // Tenta parsear e reformatar
            $timestamp = strtotime($dataLimpa);
            if ($timestamp !== false) {
                $dataFormatada = date('Ymd H:i', $timestamp);
            } else {
                // Se não conseguir parsear, usa data atual
                $dataFormatada = date('Ymd H:i');
            }
        }
    }

    $tsql = "DECLARE @resulta INT, @mensa VARCHAR(100), @NovaData VARCHAR(100);
             EXEC crsa.P0052_AREA_U 
                 @p052_AREAid = :areaId, 
                 @p052_AREA = :nome, 
                 @p052_AREA_sigla = :sigla, 
                 @p052_ativo = :status, 
                 @p052_datausu = :dataUsuario, 
                 @senha = :senha, 
                 @p052_cdusuario = :usuarioExecutor,
                 @resulta = @resulta OUTPUT, 
                 @mensa = @mensa OUTPUT,
                 @NovaData = @NovaData OUTPUT;
             SELECT @resulta AS resulta, @mensa AS mensa, @NovaData AS NovaData;";

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':areaId', $areaId, PDO::PARAM_INT);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':sigla', $sigla, PDO::PARAM_STR);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':dataUsuario', $dataFormatada, PDO::PARAM_STR);
    $stmt->bindValue(':senha', $senhaExecutor, PDO::PARAM_STR);
    $stmt->bindValue(':usuarioExecutor', $usuarioExecutorId, PDO::PARAM_INT);
    
    $stmt->execute();
    $stmt->nextRowset();
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado === false) {
        return [];
    }
    
    return [$resultado];
}

/**
 * Lista menus principais para seleção nos formulários de grupo.
 *
 * @param string $status
 * @return array<int, array<string, mixed>>
 */
function listarMenusGrupo(string $status = 'A'): array
{
    global $conn;

    $tsql = 'exec crsa.P1102_MENU @p1102_status = :status, @ordem = :ordem';

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':ordem', 0, PDO::PARAM_INT);
    $stmt->execute();

    // A procedure retorna XML, então precisamos concatenar todas as linhas
    $xmlResult = '';
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        if (isset($row[0])) {
            $xmlResult .= $row[0];
        }
    }

    // Se não retornou nada, retorna array vazio
    if (empty(trim($xmlResult))) {
        return [];
    }

    // Processa o XML usando a função existente
    return converterXmlRawParaArray($xmlResult);
}

/**
 * Retorna os usuários pertencentes a um grupo.
 *
 * @param int $grupoId
 * @param string $status
 * @return array<int, array<string, mixed>>
 */
function listarUsuariosPorGrupo(int $grupoId, string $status = 'A'): array
{
    global $conn;

    $tsql = 'SET NOCOUNT ON; exec crsa.P1110_USUARIOS @p052_grupocd = :grupoId, @p1110_ativo = :status, @ordem = :ordem';

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':grupoId', $grupoId, PDO::PARAM_INT);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':ordem', 0, PDO::PARAM_INT);

    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Processamento específico para XML desta procedure
    if (!empty($dados)) {
        $primeiraLinha = $dados[0];
        $colunas = array_keys($primeiraLinha);
        
        if (count($colunas) === 1) {
            $xmlContent = $primeiraLinha[$colunas[0]];
            if (is_string($xmlContent) && strpos($xmlContent, '<row') !== false) {
                // Parse manual do XML usando regex
                $resultado = [];
                
                // Usar regex para extrair cada <row>
                if (preg_match_all('/<row([^>]*)\/?>/', $xmlContent, $matches)) {
                    foreach ($matches[1] as $atributos) {
                        $item = [];
                        // Extrair atributos usando regex
                        if (preg_match_all('/(\w+)="([^"]*)"/', $atributos, $attrMatches)) {
                            for ($i = 0; $i < count($attrMatches[1]); $i++) {
                                $item[$attrMatches[1][$i]] = $attrMatches[2][$i];
                            }
                        }
                        if (!empty($item)) {
                            $resultado[] = $item;
                        }
                    }
                }
                
                return $resultado;
            }
        }
    }

    return $dados;
}

/**
 * Lista os direitos de usuário considerando filtros.
 *
 * @param int|null $programaId
 * @param int|null $usuarioId
 * @param int|null $sistemaId
 * @param int|null $grupoId
 * @param int $ordem
 * @return array<int, array<string, mixed>>
 */
function listarDireitosUsuario(
    ?int $programaId,
    ?int $usuarioId,
    ?int $sistemaId,
    ?int $grupoId,
    int $ordem = 0
): array {
    global $conn;

    $tsql = 'SET NOCOUNT ON; exec crsa.P1106_DIREITOS_USUARIO '
        . '@p1110_usuarioid = :usuarioId, '
        . '@p052_grupocd = :grupoId, '
        . '@p1103_programaid = :programaId, '
        . '@p1104_sistemaid = :sistemaId, '
        . '@ordem = :ordem';

    // Criar uma mensagem de debug visível
    $sqlFinal = "exec crsa.P1106_DIREITOS_USUARIO @p1110_usuarioid = $usuarioId, @p052_grupocd = $grupoId, @p1103_programaid = $programaIdFinal, @p1104_sistemaid = $sistemaId, @ordem = $ordem";

    $stmt = $conn->prepare($tsql);
    // Passar 0 em vez de NULL para programa (comportamento ASP)
    $stmt->bindValue(':programaId', $programaIdFinal, PDO::PARAM_INT);
    $stmt->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
    $stmt->bindValue(':sistemaId', $sistemaId, PDO::PARAM_INT);
    $stmt->bindValue(':grupoId', $grupoId, PDO::PARAM_INT);
    $stmt->bindValue(':ordem', $ordem, PDO::PARAM_INT);

    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Processamento específico para XML desta procedure
    if (!empty($dados)) {
        $primeiraLinha = $dados[0];
        $colunas = array_keys($primeiraLinha);
        
        if (count($colunas) === 1) {
            $nomeColuna = $colunas[0];
            
            // Se há múltiplas linhas, concatenar todos os fragmentos XML
            $xmlContent = '';
            foreach ($dados as $linha) {
                if (isset($linha[$nomeColuna]) && is_string($linha[$nomeColuna])) {
                    $xmlContent .= $linha[$nomeColuna];
                }
            }
            
            if (strpos($xmlContent, '<row') !== false) {
                // Parse manual do XML para esta procedure específica
                $resultado = [];
                
                // Usar regex mais abrangente para extrair todos os <row> (fechados ou auto-fechados)
                if (preg_match_all('/<row([^>]*?)(?:\/>|><\/row>)/s', $xmlContent, $matches)) {
                    foreach ($matches[1] as $atributos) {
                        $item = [];
                        
                        // Extrair apenas os campos essenciais usando regex específica
                        if (preg_match('/p1104_Sistema="([^"]*)"/', $atributos, $sistemaMatch)) {
                            $item['p1104_Sistema'] = trim($sistemaMatch[1]);
                        }
                        
                        if (preg_match('/p1103_Programa="([^"]*)"/', $atributos, $programaMatch)) {
                            $item['p1103_Programa'] = trim($programaMatch[1]);
                        }
                        
                        if (preg_match('/p1106_Direito="([^"]*)"/', $atributos, $direitoMatch)) {
                            $item['p1106_Direito'] = $direitoMatch[1];
                        } else {
                            // Se não tem direito definido, é programa sem direito configurado
                            $item['p1106_Direito'] = '0';
                        }
                        
                        // Extrair ID do programa para uso interno
                        if (preg_match('/p1103_ProgramaID="([^"]*)"/', $atributos, $progIdMatch)) {
                            $item['p1103_ProgramaID'] = $progIdMatch[1];
                        }
                        
                        // Só adicionar se tiver pelo menos sistema e programa
                        if (!empty($item['p1104_Sistema']) && !empty($item['p1103_Programa'])) {
                            // Para compatibilidade com o código existente
                            $item['p1106_DireitosID'] = '0';
                            $resultado[] = $item;
                        }
                    }
                }
                
                return $resultado;
            }
        }
    }

    return $dados;
}

/**
 * Cria um direito para usuário.
 */
function inserirDireitoUsuario(
    int $direito,
    int $programaId,
    int $usuarioId,
    int $grupoId,
    int $usuarioExecutorId,
    string $senhaExecutor
): void {
    // Executa a procedure fornecendo os parâmetros OUTPUT obrigatórios
    global $conn;
    
    $tsql = "DECLARE @mensa VARCHAR(255), @resulta INT; "
         . "EXEC crsa.P1106_DIREITOS_I "
         . "@P1106_DIREITO = ?, "
         . "@p1103_programaid = ?, "
         . "@p1110_usuarioid = ?, "
         . "@p052_grupocd = ?, "
         . "@p1106_cdusuario = ?, "
         . "@senha = ?, "
         . "@mensa = @mensa OUTPUT, "
         . "@resulta = @resulta OUTPUT;";

    $stmt = $conn->prepare($tsql);
    $stmt->execute([
        $direito,
        $programaId,
        $usuarioId,
        $grupoId,
        $usuarioExecutorId,
        $senhaExecutor
    ]);
}

/**
 * Atualiza um direito existente.
 */
function atualizarDireitoUsuario(
    int $direitoId,
    int $direito,
    int $programaId,
    int $usuarioId,
    int $grupoId,
    int $usuarioExecutorId,
    string $senhaExecutor
): void {
    // Executa a procedure fornecendo os parâmetros OUTPUT obrigatórios
    global $conn;
    
    $tsql = "DECLARE @mensa VARCHAR(255), @resulta INT; "
         . "EXEC crsa.P1106_DIREITOS_U "
         . "@p1106_direitosID = ?, "
         . "@P1106_DIREITO = ?, "
         . "@p1103_programaid = ?, "
         . "@p1110_usuarioid = ?, "
         . "@p052_grupocd = ?, "
         . "@p1106_cdusuario = ?, "
         . "@senha = ?, "
         . "@mensa = @mensa OUTPUT, "
         . "@resulta = @resulta OUTPUT;";

    $stmt = $conn->prepare($tsql);
    $stmt->execute([
        $direitoId,
        $direito,
        $programaId,
        $usuarioId,
        $grupoId,
        $usuarioExecutorId,
        $senhaExecutor
    ]);
}

/**
 * Valida senha do executor.
 */
function validarSenhaUsuario(int $usuarioId, string $senha): bool
{
    global $conn;

    $resulta = "0";
    $mensa = "";
    
    $sql = "exec sgcr.crsa.[P1110_CONFSENHA] @p1110_usuarioid = :p1110_usuarioid, @p1110_senha = :p1110_senha, @resulta = :resulta, @mensa = :mensa";
    $stmt = $conn->prepare($sql);

    /* input */
    $stmt->bindParam(':p1110_usuarioid', $usuarioId, PDO::PARAM_INT);
    $stmt->bindParam(':p1110_senha', $senha, PDO::PARAM_STR);
    /* output */
    $stmt->bindParam(':resulta', $resulta, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
    $stmt->bindParam(':mensa', $mensa, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
    
    $stmt->execute();
    $stmt->nextRowset();
    
    // Se resulta for 0, a senha está correta
    return (int) $resulta === 0;
}

/**
 * Lista direitos por grupo.
 */
function listarDireitosGrupo(int $grupoId, ?int $programaId, ?int $sistemaId, int $ordem = 0): array
{
    global $conn;

    $tsql = 'SET NOCOUNT ON; exec crsa.P1106_DIREITOS_grupo '
        . '@p052_grupocd = :grupoId, '
        . '@p1103_programaid = :programaId, '
        . '@p1104_sistemaid = :sistemaId, '
        . '@ordem = :ordem';

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':grupoId', $grupoId, PDO::PARAM_INT);
    $stmt->bindValue(':programaId', $programaId, $programaId === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $stmt->bindValue(':sistemaId', $sistemaId, PDO::PARAM_INT);
    $stmt->bindValue(':ordem', $ordem, PDO::PARAM_INT);

    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Processamento específico para XML desta procedure
    if (!empty($dados)) {
        $primeiraLinha = $dados[0];
        $colunas = array_keys($primeiraLinha);
        
        if (count($colunas) === 1) {
            $nomeColuna = $colunas[0];
            
            // Se há múltiplas linhas, concatenar todos os fragmentos XML
            $xmlContent = '';
            foreach ($dados as $linha) {
                if (isset($linha[$nomeColuna]) && is_string($linha[$nomeColuna])) {
                    $xmlContent .= $linha[$nomeColuna];
                }
            }
            
            if (strpos($xmlContent, '<row') !== false) {
                // Parse manual do XML para esta procedure específica
                $resultado = [];
                
                // Usar regex para extrair cada <row>
                if (preg_match_all('/<row([^>]*)\/?>/', $xmlContent, $matches)) {
                    foreach ($matches[1] as $atributos) {
                        $item = [];
                        // Extrair atributos usando regex
                        if (preg_match_all('/(\w+)="([^"]*)"/', $atributos, $attrMatches)) {
                            for ($i = 0; $i < count($attrMatches[1]); $i++) {
                                $item[$attrMatches[1][$i]] = $attrMatches[2][$i];
                            }
                        }
                        if (!empty($item)) {
                            // Se não tem DireitosID, definir como 0 (novo registro)
                            if (!isset($item['p1106_DireitosID'])) {
                                $item['p1106_DireitosID'] = '0';
                            }
                            // Se não tem direito definido, definir como 0 (sem direitos)
                            if (!isset($item['p1106_Direito'])) {
                                $item['p1106_Direito'] = '0';
                            }
                            $resultado[] = $item;
                        }
                    }
                }
                
                return $resultado;
            }
        }
    }

    return normalizarResultadoProcedures($dados);
}

/**
 * Atualiza direito do grupo.
 */
function atualizarDireitoGrupo(
    int $direitoId,
    int $grupoId,
    int $programaId,
    int $direito,
    int $usuarioExecutorId,
    string $senhaExecutor
): void {
    // Executa a procedure fornecendo os parâmetros OUTPUT obrigatórios
    global $conn;
    
    $tsql = "DECLARE @mensa VARCHAR(255), @resulta INT; "
         . "EXEC crsa.P1106_DIREITOS_U "
         . "@p1106_direitosID = ?, "
         . "@P1106_DIREITO = ?, "
         . "@p1103_programaid = ?, "
         . "@p1110_usuarioid = 0, "
         . "@p052_grupocd = ?, "
         . "@p1106_cdusuario = ?, "
         . "@senha = ?, "
         . "@mensa = @mensa OUTPUT, "
         . "@resulta = @resulta OUTPUT;";

    $stmt = $conn->prepare($tsql);
    $stmt->execute([
        $direitoId,
        $direito,
        $programaId,
        $grupoId,
        $usuarioExecutorId,
        $senhaExecutor
    ]);
}

/**
 * Insere direito para grupo.
 */
function inserirDireitoGrupo(
    int $grupoId,
    int $programaId,
    int $direito,
    int $usuarioExecutorId,
    string $senhaExecutor
): void {
    // Executa a procedure fornecendo os parâmetros OUTPUT obrigatórios
    global $conn;
    
    $tsql = "DECLARE @mensa VARCHAR(255), @resulta INT; "
         . "EXEC crsa.P1106_DIREITOS_I "
         . "@P1106_DIREITO = ?, "
         . "@p1103_programaid = ?, "
         . "@p1110_usuarioid = 0, "
         . "@p052_grupocd = ?, "
         . "@p1106_cdusuario = ?, "
         . "@senha = ?, "
         . "@mensa = @mensa OUTPUT, "
         . "@resulta = @resulta OUTPUT;";

    $stmt = $conn->prepare($tsql);
    $stmt->execute([
        $direito,
        $programaId,
        $grupoId,
        $usuarioExecutorId,
        $senhaExecutor
    ]);
}

/**
 * Retorna lista de áreas.
 */
function listarAreas(string $status = 'A'): array
{
    $tsql = 'exec crsa.P1102_AREAS @p1102_status = :status';

    return executarProcedureLista($tsql, [
        ':status' => $status,
    ]);
}

/**
 * Retorna lista de áreas x grupo.
 */
function listarAreasGrupo(int $grupoId): array
{
    $tsql = 'exec crsa.P1102_AREAS_GRUPO @p052_grupocd = :grupoId';

    return executarProcedureLista($tsql, [
        ':grupoId' => $grupoId,
    ]);
}

/**
 * Atualiza associação de área com grupo.
 */
function salvarAreasGrupo(int $grupoId, array $areasSelecionadas, int $usuarioExecutorId): void
{
    $tsqlLimpa = 'exec crsa.P1102_AREAS_GRUPO_D @p052_grupocd = :grupoId';
    executarProcedureSemResultado($tsqlLimpa, [':grupoId' => $grupoId]);

    foreach ($areasSelecionadas as $areaId) {
        $tsqlInsere = 'exec crsa.P1102_AREAS_GRUPO_I '
            . '@p052_grupocd = :grupoId, '
            . '@p1102_areaid = :areaId, '
            . '@p1102_cdusuario = :usuarioExecutor';

        executarProcedureSemResultado($tsqlInsere, [
            ':grupoId'         => $grupoId,
            ':areaId'          => (int) $areaId,
            ':usuarioExecutor' => $usuarioExecutorId,
        ]);
    }
}

/**
 * Lista usuários cadastrados com filtros básicos.
 */
function listarUsuarios(array $filtros = []): array
{
    $tsql = 'exec crsa.P1110_USUARIOS '
        . '@p052_grupocd = :grupoId, '
        . '@p1110_nome = :nome, '
        . '@p1110_ativo = :status, '
        . '@ordem = :ordem';

    $grupoId = $filtros['grupoId'] ?? null;
    $nome = $filtros['nome'] ?? '';
    $status = $filtros['status'] ?? 'A';
    $ordem = $filtros['ordem'] ?? 0;

    return executarProcedureLista($tsql, [
        ':grupoId' => $grupoId,
        ':nome'    => $nome,
        ':status'  => $status,
        ':ordem'   => $ordem,
    ]);
}

/**
 * Atualiza dados cadastrais do usuário.
 */
function atualizarUsuario(array $dados): void
{
    $tsql = 'exec crsa.P1110_USUARIOS_U '
        . '@p1110_usuarioid = :usuarioId, '
        . '@p1110_nome = :nome, '
        . '@p1110_apelido = :apelido, '
        . '@p1110_cracha = :cracha, '
        . '@p1110_cpf = :cpf, '
        . '@p1110_telefone = :telefone, '
        . '@p1110_celular = :celular, '
        . '@p1110_email = :email, '
        . '@p052_grupocd = :grupoId, '
        . '@p1110_username = :username, '
        . '@p1110_ativo = :status, '
        . '@p1110_responsavelarea = :respArea';

    executarProcedureSemResultado($tsql, [
        ':usuarioId' => (int) $dados['usuarioId'],
        ':nome'      => $dados['nome'] ?? null,
        ':apelido'   => $dados['apelido'] ?? null,
        ':cracha'    => $dados['cracha'] ?? null,
        ':cpf'       => $dados['cpf'] ?? null,
        ':telefone'  => $dados['telefone'] ?? null,
        ':celular'   => $dados['celular'] ?? null,
        ':email'     => $dados['email'] ?? null,
        ':grupoId'   => (int) ($dados['grupoId'] ?? 0),
        ':username'  => $dados['username'] ?? null,
        ':status'    => $dados['status'] ?? 'A',
        ':respArea'  => $dados['responsavelArea'] ?? null,
    ]);
}

/**
 * Insere novo usuário.
 */
function inserirUsuario(array $dados): void
{
    $tsql = 'exec crsa.P1110_USUARIOS_I '
        . '@p1110_nome = :nome, '
        . '@p1110_apelido = :apelido, '
        . '@p1110_cracha = :cracha, '
        . '@p1110_cpf = :cpf, '
        . '@p1110_telefone = :telefone, '
        . '@p1110_celular = :celular, '
        . '@p1110_email = :email, '
        . '@p052_grupocd = :grupoId, '
        . '@p1110_username = :username, '
        . '@p1110_ativo = :status, '
        . '@p1110_responsavelarea = :respArea';

    executarProcedureSemResultado($tsql, [
        ':nome'      => $dados['nome'] ?? null,
        ':apelido'   => $dados['apelido'] ?? null,
        ':cracha'    => $dados['cracha'] ?? null,
        ':cpf'       => $dados['cpf'] ?? null,
        ':telefone'  => $dados['telefone'] ?? null,
        ':celular'   => $dados['celular'] ?? null,
        ':email'     => $dados['email'] ?? null,
        ':grupoId'   => (int) ($dados['grupoId'] ?? 0),
        ':username'  => $dados['username'] ?? null,
        ':status'    => $dados['status'] ?? 'A',
        ':respArea'  => $dados['responsavelArea'] ?? null,
    ]);
}

/**
 * Atualiza senha do usuário.
 */
function atualizarSenhaUsuario(int $usuarioId, string $senhaAtual, string $senhaNova): array
{
    $tsql = 'exec crsa.P1110_TrocaSenha '
        . '@p1110_usuarioid = :usuarioId, '
        . '@p1110_senhaAtual = :senhaAtual, '
        . '@p1110_senhaNova = :senhaNova';

    return executarProcedureLista($tsql, [
        ':usuarioId'   => $usuarioId,
        ':senhaAtual'  => $senhaAtual,
        ':senhaNova'   => $senhaNova,
    ]);
}

function buscarUsuarioPorId(int $usuarioId): ?array
{
    $tsql = 'exec crsa.P1110_USUARIOS_FIND @p1110_usuarioid = :usuarioId';

    $resultado = executarProcedureLista($tsql, [
        ':usuarioId' => $usuarioId,
    ]);

    return $resultado[0] ?? null;
}

function alterarSenhaUsuarioBasico(int $usuarioId, string $senhaAtual, string $senhaNova): array
{
    global $conn;

    $tsql = "DECLARE @resulta INT, @mensa VARCHAR(100);
             EXEC crsa.P1110_senha_U 
                 @p1110_senha_old = :senhaAtual, 
                 @p1110_senha = :senhaNova, 
                 @p1110_usuarioid = :usuarioId,
                 @resulta = @resulta OUTPUT, 
                 @mensa = @mensa OUTPUT;
             SELECT @resulta AS resulta, @mensa AS mensa;";

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':senhaAtual', $senhaAtual, PDO::PARAM_STR);
    $stmt->bindValue(':senhaNova', $senhaNova, PDO::PARAM_STR);
    $stmt->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
    
    $stmt->execute();
    $stmt->nextRowset();
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado === false) {
        return [];
    }
    
    return [$resultado];
}

/**
 * Insere um novo programa.
 *
 * @param string $nome
 * @param string|null $codigo
 * @param int $sistemaId
 * @param int $usuarioExecutorId
 * @param string $senhaExecutor
 * @return array<int, array<string, mixed>>
 */
function inserirPrograma(
    string $nome,
    ?string $codigo,
    int $sistemaId,
    int $usuarioExecutorId,
    string $senhaExecutor
): array {
    global $conn;

    $tsql = "DECLARE @resulta INT, @mensa VARCHAR(100), @p1103_programaid INT;
             EXEC crsa.P1103_programas_I 
                 @P1103_programa = :nome, 
                 @p1103_programacd = :codigo, 
                 @p1104_sistemaid = :sistemaId, 
                 @p1103_cdusuario = :usuarioExecutor, 
                 @senha = :senha,
                 @resulta = @resulta OUTPUT, 
                 @mensa = @mensa OUTPUT,
                 @p1103_programaid = @p1103_programaid OUTPUT;
             SELECT @resulta AS resulta, @mensa AS mensa, @p1103_programaid AS p1103_programaid;";

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
    $stmt->bindValue(':sistemaId', $sistemaId, PDO::PARAM_INT);
    $stmt->bindValue(':usuarioExecutor', $usuarioExecutorId, PDO::PARAM_INT);
    $stmt->bindValue(':senha', $senhaExecutor, PDO::PARAM_STR);
    
    $stmt->execute();
    $stmt->nextRowset();
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado === false) {
        return [];
    }
    
    return [$resultado];
}

/**
 * Atualiza um programa existente.
 *
 * @param int $programaId
 * @param string $nome
 * @param string|null $codigo
 * @param int $sistemaId
 * @param string $status
 * @param int $usuarioExecutorId
 * @param string $senhaExecutor
 * @return array<int, array<string, mixed>>
 */
function atualizarPrograma(
    int $programaId,
    string $nome,
    ?string $codigo,
    int $sistemaId,
    string $status,
    int $usuarioExecutorId,
    string $senhaExecutor
): array {
    global $conn;

    $tsql = "DECLARE @resulta INT, @mensa VARCHAR(100);
             EXEC crsa.P1103_programas_U 
                 @p1103_programaid = :programaId, 
                 @P1103_programa = :nome, 
                 @p1103_programacd = :codigo, 
                 @p1104_sistemaid = :sistemaId, 
                 @p1104_ativo = :status, 
                 @p1103_cdusuario = :usuarioExecutor, 
                 @senha = :senha,
                 @resulta = @resulta OUTPUT, 
                 @mensa = @mensa OUTPUT;
             SELECT @resulta AS resulta, @mensa AS mensa;";

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':programaId', $programaId, PDO::PARAM_INT);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
    $stmt->bindValue(':sistemaId', $sistemaId, PDO::PARAM_INT);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':usuarioExecutor', $usuarioExecutorId, PDO::PARAM_INT);
    $stmt->bindValue(':senha', $senhaExecutor, PDO::PARAM_STR);
    
    $stmt->execute();
    $stmt->nextRowset();
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado === false) {
        return [];
    }
    
    return [$resultado];
}

/**
 * Lista os direitos de grupo configurados para um programa.
 *
 * @param int $programaId
 * @return array<int, array<string, mixed>>
 */
function listarDireitosPrograma(int $programaId): array
{
    global $conn;

    $tsql = 'exec crsa.P1106_DIREITOS_grupo2 @p1103_programaid = :programaId';

    $stmt = $conn->prepare($tsql);
    $stmt->bindValue(':programaId', $programaId, PDO::PARAM_INT);
    $stmt->execute();

    // A procedure retorna XML, então precisamos concatenar todas as linhas
    $xmlResult = '';
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        if (isset($row[0])) {
            $xmlResult .= $row[0];
        }
    }

    // Se não retornou nada, retorna array vazio
    if (empty(trim($xmlResult))) {
        return [];
    }

    // Processa o XML usando a função existente
    return converterXmlRawParaArray($xmlResult);
}

/**
 * Insere um novo sistema.
 *
 * @return array<int, array<string, mixed>> Dados retornados pela procedure.
 */
function inserirSistema(string $nome, int $usuarioExecutorId, string $senhaExecutor): array
{
    // Para SQL Server com OUTPUT parameters - inserção não precisa de @NovaData
    global $conn;
    
    $tsql = "DECLARE @mensa VARCHAR(255), @resulta INT; "
         . "EXEC crsa.P1104_SISTEMA_I "
         . "@p1104_sistema = ?, "
         . "@p1104_cdusuario = ?, "
         . "@senha = ?, "
         . "@mensa = @mensa OUTPUT, "
         . "@resulta = @resulta OUTPUT; "
         . "SELECT @mensa as mensa, @resulta as resulta;";

    $stmt = $conn->prepare($tsql);
    $stmt->execute([
        $nome,
        $usuarioExecutorId,
        $senhaExecutor
    ]);
    
    // Captura o resultado (mensagem e código de resultado)
    $resultado = [];
    do {
        try {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (isset($row['resulta']) || isset($row['mensa'])) {
                    $resultado[] = $row;
                }
            }
        } catch (PDOException $e) {
            // Result set vazio, continua
        }
    } while ($stmt->nextRowset());
    
    return $resultado;
}

/**
 * Atualiza um sistema existente.
 *
 * @return array<int, array<string, mixed>> Dados retornados pela procedure.
 */
function atualizarSistema(
    int $sistemaId,
    string $nome,
    string $status,
    string $dataUsuario,
    int $usuarioExecutorId,
    string $senhaExecutor
): array {
    // Para SQL Server com OUTPUT parameters
    global $conn;
    
    $tsql = "DECLARE @mensa VARCHAR(255), @resulta INT, @NovaData VARCHAR(50); "
         . "EXEC crsa.P1104_SISTEMA_U "
         . "@p1104_sistemaid = ?, "
         . "@p1104_sistema = ?, "
         . "@p1104_ativo = ?, "
         . "@p1104_datausu = ?, "
         . "@p1104_cdusuario = ?, "
         . "@senha = ?, "
         . "@mensa = @mensa OUTPUT, "
         . "@resulta = @resulta OUTPUT, "
         . "@NovaData = @NovaData OUTPUT; "
         . "SELECT @mensa as mensa, @resulta as resulta, @NovaData as NovaData;";

    $stmt = $conn->prepare($tsql);
    $stmt->execute([
        $sistemaId,
        $nome,
        $status,
        $dataUsuario,
        $usuarioExecutorId,
        $senhaExecutor
    ]);
    
    // Captura o resultado (mensagem e código de resultado)
    $resultado = [];
    do {
        try {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (isset($row['resulta']) || isset($row['mensa']) || isset($row['NovaData'])) {
                    $resultado[] = $row;
                }
            }
        } catch (PDOException $e) {
            // Result set vazio, continua
        }
    } while ($stmt->nextRowset());
    
    return $resultado;
}


