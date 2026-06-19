<?php
require_once __DIR__ . '/../database_connection.php';

function log_action($username, $action, $details = '', $type = null)
{
    $db = get_con_var();
    $doc = [
        'username' => $username,
        'action' => $action,
        'details' => $details,
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ];
    if ($type !== null) {
        $doc['type'] = $type;
    }
    $db->logs->insertOne($doc);
}

function get_logs_by_type($username, $type, $limit = 0)
{
    $db = get_con_var();
    $opts = [
        'sort' => ['_id' => -1]
    ];
    if ($limit > 0) $opts['limit'] = $limit;
    return $db->logs->find(
        ['username' => $username, 'type' => $type],
        $opts
    );
}

function get_logs($username, $limit = 5)
{
    $db = get_con_var();
    $cursor = $db->logs->find(
        ['username' => $username],
        ['sort' => ['_id' => -1], 'limit' => $limit]
    );
    $icons = [
        'add_salaire' => 'bi bi-cash-stack text-success',
        'add_epargne' => 'bi bi-piggy-bank text-primary',
        'add_depense' => 'bi bi-cart-dash text-danger',
        'register' => 'bi bi-person-plus text-info',
        'login' => 'bi bi-box-arrow-in-right text-secondary',
    ];
    $logs = [];
    foreach ($cursor as $log) {
        $action = $log['action'];
        $logs[] = [
            'icon' => $icons[$action] ?? 'bi bi-record-circle',
            'details' => $log['details'] ?? '',
            'time' => $log['created_at'] instanceof MongoDB\BSON\UTCDateTime
                ? $log['created_at']->toDateTime()->format('H:i')
                : '',
        ];
    }
    return $logs;
}

function render_log($username, $limit = 5)
{
    $logs = get_logs($username, $limit);
    if (empty($logs)) {
        echo '<div class="post-item clearfix"><p>No recent activity.</p></div>';
        return;
    }
    foreach ($logs as $log) {
        echo '<div class="post-item clearfix d-flex align-items-start gap-2 mb-2">';
        echo '<i class="' . $log['icon'] . '" style="font-size:1.2rem;margin-top:2px;"></i>';
        echo '<div>';
        echo '<h4 style="font-size:0.9rem;margin-bottom:2px;">' . htmlspecialchars($log['details']) . '</h4>';
        echo '<p style="font-size:0.75rem;color:#899bbd;margin:0;">' . $log['time'] . '</p>';
        echo '</div>';
        echo '</div>';
    }
}
