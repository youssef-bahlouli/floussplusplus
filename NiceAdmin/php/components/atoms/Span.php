<?php
class Span extends Component
{
    public function render(): string
    {
        $text = $this->prop('text', '');
        $class = $this->classes([
            $this->prop('class', ''),
        ]);

        return '<span class="' . $this->esc($class) . '">' . $this->esc($text) . '</span>';
    }
}
