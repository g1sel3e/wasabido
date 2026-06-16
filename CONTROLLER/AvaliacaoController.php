<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusão segura baseada no diretório do arquivo atual
require_once __DIR__ . "/../DAO/AvaliacaoDAO.php";

class AvaliacaoController
{
    // ==== MÉTODO ADICIONADO PARA BUSCAR DADOS NA VIEW ====
    public function listarAvaliacoesGerais()
    {
        $avaliacaoDAO = new AvaliacaoDAO();
        return $avaliacaoDAO->listarTodasComUsuarios();
    }
}

// --- LOGICA DE PROCESSAMENTO DE ROTAS POST/GET ---
$action = $_GET['action'] ?? '';

if ($action === 'salvar') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $tipo_avaliacao = $_POST['tipo_avaliacao'] ?? null;
        $cod_administrador = $_POST['cod_administrador'] ?? null;
        
        // --- PROCESSAMENTO DAS TAGS DINÂMICAS ---
        $tags_formatadas = null;
        if ($tipo_avaliacao === 'cliente' && isset($_POST['tags_cliente'])) {
            $tags_formatadas = implode(', ', $_POST['tags_cliente']);
        } elseif ($tipo_avaliacao === 'estabelecimento' && isset($_POST['tags_estab'])) {
            $tags_formatadas = implode(', ', $_POST['tags_estab']);
        } elseif ($tipo_avaliacao === 'sistema' && isset($_POST['tags_sistema'])) {
            $tags_formatadas = implode(', ', $_POST['tags_sistema']);
        }

        $dados = [
            'cod_cliente'       => $_POST['cod_cliente'] ?? null,
            'tipo_avaliacao'    => $tipo_avaliacao,
            'nota'              => $_POST['nota'] ?? null,
            'comentario'        => $_POST['comentario'] ?? null,
            'tags'              => $tags_formatadas,
            'cod_entregador'    => $_POST['cod_entregador'] ?? null,
            'cod_pedido'        => $_POST['cod_pedido'] ?? null,
            'cod_produto'       => $_POST['cod_produto'] ?? null,
            'cod_administrador' => $cod_administrador 
        ];

        // --- VALIDAÇÃO INTELIGENTE ---
        if (empty($dados['tipo_avaliacao']) || empty($dados['nota'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($dados['tipo_avaliacao'] === 'cliente' && empty($dados['cod_cliente'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $avaliacaoDAO = new AvaliacaoDAO();
        $sucesso = $avaliacaoDAO->salvarAvaliacao($dados);

        // --- REDIRECIONAMENTO DINÂMICO ---
        if ($sucesso) {
            if (!empty($dados['cod_administrador'])) {
                header("Location: ../VIEW/adm/avaliacaoAdministrador.php");
            } 
            elseif (in_array($dados['tipo_avaliacao'], ['cliente', 'estabelecimento'], true)) {
                header("Location: ../VIEW/entregador/avaliacaoEntregador.php");
            } 
            else {
                header("Location: ../VIEW/cliente/avaliacaoCliente.php");
            }
            exit;
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}
?>
