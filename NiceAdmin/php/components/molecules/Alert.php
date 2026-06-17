<?php
class Alert extends Component
{
    public function render(): string
    {
        $type = $this->prop('type', 'info');
        $message = $this->prop('message', '');
        $dismissible = $this->prop('dismissible', false);

        $class = $this->classes([
            'alert',
            'alert-' . $type,
            'alert-dismissible' => $dismissible,
            $this->prop('class', ''),
        ]);

        $html = '<div class="' . $this->esc($class) . '" role="alert">';
        $html .= $this->esc($message);

        if ($dismissible) {
            $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        }

        $html .= '</div>';
        return $html;
    }
}
