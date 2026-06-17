<?php
abstract class Component
{
    protected array $props;
    protected array $errors;

    public function __construct(array $props = [])
    {
        $this->props = $props;
        $this->errors = $props['errors'] ?? [];
    }

    abstract public function render(): string;

    protected function prop(string $key, mixed $default = null): mixed
    {
        return $this->props[$key] ?? $default;
    }

    protected function esc(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    protected function attrs(array $extra = []): string
    {
        $all = [...$extra];
        foreach (($this->props['attrs'] ?? []) as $k => $v) {
            $all[$k] = $v;
        }
        $parts = [];
        foreach ($all as $k => $v) {
            if ($v === true) {
                $parts[] = $k;
            } elseif ($v !== false && $v !== null) {
                $parts[] = $k . '="' . $this->esc((string)$v) . '"';
            }
        }
        return $parts ? ' ' . implode(' ', $parts) : '';
    }

    protected function classes(array $classes): string
    {
        $list = [];
        foreach ($classes as $key => $val) {
            if (is_int($key)) {
                $list[] = $val;
            } elseif ($val) {
                $list[] = $key;
            }
        }
        return implode(' ', $list);
    }

    protected function when(bool $condition, callable $fn): string
    {
        if ($condition) {
            return $fn();
        }
        return '';
    }

    protected function each(iterable $items, callable $fn): string
    {
        $out = '';
        foreach ($items as $i => $item) {
            $out .= $fn($item, $i);
        }
        return $out;
    }

    protected function slot(?string $content = null): string
    {
        return $content ?? $this->prop('slot', '');
    }

    protected function requestValue(string $name): string
    {
        return $_POST[$name] ?? $this->prop($name, '');
    }

    protected function error(string $name): string
    {
        if (isset($this->errors[$name])) {
            return '<div class="invalid-feedback d-block">' . $this->esc($this->errors[$name]) . '</div>';
        }
        return '';
    }

    protected function renderEach(array $items, callable $renderer): string
    {
        $out = '';
        foreach ($items as $i => $item) {
            $out .= $renderer($item, $i);
        }
        return $out;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
