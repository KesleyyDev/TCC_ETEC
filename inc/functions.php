<?php
/** Escapa valores que poderiam virar fórmulas ao abrir o CSV no Excel. */
function csv_safe_value($value): string
{
    $value = (string)$value;
    return preg_match('/\A[=+\-@]/', $value) ? "'" . $value : $value;
}

/** Exporta os contatos realmente armazenados no banco. */
function gerar_csv_contatos(PDO $database): void
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=relatorio_contatos.csv');

    $output = fopen('php://output', 'w');
    fwrite($output, "\xEF\xBB\xBF");
    fputcsv($output, ['ID', 'Nome', 'Email', 'Assunto', 'Mensagem', 'Status', 'Data']);

    try {
        $stmt = $database->query(
            'SELECT id, nome, email, assunto, mensagem, status, data_envio '
            . 'FROM mensagens_contato ORDER BY data_envio DESC'
        );
        while ($contato = $stmt->fetch()) {
            fputcsv($output, [
                csv_safe_value($contato['id']),
                csv_safe_value($contato['nome']),
                csv_safe_value($contato['email']),
                csv_safe_value($contato['assunto']),
                csv_safe_value($contato['mensagem']),
                csv_safe_value($contato['status']),
                csv_safe_value($contato['data_envio'])
            ]);
        }
    } catch (PDOException $e) {
        error_log('CSV export error: ' . $e->getMessage());
    } finally {
        fclose($output);
        close_database($database);
    }

    exit;
}
?>
