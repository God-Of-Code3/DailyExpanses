<?php

namespace App\View\Components\Menu;

use Illuminate\View\Component;

class MenuItem extends Component
{
    public $active;
    public $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active=false, $disabled=false)
    {
        $this->active = $active;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu.menu-item');
    }
}
