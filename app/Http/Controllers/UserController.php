<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SimpleXLSXGen;
use App\Http\Controllers\SimpleCSV;


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

    public function getPeriodData($period, $shift) {
        $start = null;
        $end = null;
        $periodText = null;

        $adding = $shift > 0 ? "+ $shift" : "- ".abs($shift);
        $addingQuarters = $shift > 0 ? "+ ".($shift * 3) : "- ".abs($shift * 3);
        switch ($period) {
            case 'year':
                $start = date('Y-m-d 00:00:00', strtotime("first day of January this year $adding year"));
                $end = date('Y-m-d 23:59:59', strtotime("last day of December this year $adding year"));
                $periodText = date('Y', strtotime("this year $adding year"));
                break;

            case 'month':
                $start = date('Y-m-d 00:00:00', strtotime("first day of this month $adding month"));
                $end = date('Y-m-d 23:59:59', strtotime("last day of this month $adding month"));
                $periodText = $this->formatMonth(date('M Y', strtotime("this month $adding month")));
                break;

            case 'week':
                $start = date('Y-m-d 00:00:00', strtotime("monday this week $adding weeks"));
                $end = date('Y-m-d 23:59:59', strtotime("sunday this week $adding weeks"));
                $periodText = $this->formatMonth(date("d M - ", strtotime($start))."".date('d M', strtotime($end)));
                break;

            case 'quarter':
                $m = date('m', strtotime("this month $addingQuarters month"));
                $y = date('Y', strtotime("this month $addingQuarters month"));

                if ($m < 4) {
                    $start = date("$y-$m-d 00:00:00", strtotime("first day of january"));
                    $end = date("$y-$m-d 23:59:59", strtotime("last day of march"));
                } elseif ($m < 7) {
                    $start = date("$y-$m-d 00:00:00", strtotime("first day of april"));
                    $end = date("$y-$m-d 23:59:59", strtotime("last day of juny"));
                } elseif ($m < 10) {
                    $start = date("$y-$m-d 00:00:00", strtotime("first day of july"));
                    $end = date("$y-$m-d 23:59:59", strtotime("last day of september"));
                } elseif ($m > 9) {
                    $start = date("$y-$m-d 00:00:00", strtotime("first day of october"));
                    $end = date("$y-$m-d 23:59:59", strtotime("last day of december"));
                }

                $periodText = date((floor(($m - 1) / 3) + 1)." кв. $y");

                break;
        }

        return [
            'start' => $start,
            'end' => $end,
            'periodText' => $periodText,
        ];
    }

    public function getNextPeriod($data) {
        $period = $data['period'];

        return $this->getPeriodData($period, 'next');
    }

    public function getPrevPeriod($data) {
        $period = $data['period'];

        return $this->getPeriodData($period, 'previous');
    }

    public function getPeriod($data, $shift) {
        $period = $data['period'];
        
        $periodText = $this->formatMonth(date('M Y'));

        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-t 23:59:59');

        if ($period == 'other') {
            $start = date('Y-m-d 00:00:00', strtotime($data['start-period-date']));
            $end = date('Y-m-d 23:59:59', strtotime($data['end-period-date']));
            $periodText = $this->formatMonth(date('d M - ', strtotime($start)).date('d M', strtotime($end)));
        } else {
            $per = $this->getPeriodData($period, $shift);
            $start = $per['start'];
            $end = $per['end'];
            $periodText = $per['periodText'];
        }

        return [
            'start' => $start,
            'end' => $end,
            'periodText' => $periodText
        ];
    }

    public function getFilterData($req, $statistics=false, $shift=0) {
        $data = $req->all();

        if ($data) {
            session(['data' => $req->all()]);
        } else {
            $data = session('data');
        }

        $periodText = $this->formatMonth(date('M Y'));

        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-t 23:59:59');
        $category = null;

        $nullComparison = $statistics ? '<' : '<>';
        $typeText = 'Доходы и расходы';

        $settings = [
            "period" => 'month',
            "category" => '0',
            "type" => 'outcome',
            "start-period-date" => date("d.m.Y"),
            "end-period-date" => date("d.m.Y"),
        ];

        if (!$data) {
            $data = $settings;
        }

        $errors = [];

        if ($data) {
            $period = $this->getPeriod($data, $shift);
            $start = $period['start'];
            $end = $period['end'];
            $periodText = $period['periodText'];

            if (strtotime($start) > strtotime($end)) {
                $errors[] = 'Период не может заканчиваться раньше, чем начался';
            }

            $data['category'] = isset($data["category-$data[type]"]) ? $data["category-$data[type]"] : "";
            $category = Category::find($data['category']);

            $nullComparison = $data['type'] == 'all' ? '<>' : ($data['type'] == 'income' ? '>' : '<');
            $typeText = $data['type'] == 'all' ? 'Доходы и расходы' : ($data['type'] == 'income' ? 'Доходы' : 'Расходы');
        } else {
            $data = $settings;
        }

        return [
            'category' => $category,
            'nullComparison' => $nullComparison,
            'periodText' => $periodText,
            'typeText' => $typeText,
            'start' => $start,
            'end' => $end,
            'errors' => $errors,
            'data' => $data
        ];
    } 

    public function history(Request $req) {
        $user = User::find(Auth::user()->id);
        
        $filterData = $this->getFilterData($req);
        $start = $filterData['start'];
        $end = $filterData['end'];
        $errors = $filterData['errors'];
        $periodText = $filterData['periodText'];
        $typeText = $filterData['typeText'];
        $data = $filterData['data'];
        $category = $filterData['category'];
        $nullComparison = $filterData['nullComparison'];

        if (!empty($errors) and !session()->get('errors')) {
            return redirect()->to(route('history-post'))->with(['errors' => $errors])->withErrors($errors);
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

        return view('history', [
            'transactions' => $transactions, 
            'periodText' => $periodText, 
            'settings' => $data, 
            'category' => $category, 
            'typeText' => $typeText
        ]);
    }

    public function export(Request $req, $export='') {
        $user = User::find(Auth::user()->id);
        
        $filterData = $this->getFilterData($req);
        $start = $filterData['start'];
        $end = $filterData['end'];
        $errors = $filterData['errors'];
        $periodText = $filterData['periodText'];
        $typeText = $filterData['typeText'];
        $data = $filterData['data'];
        $category = $filterData['category'];
        $nullComparison = $filterData['nullComparison'];

        if (!empty($errors) and !session()->get('errors')) {
            return redirect()->to(route('history-post'))->with(['errors' => $errors])->withErrors($errors);
        }

        if ($export != '') {
            if (!$category) {
                $transactions = Transaction::where('user_id', '=', $user->id)
                    ->where('transactions.created_at', '>=', $start)
                    ->where('transactions.created_at', '<=', $end)
                    ->where('sum', $nullComparison, '0')
                    ->orderBy('created_at', 'desc')
                    ->join('categories', 'transactions.category_id', '=', 'categories.id')
                    ->selectRaw('transactions.sum, transactions.created_at as created_at, categories.name')
                    ->get()
                    ->toArray();
            } else {
                $transactions = DB::where('user_id', '=', $user->id)
                    ->where('category_id', '=', $category->id)
                    ->where('transactions.created_at', '>=', $start)
                    ->where('transactions.created_at', '<=', $end)
                    ->where('sum', $nullComparison, '0')
                    ->orderBy('created_at', 'desc')
                    ->join('categories', 'transactions.category_id', '=', 'categories.id')
                    ->selectRaw('transactions.sum, transactions.created_at as created_at, categories.name')
                    ->get()
                    ->toArray();
            }
            
            foreach ($transactions as $key => $transaction) {
                $transactions[$key]['created_at'] = date('Y-m-d H:i:s', strtotime($transaction['created_at']));
            }
            array_unshift($transactions, ['Сумма', 'Дата создания', 'Категория']);
            
            if ($export == 'xlsx') {
                $xlsx = SimpleXLSXGen::fromArray($transactions);
                $xlsx->downloadAs("data.xlsx");

                return redirect()->to(route('export-get'));
            } elseif ($export == 'csv') {
                $csv = SimpleCSV::export($transactions);
                header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="data.csv"');

                print_r($csv);
                // return redirect()->to(route('export-get'));
            }
        } else {
            return view('export', [
                'periodText' => $periodText, 
                'settings' => $data, 
                'category' => $category, 
                'typeText' => $typeText
            ]);
        }
        
    }

    public function statistics(Request $req, $shift=0) {
        $user = User::find(Auth::user()->id);

        $filterData = $this->getFilterData($req, true, $shift);

        $start = $filterData['start'];
        $end = $filterData['end'];
        $errors = $filterData['errors'];
        $periodText = $filterData['periodText'];
        $typeText = $filterData['typeText'];
        $data = $filterData['data'];
        $nullComparison = $filterData['nullComparison'];

        if (!empty($errors) and !session()->get('errors')) {
            return redirect()->to(route('statistics-post'))->with(['errors' => $errors])->withErrors($errors);
        }

        $transactions = Transaction::where('user_id', '=', $user->id)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->where('sum', $nullComparison, '0')
            ->groupBy('category_id')
            ->selectRaw('abs(sum(sum)) as sum, category_id')
            ->pluck('sum','category_id');

        $categories = [];
        $sum = array_sum($transactions->toArray());
        foreach ($transactions as $category_id => $sectorSum) {
            $category = Category::find($category_id);
            $categories[] = [
                'color' => $category->color,
                'percent' => $sectorSum / $sum * 100,
                'sum' => $sectorSum,
                'name' => $category->name
            ];
        }

        uasort($categories, function ($a, $b) { return $a['percent'] < $b['percent']; });

        return view('statistics', [
            'categories' => $categories,
            'sum' => TransactionController::formatSum($sum),
            'periodText' => $periodText,
            'typeText' => $typeText,
            'shift' => $shift,
            'settings' => $data
        ]);
    }

    public function getCPI() {
        $url = 'https://ru.investing.com/economic-calendar/russian-cpi-1180';
        $ch = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        curl_close($ch);
        $releaseStr = '<span>Факт.<div class="arial_14 greenFont">';
        $start = strpos($html, $releaseStr) + strlen($releaseStr);
        $end = strpos($html, "%</div>", $start);

        $ICP = str_replace(",", ".", substr($html, $start, $end - $start));

        return 1 + ($ICP / 100);
    }

    public function getForecast($user) {

        $monthNumber = date('Y') * 12 + (int)date('m');
        $startUsingMonth = date('Y' , strtotime($user->created_at)) * 12 + (int)date('m' , strtotime($user->created_at));

        $transactions = Transaction::where('user_id', '=', $user->id)
            ->where('sum', '<', '0')
            ->groupByRaw("Year(created_at) * 12 + Month(created_at)")
            ->selectRaw("abs(sum(sum)) as sum, (Year(created_at) * 12 +  Month(created_at)) AS month")
            ->pluck('sum','month');

        $i = 0;

        $sX = 0;
        $sY = 0;
        $sXY = 0;
        $sXSq = 0;
        $n = 0;
        for ($i = $startUsingMonth; $i < $monthNumber; $i ++) {
            $x = $i - $startUsingMonth + 1;
            $y = isset($transactions[$i]) ? $transactions[$i] : 0;

            $sX += $x;
            $sY += $y;
            $sXY += $x * $y;
            $sXSq += $x * $x;
            $n += 1;
        }
        // foreach ($transactions as $month => $sum) {
        //     if ($start == 0) {
        //         $start = $month;
        //         $i = $month;
        //     }
        //     for ($j = $i + 1; $j < $month; $j ++) {
        //         $points[] = [$j - $start, 0];
        //         $sX += $j - $start;
        //         $sXSq += ($j - $start) * ($j - $start);
        //     }
        //     $i = $month;
        //     $sX += $month - $start;
        //     $sY += $sum;
        //     $sXY += ($sum * ($month - $start));
        //     $sXSq += ($month - $start) * ($month - $start);
        //     $points[] = [$month - $start, $sum];
        // }
        $det = $sXSq * $n - $sX * $sX;
        
        $det_a = $sXSq * $sY - $sX * $sXY;

        $a = ($det_a / $det);
        $det_b = $sXY * $n - $sY * $sX;

        $b = ($det_b / $det);

        $forecast = ($monthNumber - $startUsingMonth) * $b + $a;
        $fact = isset($transactions[$monthNumber]) ? $transactions[$monthNumber] : 0;

        return [$fact, $forecast];
        // $xAvg /= count($points);
        // $yAvg /= count($points);

        // $s1 = 0;
        // $s2 = 0;
        // foreach ($points as $point) {
        //     $x = $point[0];
        //     $y = $point[1];

        //     $s1 += ($x - $xAvg) * ($y - $yAvg);
        //     $s2 += pow(($x - $xAvg), 2);
        // }

        // $a = $s1 / $s2;


    }

    public function forecast() {
        $user = User::find(Auth::user()->id);
        if (session('cpi')) {
            $cpi = session('cpi'); 
        } else {
            $cpi = $this->getCPI();
            session(['cpi' => $cpi]);
        }
        $money = $user->money;
        
        $monthes = [
            '3' => TransactionController::formatSum($money * pow($cpi, 3 / 12)),
            '6' => TransactionController::formatSum($money * pow($cpi, 6 / 12)),
            '12' => TransactionController::formatSum($money * pow($cpi, 12 / 12)),
        ];

        $monthNumber = date('Y') * 12 + (int)date('m');
        $data = $this->getForecast($user);

        $fact = $data[0];
        $forecast = $data[1];

        $difference = $fact > $forecast ? 
            "Фактические траты выше прогноза на ".TransactionController::formatSum($fact - $forecast) : 
            "Фактические траты ниже прогноза на ".TransactionController::formatSum($forecast - $fact);

        $period = date('M Y');
        $monthesKeys = [
            "Jan" => 'январь',
            "Feb" => 'февраль',
            "Mar" => 'март',
            "Apr" => 'апрель',
            "May" => 'май',
            "Jun" => 'июнь',
            "Jul" => 'июль',
            "Aug" => 'август',
            "Sep" => 'сентябрь',
            "Oct" => 'октябрь',
            "Nov" => 'ноябрь',
            "Dec" => 'декабрь',
        ];
        foreach ($monthesKeys as $from => $to) {
            $period = str_replace($from, $to, $period);
        }

        return view('forecast', [
            'monthes' => $monthes,
            'month_forecast' => TransactionController::formatSum($forecast),
            'month_fact' => TransactionController::formatSum($fact),
            'difference' => $difference,
            'period' => $period,
        ]);
    }
}
