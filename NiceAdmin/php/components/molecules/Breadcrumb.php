<?php
class Breadcrumb extends Component
{
    public function render(): string
    {
        $items = $this->prop('items', []);

        $html = '<nav>';
        $html .= '<ol class="breadcrumb">';

        foreach ($items as $i => $item) {
            $label = $item['label'] ?? '';
            $url = $item['url'] ?? null;
            $active = $item['active'] ?? ($i === count($items) - 1);
            $class = $this->classes(['breadcrumb-item', 'active' => $active]);

            $html .= '<li class="' . $this->esc($class) . '">';
            if ($active || !$url) {
                $html .= $this->esc($label);
            } else {
                $html .= '<a href="' . $this->esc($url) . '">' . $this->esc($label) . '</a>';
            }
            $html .= '</li>';
        }

        $html .= '</ol></nav>';
        return $html;
    }
}
