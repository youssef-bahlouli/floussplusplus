<?php
require_once __DIR__ . '/Component.php';
require_once __DIR__ . '/atoms/Input.php';
require_once __DIR__ . '/atoms/Select.php';
require_once __DIR__ . '/atoms/Textarea.php';
require_once __DIR__ . '/atoms/Button.php';
require_once __DIR__ . '/atoms/Icon.php';
require_once __DIR__ . '/atoms/Link.php';
require_once __DIR__ . '/atoms/Label.php';
require_once __DIR__ . '/atoms/Span.php';
require_once __DIR__ . '/molecules/FormField.php';
require_once __DIR__ . '/molecules/StatCard.php';
require_once __DIR__ . '/molecules/Alert.php';
require_once __DIR__ . '/molecules/Breadcrumb.php';
require_once __DIR__ . '/molecules/ProgressBar.php';
require_once __DIR__ . '/molecules/ActivityItem.php';
require_once __DIR__ . '/organisms/Card.php';
require_once __DIR__ . '/organisms/Table.php';
require_once __DIR__ . '/organisms/DashboardStatsGrid.php';
require_once __DIR__ . '/organisms/ActivityLog.php';

function ui_input(array $props = []): string { return new Input($props); }
function ui_select(array $props = []): string { return new Select($props); }
function ui_textarea(array $props = []): string { return new Textarea($props); }
function ui_button(array $props = []): string { return new Button($props); }
function ui_icon(string $name, string $class = ''): string { return new Icon(['name' => $name, 'class' => $class]); }
function ui_link(string $href, string $label, bool $active = false): string { return new Link(['href' => $href, 'label' => $label, 'active' => $active]); }
function ui_label(string $for, string $text): string { return new Label(['for' => $for, 'text' => $text]); }
function ui_span(string $text, string $class = ''): string { return new Span(['text' => $text, 'class' => $class]); }
function ui_formfield(array $props = []): string { return new FormField($props); }
function ui_statcard(array $props = []): string { return new StatCard($props); }
function ui_alert(string $type, string $message, bool $dismissible = false): string { return new Alert(['type' => $type, 'message' => $message, 'dismissible' => $dismissible]); }
function ui_breadcrumb(array $items): string { return new Breadcrumb(['items' => $items]); }
function ui_progress(float $now, float $max, string $color = 'primary', string $label = ''): string { return new ProgressBar(['now' => $now, 'max' => $max, 'color' => $color, 'label' => $label]); }
function ui_card(string $title, string $content, string $class = ''): string { return new Card(['title' => $title, 'slot' => $content, 'class' => $class]); }
function ui_table(array $columns, array $rows, array $renderers = []): string { return new Table(['columns' => $columns, 'rows' => $rows, 'renderers' => $renderers]); }
function ui_statsgrid(array $props = []): string { return new DashboardStatsGrid($props); }
function ui_activitylog(array $logs, string $title = 'News & Updates'): string { return new ActivityLog(['logs' => $logs, 'title' => $title]); }

function currency_symbol(): string {
    if (!isset($_SESSION['currency'])) {
        require_once __DIR__ . '/../repositories/UserRepository.php';
        $user = (new UserRepository())->findByUsername($_SESSION['username'] ?? '');
        $_SESSION['currency'] = $user['currency'] ?? 'MAD';
    }
    return $_SESSION['currency'];
}

function format_money(float $amount, int $decimals = 2): string {
    return number_format($amount, $decimals) . ' ' . currency_symbol();
}
