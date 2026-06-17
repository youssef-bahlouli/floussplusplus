<?php
class DashboardStatsGrid extends Component
{
    public function render(): string
    {
        $salaire = $this->prop('salaire', 0);
        $reste = $this->prop('reste', 0);
        $epargne = $this->prop('epargne', 0);
        $pct = $this->prop('pct', 0);

        $html = '<div class="row">';
        $html .= new StatCard([
            'icon' => 'bi-currency-dollar',
            'color' => 'success',
            'label' => 'Salary',
            'value' => number_format((float)$salaire, 2),
        ]);
        $html .= new StatCard([
            'icon' => 'bi-wallet2',
            'color' => 'primary',
            'label' => 'Balance',
            'value' => number_format((float)$reste, 2),
            'pct' => $pct,
        ]);
        $html .= new StatCard([
            'icon' => 'bi-piggy-bank',
            'color' => 'warning',
            'label' => 'Savings',
            'value' => number_format((float)$epargne, 2),
        ]);
        $html .= '</div>';

        return $html;
    }
}
