<?php
class ProgressBar extends Component
{
    public function render(): string
    {
        $now = (float)$this->prop('now', 0);
        $max = (float)$this->prop('max', 100);
        $label = $this->prop('label', '');
        $color = $this->prop('color', 'primary');
        $showLabel = $this->prop('showLabel', false);

        $pct = $max > 0 ? min(100, round(($now / $max) * 100, 1)) : 0;

        $html = $this->when((bool)$label, fn() =>
            '<h5 class="card-title">' . $this->esc($label) . '</h5>'
        );

        $html .= '<div class="progress">';
        $html .= sprintf(
            '<div class="progress-bar bg-%s" role="progressbar" style="width: %s%%" aria-valuenow="%s" aria-valuemin="0" aria-valuemax="%s">',
            $this->esc($color),
            $pct,
            $now,
            $max
        );
        $html .= $showLabel ? $this->esc($pct . '%') : '';
        $html .= '</div></div>';

        return $html;
    }
}
