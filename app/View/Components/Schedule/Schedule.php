<?php

namespace App\View\Components\Schedule;

use Illuminate\View\Component;

class Schedule extends Component
{
    public $left;
    public $right;
    public $period;
    public $text;
    public $leftAction;
    public $rightAction;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($left, $right, $period, $text, $leftAction, $rightAction, $null=false, $blockPeriod=false)
    {
        $this->left = $left;
        $this->right = $right;
        $this->period = $period;
        $this->text = $text;
        $this->leftAction = $leftAction;
        $this->rightAction = $rightAction;
        if ($blockPeriod) {
            $this->left = '';
            $this->right = '';
        }
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
