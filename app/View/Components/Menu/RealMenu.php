<?php

namespace App\View\Components\Menu;

use Illuminate\View\Component;

class RealMenu extends Component
{
    public $page;
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
        ];

        $this->page[$page] = 'active';
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
