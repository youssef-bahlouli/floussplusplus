<?php
class Textarea extends Component
{
    public function render(): string
    {
        $name = $this->prop('name', '');
        $value = $this->requestValue($name);
        $placeholder = $this->prop('placeholder', '');
        $class = $this->classes([
            'form-control',
            'is-invalid' => $this->prop('invalid', false),
            $this->prop('class', ''),
        ]);

        return sprintf(
            '<textarea name="%s" id="%s" placeholder="%s" class="%s"%s>%s</textarea>',
            $this->esc($name),
            $this->esc($this->prop('id', $name)),
            $this->esc($placeholder),
            $this->esc($class),
            $this->attrs(),
            $this->esc($value)
        );
    }
}
