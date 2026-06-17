<?php
class StatCard extends Component
{
    public function render(): string
    {
        $icon = $this->prop('icon', 'bi-circle');
        $color = $this->prop('color', 'primary');
        $label = $this->prop('label', '');
        $value = $this->prop('value', 0);
        $pct = $this->prop('pct', null);
        $sublabel = $this->prop('sublabel', '');

        $html = '<div class="col-xxl-4 col-md-6">';
        $html .= '<div class="card info-card ' . $this->esc($color) . '-card">';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title">' . $this->esc($label) . '</h5>';
        $html .= '<div class="d-flex align-items-center">';
        $html .= '<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">';
        $html .= '<i class="bi ' . $this->esc($icon) . '"></i>';
        $html .= '</div>';
        $html .= '<div class="ps-3">';
        $html .= '<h6>' . $this->esc((string)$value) . ' MAD</h6>';

        if ($pct !== null) {
            $html .= sprintf(
                '<span class="text-muted small pt-2 ps-1">%s%% of salary</span>',
                $this->esc((string)$pct)
            );
        }

        if ($sublabel) {
            $html .= '<span class="text-muted small pt-2 ps-1">' . $this->esc($sublabel) . '</span>';
        }

        $html .= '</div></div></div></div></div>';
        return $html;
    }
}
