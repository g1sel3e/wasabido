<?php
// ... (mantenha o topo do código, sessões e filtros intactos até o loop foreach)

if (!empty($avaliacoes_originais)) {
    foreach ($avaliacoes_originais as $review) {
        
        // 1. Identificação precisa do cargo respeitando quem realmente preencheu o registro
        $cargo = "Membro";
        
        // Verificação explícita por colunas preenchidas na query
        if (!empty($review['nome_admin']) || (isset($review['perfil']) && strtolower($review['perfil']) == 'administrador')) {
            $cargo = "Administrador";
        } elseif (!empty($review['nome_entregador']) || (isset($review['perfil']) && strtolower($review['perfil']) == 'entregador')) {
            $cargo = "Entregador";
        } elseif (!empty($review['nome_cliente']) || (isset($review['perfil']) && strtolower($review['perfil']) == 'cliente')) {
            $cargo = "Cliente";
        }

        // Aplica o filtro por perfil selecionado na tela
        if ($filtro_perfil === 'todos' || strtolower($cargo) === strtolower($filtro_perfil)) {
            $avaliacoes[] = $review;
        }
    }

    // Aplica a ordenação por Nota (Melhores / Piores)
    if ($filtro_ordem === 'melhores') {
        usort($avaliacoes, function($a, $b) {
            return ($b['nota'] ?? 5) <=> ($a['nota'] ?? 5);
        });
    } elseif ($filtro_ordem === 'piores') {
        usort($avaliacoes, function($a, $b) {
            return ($a['nota'] ?? 5) <=> ($b['nota'] ?? 5);
        });
    }
}
?>

<?php if (!empty($avaliacoes)): ?>
  <?php foreach ($avaliacoes as $review): 
      // Definição padrão de segurança
      $nomeExibido = "Membro do Sistema";
      $cargoExibido = "Membro";

      // ORDEM DE PRIORIDADE CORRIGIDA: Se há dados de admin, ele é o Administrador.
      if (!empty($review['nome_admin'])) {
          $nomeExibido = $review['nome_admin'];
          $cargoExibido = "Administrador";
      } elseif (!empty($review['nome_entregador'])) {
          $nomeExibido = $review['nome_entregador'];
          $cargoExibido = "Entregador";
      } elseif (!empty($review['nome_cliente'])) {
          $nomeExibido = $review['nome_cliente'];
          $cargoExibido = "Cliente";
      } else {
          // Fallback caso use chaves unificadas na view do banco
          $nomeExibido = $review['nome'] ?? $review['usuario'] ?? "Membro do Sistema";
          $cargoExibido = ucfirst($review['perfil'] ?? "Membro");
      }

      $primeiraLetra = mb_strtoupper(mb_substr($nomeExibido, 0, 1, 'UTF-8'), 'UTF-8');
      
      $notaReal = isset($review['nota']) ? (int)$review['nota'] : 5;
  ?>
    
    <div class="col-md-6">
      <div class="avaliacao">
        <div class="avatar"><?= htmlspecialchars($primeiraLetra) ?></div>
        <div>
          <div class="nome"><?= htmlspecialchars($nomeExibido) ?></div>
          <div class="cargo"><i class="bi bi-shield-check me-1"></i><?= $cargoExibido ?></div>
          
          <div class="estrelas">
            <?php 
            for ($i = 1; $i <= 5; $i++) {
                echo ($i <= $notaReal) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
            }
            ?>
          </div>

          <div class="comentario">
            <?= !empty($review['comentario']) ? nl2br(htmlspecialchars($review['comentario'])) : '<i>Avaliação enviada sem comentários em texto.</i>' ?>
          </div>
        </div>
      </div>
    </div>

  <?php endforeach; ?>
<?php endif; ?>
