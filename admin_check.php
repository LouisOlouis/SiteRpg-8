<?php
// Retorna true se o usuário logado é admin
function is_admin(): bool {
    return isset($_SESSION['isadmin']) && $_SESSION['isadmin'] === true;
}

// Aborta com 403 se não for admin — no topo de páginas de ação
function require_admin(): void {
    if (!is_admin()) {
        http_response_code(403);
        echo "<p style='color:red;text-align:center;margin-top:40px'>Acesso negado.</p>";
        exit();
    }
}
