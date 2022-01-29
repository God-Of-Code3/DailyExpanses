<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class MaterialSelect extends Component
{
    public $name;
    public $labelText;
    public $type;
    public $value;
    public $placeholder;
    public $horizontal;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $type="text", $labelText="", $value="", $placeholder="", $horizontal=false)
    {
        $this->type = $type;
        $this->name = $name;
        $this->labelText = $labelText;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->horizontal = $horizontal;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.material-select');
    }
}
