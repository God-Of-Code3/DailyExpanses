<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Transaction;
use App\Models\Category;

class TransactionItem extends Component
{
    public $transaction;
    public $category;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($transactionId)
    {
        $this->transaction = Transaction::find($transactionId);
        $this->category = Category::find($this->transaction->category_id);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transaction-item');
    }
}
