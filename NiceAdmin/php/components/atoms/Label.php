<?php
class Label extends Component
{
    public function render(): string
    {
        $for = $this->prop('for', '');
        $text = $this->prop('text', '');
        $class = $this->classes([
            'form-label',
            $this->prop('class', ''),
        ]);

        return sprintf(
            '<label for="%s" class="%s">%s</label>',
            $this->esc($for),
            $this->esc($class),
            $this->esc($text)
        );
    }
}
