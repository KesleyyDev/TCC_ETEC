<?php
/**
 * Arquivo de funções globais do sistema.
 */

/**
 * Função para gerar um arquivo CSV com os contatos ou usuários cadastrados.
 * Esta função deve ser chamada nas páginas onde a exportação é necessária.
 */
function gerar_csv_contatos() {
    if (isset($_GET['exportar_csv'])) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=relatorio_contatos.csv');
        $output = fopen('php://output', 'w');
        
        fputcsv($output, array('ID', 'Nome', 'Email', 'Data'));
        
        // Dados de exemplo, isso viria do MySQL
        fputcsv($output, array('1', 'João Silva', 'joao@email.com', '2025-01-01'));
        
        fclose($output);
        exit;
    }
}
?>
