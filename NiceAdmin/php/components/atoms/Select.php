<?php
class Select extends Component
{
    public function render(): string
    {
        $name = $this->prop('name', '');
        $value = $this->requestValue($name);
        $options = $this->prop('options', []);
        $placeholder = $this->prop('placeholder', '');
        $class = $this->classes([
            'form-select',
            'is-invalid' => $this->prop('invalid', false),
            $this->prop('class', ''),
        ]);

        $html = sprintf(
            '<select name="%s" id="%s" class="%s"%s>',
            $this->esc($name),
            $this->esc($this->prop('id', $name)),
            $this->esc($class),
            $this->attrs()
        );

        if ($placeholder) {
            $sel = $value === '' ? ' selected' : '';
            $html .= '<option value=""' . $sel . ' disabled>' . $this->esc($placeholder) . '</option>';
        }

        foreach ($options as $opt) {
            $optVal = is_string($opt) ? $opt : ($opt['value'] ?? $opt['label'] ?? '');
            $optLabel = is_string($opt) ? $opt : ($opt['label'] ?? $opt['value'] ?? '');
            $sel = ((string)$optVal === (string)$value) ? ' selected' : '';
            $html .= '<option value="' . $this->esc((string)$optVal) . '"' . $sel . '>' . $this->esc($optLabel) . '</option>';
        }

        $html .= '</select>';
        return $html;
    }
}
