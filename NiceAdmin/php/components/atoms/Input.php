<?php
class Input extends Component
{
    public function render(): string
    {
        $name = $this->prop('name', '');
        $type = $this->prop('type', 'text');
        $value = $this->requestValue($name);
        $placeholder = $this->prop('placeholder', '');
        $required = $this->prop('required', false);
        $class = $this->classes([
            'form-control',
            'is-invalid' => $this->prop('invalid', false),
            $this->prop('class', ''),
        ]);

        return sprintf(
            '<input type="%s" name="%s" id="%s" value="%s" placeholder="%s" class="%s"%s%s>',
            $this->esc($type),
            $this->esc($name),
            $this->esc($this->prop('id', $name)),
            $this->esc($value),
            $this->esc($placeholder),
            $this->esc($class),
            $required ? ' required' : '',
            $this->attrs($this->prop('inputAttrs', []))
        );
    }
}
