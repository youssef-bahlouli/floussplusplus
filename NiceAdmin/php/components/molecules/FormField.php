<?php
class FormField extends Component
{
    public function render(): string
    {
        $name = $this->prop('name', '');
        $label = $this->prop('label', '');
        $type = $this->prop('type', 'text');
        $inputAttrs = $this->prop('inputAttrs', []);
        $invalid = isset($this->errors[$name]);

        $html = '<div class="row mb-3">';
        if ($label) {
            $html .= new Label(['for' => $name, 'text' => $label]);
        }
        $html .= '<div class="col-sm-10">';

        $inputProps = [
            'name' => $name,
            'type' => $type,
            'placeholder' => $this->prop('placeholder', ''),
            'required' => $this->prop('required', false),
            'invalid' => $invalid,
            'inputAttrs' => $inputAttrs,
        ];

        if ($type === 'select') {
            $inputProps['options'] = $this->prop('options', []);
            $html .= new Select($inputProps);
        } elseif ($type === 'textarea') {
            $html .= new Textarea($inputProps);
        } elseif ($type === 'checkbox' || $type === 'radio') {
            $checked = $this->requestValue($name) ? ' checked' : '';
            $html .= sprintf(
                '<input type="%s" name="%s" id="%s" value="1" class="form-check-input"%s>',
                $this->esc($type),
                $this->esc($name),
                $this->esc($this->prop('id', $name)),
                $checked
            );
        } else {
            $html .= new Input($inputProps);
        }

        $html .= $this->error($name);
        $html .= '</div></div>';
        return $html;
    }
}
