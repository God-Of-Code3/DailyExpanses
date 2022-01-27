<?php

namespace App\View\Components\VerticalList;

use Illuminate\View\Component;

class VerticalListItem extends Component
{
    public $color;
    public $categoryName;
    public $positive;
    public $sumText;
    public $sum;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sum, $color, $categoryName)
    {
        $this->sumText = number_format($sum, 0, '', ' ')." ₽";
        $this->color = $color;
        $this->categoryName = $categoryName;
        $this->positive = $sum > 0;

        if ($this->positive) {
            $this->sumText = "+".$this->sumText;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.vertical-list.vertical-list-item');
    }
}
