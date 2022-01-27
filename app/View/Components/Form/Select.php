<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $labelText;
    public $horizontal;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $labelText="", $horizontal=false)
    {
        $this->name = $name;
        $this->labelText = $labelText;
        $this->horizontal = $horizontal;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}
