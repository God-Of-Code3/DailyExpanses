<?php

namespace App\View\Components\VerticalList;

use Illuminate\View\Component;

class VerticalListItemProgress extends Component
{
    public $color;
    public $categoryName;
    public $percent;
    public $sumText;
    public $sum;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sum, $color, $categoryName, $percent)
    {
        $this->sumText = number_format($sum, 0, '', ' ')." ₽";
        $this->color = $color;
        $this->categoryName = $categoryName;
        $this->percent = $percent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.vertical-list.vertical-list-item-progress');
    }
}
