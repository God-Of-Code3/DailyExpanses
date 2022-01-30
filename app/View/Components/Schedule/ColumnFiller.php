<?php

namespace App\View\Components\Schedule;

use Illuminate\View\Component;

class ColumnFiller extends Component
{
    public $color;
    public $height;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($color, $height)
    {
        $this->color = $color;
        $this->height = $height;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.schedule.column-filler');
    }
}
