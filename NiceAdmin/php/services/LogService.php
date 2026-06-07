<?php
require_once __DIR__ . '/../database_connection.php';

function log_action($username, $action, $details = '')
{
    $db = get_con_var();
    $db->logs->insertOne([
        'username' => $username,
        'action' => $action,
        'details' => $details,
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);
}

function render_log($username, $limit = 5)
{
    $db = get_con_var();
    $cursor = $db->logs->find(
        ['username' => $username],
        ['sort' => ['_id' => -1], 'limit' => $limit]
    );
    $logs = [];
    foreach ($cursor as $doc) {
        $logs[] = $doc;
    }
    if (empty($logs)) {
        echo '<div class="post-item clearfix"><p>Aucune activit&eacute; r&eacute;cente.</p></div>';
        return;
    }
    $icons = [
        'add_salaire' => 'bi bi-cash-stack text-success',
        'add_epargne' => 'bi bi-piggy-bank text-primary',
        'add_depense' => 'bi bi-cart-dash text-danger',
        'register' => 'bi bi-person-plus text-info',
        'login' => 'bi bi-box-arrow-in-right text-secondary',
    ];
    foreach ($logs as $log) {
        $action = $log['action'];
        $icon = $icons[$action] ?? 'bi bi-record-circle';
        $details = htmlspecialchars($log['details'] ?? '');
        $time = $log['created_at'] instanceof MongoDB\BSON\UTCDateTime
            ? $log['created_at']->toDateTime()->format('H:i')
            : '';
        echo '<div class="post-item clearfix d-flex align-items-start gap-2 mb-2">';
        echo '<i class="' . $icon . '" style="font-size:1.2rem;margin-top:2px;"></i>';
        echo '<div>';
        echo '<h4 style="font-size:0.9rem;margin-bottom:2px;">' . $details . '</h4>';
        echo '<p style="font-size:0.75rem;color:#899bbd;margin:0;">' . $time . '</p>';
        echo '</div>';
        echo '</div>';
    }
}
