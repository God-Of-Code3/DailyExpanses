<?php

namespace App\View\Components\Schedule;

use Illuminate\View\Component;

class Indicator extends Component
{
    public $percent;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($percent)
    {
        $this->percent = $percent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.schedule.indicator');
    }
}
