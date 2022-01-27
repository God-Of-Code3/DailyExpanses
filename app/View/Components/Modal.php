<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $id;
    public $classes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title="", $classes="")
    {
        $this->title = $title;
        $this->id = $id;
        $this->classes = $classes;
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
