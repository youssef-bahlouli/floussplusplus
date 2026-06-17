<?php
class ActivityLog extends Component
{
    public function render(): string
    {
        $logs = $this->prop('logs', []);
        $title = $this->prop('title', 'News & Updates');

    $content = '<div class="activity">';
    foreach ($logs as $log) {
        $content .= new ActivityItem([
            'icon' => $log['icon'] ?? 'bi-circle',
            'details' => $log['details'] ?? '',
            'time' => $log['time'] ?? '',
        ]);
    }
    $content .= '</div>';

    return new Card(['title' => $title, 'slot' => $content]);
    }
}
