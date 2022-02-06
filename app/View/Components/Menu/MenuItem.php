<?php

namespace App\View\Components\Menu;

use Illuminate\View\Component;

class MenuItem extends Component
{
    public $active;
    public $disabled;
    public $href;
    public $hrefKey;
    public $hrefValue;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active=false, $disabled=false, $href='', $hrefKey='', $hrefValue='')
    {
        $this->active = $active;
        $this->disabled = $disabled;
        $this->href = $href;
        $this->hrefKey = $hrefKey;
        $this->hrefValue = $hrefValue;
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
