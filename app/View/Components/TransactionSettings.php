<?php

namespace App\View\Components;

use Illuminate\View\Component;

use App\Http\Controllers\TransactionController;

class TransactionSettings extends Component
{
    public $type;
    public $buttonText;
    public $title;
    public $action;

    public $allCategories;
    public $incomeCategories;
    public $outcomeCategories;
    // Переменные, отвечающие за отображение или неотображение данных
    public $renderAllTypesOption; // Опция "Все транзакции (Доходы и расходы)"
    public $renderAllCategories; // Кнопка "Все категории"
    public $renderPeriod; // Выбор периода
    public $renderCategories; // Выбор категории
    public $renderSum; // Сумма транзакции
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->type = $type;

        switch ($this->type) {
            case 'main':
                $this->title = 'Настройки транзакции';
                $this->buttonText = 'Добавить транзакцию';
                $this->renderAllCategories = false;
                $this->renderAllTypesOption = false;
                $this->renderPeriod = false;
                $this->renderCategories = true;
                $this->renderSum = true;
                $this->action = 'main-post';
                break;
            
            case 'history':
                $this->title = 'Настройки фильтра';
                $this->buttonText = 'Применить';
                $this->renderAllCategories = true;
                $this->renderAllTypesOption = true;
                $this->renderPeriod = true;
                $this->renderCategories = true;
                $this->renderSum = false;
                $this->action = 'history-post';
                break;

            case 'statistics':
                $this->title = 'Настройки фильтра';
                $this->buttonText = 'Применить';
                $this->renderAllCategories = false;
                $this->renderAllTypesOption = false;
                $this->renderPeriod = true;
                $this->renderCategories = false;
                $this->renderSum = false;
                $this->action = 'statistics-post';
                break;

            default:
                // code...
                break;
        }

        $this->getCategories();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */

    public function getCategories() {
        if ($this->renderCategories) {
            $trsController = new TransactionController();
            if ($this->renderAllCategories) {
                $this->allCategories = $trsController->getCategories();
            }

            $this->incomeCategories = $trsController->getCategories('income');
            $this->outcomeCategories = $trsController->getCategories('outcome');
        }
    }

    public function render()
    {
        return view('components.transaction-settings');

    }
}
