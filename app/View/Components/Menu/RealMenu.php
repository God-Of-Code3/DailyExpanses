<?php

namespace App\View\Components\Menu;

use Illuminate\View\Component;
use App\Http\Controllers\TransactionController;

class RealMenu extends Component
{
    public $page;
    public $sum;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($page)
    {
        $this->page = [
            'main' => '',
            'history' => '',
            'statistics' => '',
            'forecast' => '',
            'export' => '',
        ];

        $this->page[$page] = 'active';

        $this->sum = session('base_transaction') ? TransactionController::formatSumToRubles(session('base_transaction')['transaction_sum']) : 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu.real-menu');
    }
}
