<?php
class DashboardStatsGrid extends Component
{
    public function render(): string
    {
        $reste = $this->prop('reste', 0);
        $epargne = $this->prop('epargne', 0);
        $pct = $this->prop('pct', 0);
        $budget = $reste + $epargne;

        $html = '<div class="row">';
        $html .= new StatCard([
            'icon' => 'bi-wallet2',
            'color' => 'primary',
            'label' => 'Rest of Paycheck',
            'value' => number_format((float)$reste, 2),
            'pct' => $pct,
        ]);
        $html .= new StatCard([
            'icon' => 'bi-piggy-bank',
            'color' => 'warning',
            'label' => 'Savings',
            'value' => number_format((float)$epargne, 2),
        ]);
        $html .= new StatCard([
            'icon' => 'bi-calculator',
            'color' => 'success',
            'label' => 'Budget (Savings + Rest)',
            'value' => number_format((float)$budget, 2),
        ]);
        $html .= '</div>';

        return $html;
    }
}
