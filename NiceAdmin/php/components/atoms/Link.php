<?php
class Link extends Component
{
    public function render(): string
    {
        $href = $this->prop('href', '#');
        $label = $this->prop('label', '');
        $active = $this->prop('active', false);
        $class = $this->classes([
            $this->prop('class', ''),
            'active' => $active,
        ]);

        if ($active || !$href) {
            return '<span class="' . $this->esc($class) . '">' . $this->esc($label) . '</span>';
        }

        return sprintf(
            '<a href="%s" class="%s"%s>%s</a>',
            $this->esc($href),
            $this->esc($class),
            $this->attrs(),
            $this->esc($label)
        );
    }
}
