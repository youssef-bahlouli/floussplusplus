<?php
class Button extends Component
{
    public function render(): string
    {
        $type = $this->prop('type', 'button');
        $variant = $this->prop('variant', 'primary');
        $label = $this->prop('label', 'Submit');
        $size = $this->prop('size', '');
        $class = $this->classes([
            'btn',
            'btn-' . $variant,
            'btn-' . $size => !!$size,
            $this->prop('class', ''),
        ]);

        return sprintf(
            '<button type="%s" class="%s"%s>%s</button>',
            $this->esc($type),
            $this->esc($class),
            $this->attrs(),
            $this->esc($label)
        );
    }
}
