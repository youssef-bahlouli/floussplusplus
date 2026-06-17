<?php
class Card extends Component
{
    public function render(): string
    {
        $title = $this->prop('title', '');
        $class = $this->classes([
            'card',
            $this->prop('class', ''),
        ]);
        $width = $this->prop('width', '');

        $html = '<div class="' . $this->esc($class) . '"' . ($width ? ' style="width:' . $this->esc($width) . '"' : '') . '>';
        $html .= '<div class="card-body">';
        $html .= $this->when((bool)$title, fn() => '<h5 class="card-title">' . $this->esc($title) . '</h5>');
        $html .= $this->slot();
        $html .= '</div></div>';

        return $html;
    }
}
