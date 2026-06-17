<?php
class Icon extends Component
{
    public function render(): string
    {
        $name = $this->prop('name', 'bi-circle');
        $class = $this->classes([
            $name,
            $this->prop('class', ''),
        ]);

        return '<i class="' . $this->esc($class) . '"></i>';
    }
}
