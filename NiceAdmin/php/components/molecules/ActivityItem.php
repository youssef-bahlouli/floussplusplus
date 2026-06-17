<?php
class ActivityItem extends Component
{
    public function render(): string
    {
        $icon = $this->prop('icon', 'bi-circle');
        $details = $this->prop('details', '');
        $time = $this->prop('time', '');

        $html = '<div class="activity-item d-flex">';
        $html .= '<div class="activite-label">' . $this->esc($time) . '</div>';
        $html .= '<i class="bi ' . $this->esc($icon) . ' activity-badge text-primary me-2"></i>';
        $html .= '<div class="activity-content">' . $this->esc($details) . '</div>';
        $html .= '</div>';
        return $html;
    }
}
