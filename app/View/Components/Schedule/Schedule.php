<?php

namespace App\View\Components\Schedule;

use Illuminate\View\Component;

class Schedule extends Component
{
    public $left;
    public $right;
    public $period;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($left, $right, $period)
    {
        $this->left = $left;
        $this->right = $right;
        $this->period = $period;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.schedule.schedule');
    }
}
