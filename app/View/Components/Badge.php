<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $color;
    public $inverse;
    public $icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($color, $inverse, $icon)
    {
        $this->color = $color;
        $this->inverse = $inverse;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.badge');
    }
}
