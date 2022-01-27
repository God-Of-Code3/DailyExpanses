<?php

namespace App\View\Components\Schedule;

use Illuminate\View\Component;

class Column extends Component
{
    public $mainPercent;
    public $transparentPercent;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mainPercent, $transparentPercent=false)
    {
        $this->mainPercent = $mainPercent;
        $this->transparentPercent = $transparentPercent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.schedule.column');
    }
}
