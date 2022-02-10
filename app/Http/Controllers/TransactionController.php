<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    // Получение всех категорий или категорий определенного типа (доход/расход)
    public function getCategories($type='') {
        if ($type != '') {
            $categories = Category::where('type', '=', $type)->get();
        } else {
            $categories = Category::get();
        }

        return $categories;
    }

    // Создание транзакции
    public function createTransaction(Request $req) {
        $data = $req->all();

        $transaction = new Transaction();
        $transaction->sum = $data['type'] == 'outcome' ? -$data['sum'] : $data['sum']; // Если тип транзакции расход, то сумма становится отрицательной
        $transaction->user_id = Auth::user()->id;
        $transaction->category_id = $data["category-$data[type]"];

        $errors = [];
        if ($data['sum'] <= 0) { // Если сумма не положительная, то перебрасываем обратно с сообщением об ошибке
            $errors[] = "Сумма должна быть больше нуля";
        }

        if (!Category::find($data["category-$data[type]"])) {
            $errors[] = "Выберите категорию";
        }

        if (!empty($errors)) {
            return redirect()->to(route('main-get'))->withErrors($errors); 
        }

        $transaction->save();

        $user = User::find(Auth::user()->id);
        $user->money = $user->money + $transaction->sum; // Добавление денег на счет пользователя
        $user->save();

        return redirect()->to(route('main-get'));
    }

    public function transaction($transaction_id, $make_base=false) {
        $user = User::find(Auth::user()->id);
        // Получение выбранной транзакции
        $transaction = Transaction::where('user_id', '=', $user->id)->find($transaction_id);

        if ($transaction) {
            // Получение категории транзакции
            $category = Category::find($transaction->category_id);

            $strDatetime = strtotime($transaction->created_at);
            // Перевод месяца
            $monthes = [
                "Jan" => 'янв',
                "Feb" => 'фев',
                "Mar" => 'мар',
                "Apr" => 'апр',
                "May" => 'май',
                "Jun" => 'июн',
                "Jul" => 'июл',
                "Aug" => 'авг',
                "Sep" => 'сен',
                "Oct" => 'окт',
                "Nov" => 'ноя',
                "Dec" => 'дек',
            ];

            $is_based = false;

            // Если нажата кнопка "сделать базовым", то либо сохраняем базовый товар в сессии, либо удаляем его оттуда, в зависимости от того, выбран ли он как базовый
            if ($make_base) {
                // Если базовый товар не выбран
                if (!session('base_transaction')) {

                    session(['base_transaction' => 
                        [
                            'transaction_id' => $transaction->id,
                            'transaction_sum' => abs($transaction->sum),
                        ]
                    ]);
                    $is_based = true;
                // Если выбранный базовый товар и есть текущий
                } elseif (session('base_transaction')['transaction_id'] == $transaction->id) {
                    session()->forget('base_transaction');
                // Иначе перезаписываем базовый товар
                } else {
                    session(['base_transaction' => 
                        [
                            'transaction_id' => $transaction->id,
                            'transaction_sum' => abs($transaction->sum),
                        ]
                    ]);
                    $is_based = true;
                }
            }

            // Если текущая транзакция выбрана как базовая, то устанавливаем флаг в истинное положение
            if (session('base_transaction')) {
                $is_based = session('base_transaction')['transaction_id'] == $transaction->id;
            }

            // Чтобы при обновлении страницы не переключалось установление базового товара, то перекидываем на эту страницу, не передавая переменную, определеющую выбор базового товара.
            if ($make_base) {
                return redirect()->to(route('transaction-get', ['transaction_id' => $transaction->id]));
            }

            $time = date('H:i:s', $strDatetime);
            $date = date('d M Y', $strDatetime);

            foreach ($monthes as $from => $to) {
                $date = str_replace($from, $to, $date);
            }

            $date = ltrim($date, '0');

            // Вывод данных по транзакции
            return view('transaction', [
                'transaction' => $transaction,
                'sum' => $this->formatSum($transaction->sum, true), 
                'category' => $category, 
                'time' => $time, 
                'date' => $date,
                'valueClass' => $transaction->sum > 0 ? 'green' : 'red',
                'is_based' => $is_based
            ]);
        // Если выбрана неверная транзакция, то перекидываем на главную
        } else {
            return redirect()->to(route('main-get')); 
        }
    }

    public function removeTransaction($transaction_id) {
        
        $user = User::find(Auth::user()->id);
        $transaction = Transaction::where('user_id', '=', $user->id)->find($transaction_id);
        // Если существует транзакция, то удаляем ее
        if ($transaction) {
            $user->money -= $transaction->sum;
            $user->save();
            $transaction->delete();
        }
        // Перекидываем на главную
        return redirect()->to(route('main-get'));
    }

    // Форматированние суммы именно в рубли
    public static function formatSumToRubles($sum) {
        $str = number_format($sum, 2, ',', ' ')." ₽";
        return $str;
    }

    // Форматированние суммы с учетом базового товара
    public static function formatSum($sum, $addPlus=false) {
        if (!session('base_transaction')) {
            $str = number_format($sum, 2, ',', ' ')." ₽";
            if ($addPlus and $sum > 0) {
                $str = "+".$str;
            }
        } else {
           $str = number_format($sum / session('base_transaction')['transaction_sum'], 2, ',', ' ')." б.т.";
            if ($addPlus and $sum > 0) {
                $str = "+".$str;
            } 
        }
        return $str;
    }

    public function editTransaction(Request $req) {
        $user = User::find(Auth::user()->id);
        $data = $req->all();

        $transaction_id = $data['transaction-id'];
        $transaction = Transaction::where('user_id', '=', $user->id)->find($transaction_id);

        // Если транзакция существует, то меняем ее
        if ($transaction) {
            // Перезаписываем остаток пользователя
            $user->money -= $transaction->sum;

            // Перезаписываем сумму
            $transaction->sum = $data['type'] == 'outcome' ? -$data['sum'] : $data['sum'];
            $transaction->category_id = $data["category-$data[type]"];

            $errors = [];
            if ($data['sum'] <= 0) { // Если сумма не положительная, то перебрасываем обратно с сообщением об ошибке
                $errors[] = "Сумма должна быть больше нуля"; 
            }

            if (!Category::find($data["category-$data[type]"])) {
                $errors[] = "Выберите категорию";
            } elseif (Category::find($data["category-$data[type]"])->type != $data["type"]) {
                $errors[] = "Выберите категорию";
            }

            if (!empty($errors)) {
                return redirect()->to(route('transaction-get', ['transaction_id' => $transaction->id]))->withErrors($errors); 
            }

            // Сохраняем транзакцию и текущий остаток пользователя
            $transaction->save();
            $user->money = $user->money + $transaction->sum;
            $user->save();
        }
        return redirect()->to(route('transaction-get', ['transaction_id' => $transaction->id]));
    }
}
