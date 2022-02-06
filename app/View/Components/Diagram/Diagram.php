<?php

namespace App\View\Components\Diagram;

use Illuminate\View\Component;

class Diagram extends Component
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
    public function __construct($left, $right, $period, $text, $leftAction, $rightAction)
    {
        $this->left = $left;
        $this->right = $right;
        $this->period = $period;
        $this->text = $text;
        $this->leftAction = $leftAction;
        $this->rightAction = $rightAction;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.diagram.diagram');
    }
}
