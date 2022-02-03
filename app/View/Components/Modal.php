<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $id;
    public $classes;
    public $activeOnErrors;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title="", $classes="", $activeOnErrors=false)
    {
        $this->title = $title;
        $this->id = $id;
        $this->classes = $classes;
        $this->activeOnErrors = $activeOnErrors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
