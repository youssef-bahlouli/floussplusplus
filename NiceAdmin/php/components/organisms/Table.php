<?php
class Table extends Component
{
    public function render(): string
    {
        $columns = $this->prop('columns', []);
        $rows = $this->prop('rows', []);
        $renderers = $this->prop('renderers', []);
        $striped = $this->prop('striped', true);
        $hover = $this->prop('hover', true);

        $class = $this->classes([
            'table',
            'table-striped' => $striped,
            'table-hover' => $hover,
            $this->prop('class', ''),
        ]);

        $html = '<table class="' . $this->esc($class) . '">';
        $html .= '<thead><tr>';
        foreach ($columns as $col) {
            $colLabel = is_string($col) ? $col : ($col['label'] ?? $col['key'] ?? '');
            $html .= '<th scope="col">' . $this->esc($colLabel) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        $rowAttr = $this->prop('rowAttr', null);

        foreach ($rows as $idx => $row) {
            $attrs = '';
            if (is_callable($rowAttr)) {
                $map = $rowAttr($row, $idx);
                foreach ($map as $k => $v) {
                    $attrs .= ' ' . $k . '="' . $this->esc($v) . '"';
                }
            }
            $html .= '<tr' . $attrs . '>';
            foreach ($columns as $col) {
                $key = is_string($col) ? $col : ($col['key'] ?? '');
                $value = $row[$key] ?? '';
                if (isset($renderers[$key])) {
                    $value = $renderers[$key]($value, $row, $idx);
                }
                $html .= '<td>' . $value . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }
}
