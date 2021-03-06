<?php

namespace App\View\Components\Schedule;

use Illuminate\View\Component;

class Column extends Component
{
    public $height;
    public $text;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($height, $text='')
    {
        $this->height = $height;
        $this->text = $text;
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
