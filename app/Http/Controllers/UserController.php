<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register() {
        // Отображение страницы регистрации
        return view('register');
    }

    public function handleRegister(Request $req) {
        // Проверка на существование аккаунта
        if (User::where('email', $req->input('email'))->exists()) {
            return redirect()->to(route('register-get'))->withErrors(['form' => 'Логин уже используется']);
        }

        // Создание пользователя
        $user = new User();
        $user->email = $req->input('email');
        $user->password = $req->input('password');
        $user->money = 0;

        $user->save();

        // Авторизация
        Auth::login($user);

        // Переброс на главную страницу
        return redirect()->to(route('main-get'));
    }

    public function login() {
        // Отображение страницы авторизации
        return view('login');
    }

    public function handleLogin(Request $req) {
        // Проверка авторизации
        $authData = $req->only(['email', 'password']);

        if (Auth::attempt($authData)) {
            return redirect(route('main-get'));
        } else {
            return redirect(route('login-get'))->withErrors(['form' => 'Не удалось авторизоваться']);
        }
    }

    public function main() {
        $user = User::find(Auth::user()->id);
        $transactions = Transaction::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();

        return view('main', ['transactions' => $transactions, 'money' => TransactionController::formatSum($user->money)]);
    }

    public function formatMonth($text) {
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
        foreach ($monthes as $from => $to) {
            $text = str_replace($from, $to, $text);
        }

        return $text;
    }

    public function history(Request $req) {
        $user = User::find(Auth::user()->id);
        $data = $req->all();

        $periodText = $this->formatMonth(date('M Y'));

        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-t 23:59:59');
        $category = null;

        $nullComparison = '<>';
        $typeText = 'Доходы и расходы';

        $settings = [
            "period" => 'month',
            "category" => '0',
            "type" => 'all',
            "start-period-date" => date("d.m.Y"),
            "end-period-date" => date("d.m.Y"),
        ];

        if ($data) {
            $period = $data['period'];
            
            switch ($period) {
                case 'year':
                    $start = date('Y-01-01 00:00:00');
                    $end = date('Y-m-d 23:59:59', strtotime('12/31'));

                    $periodText = date('Y год');

                    break;

                case 'week':
                    $start = date('Y-m-d 00:00:00', strtotime('monday this week'));
                    $end = date('Y-m-d 23:59:59', strtotime('sunday this week'));

                    $periodText = $this->formatMonth(date('d M - ', strtotime($start)).date('d M', strtotime($end)));
                    break;

                case 'quarter':

                    $m = date('m');
                    if ($m < 4) {
                        $start = date('Y-m-d 00:00:00', strtotime('first day of january'));
                        $end = date('Y-m-d 23:59:59', strtotime('last day of march'));
                    } elseif ($m < 7) {
                        $start = date('Y-m-d 00:00:00', strtotime('first day of april'));
                        $end = date('Y-m-d 23:59:59', strtotime('last day of juny'));
                    } elseif ($m < 10) {
                        $start = date('Y-m-d 00:00:00', strtotime('first day of july'));
                        $end = date('Y-m-d 23:59:59', strtotime('last day of september'));
                    } elseif ($m > 9) {
                        $start = date('Y-m-d 00:00:00', strtotime('first day of october'));
                        $end = date('Y-m-d 23:59:59', strtotime('last day of december'));
                    }

                    $periodText = $this->formatMonth(date('d M - ', strtotime($start)).date('d M', strtotime($end)));
                    
                    break;

                case 'other':

                    $start = date('Y-m-d 00:00:00', strtotime($data['start-period-date']));
                    $end = date('Y-m-d 23:59:59', strtotime($data['end-period-date']));
                    
                    $periodText = $this->formatMonth(date('d M - ', strtotime($start)).date('d M', strtotime($end)));

                    break;
            }
            $data['category'] = $data["category-$data[type]"];
            $category = Category::find($data['category']);

            $nullComparison = $data['type'] == 'all' ? '<>' : ($data['type'] == 'income' ? '>' : '<');
            $typeText = $data['type'] == 'all' ? 'Доходы и расходы' : ($data['type'] == 'income' ? 'Доходы' : 'Расходы');
        } else {
            $data = $settings;
        }

        

        if (!$category) {
            $transactions = Transaction::where('user_id', '=', $user->id)
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->where('sum', $nullComparison, '0')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $transactions = Transaction::where('user_id', '=', $user->id)
                ->where('category_id', '=', $category->id)
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->where('sum', $nullComparison, '0')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('history', ['transactions' => $transactions, 'periodText' => $periodText, 'settings' => $data, 'category' => $category, 'typeText' => $typeText]);
    }
}
