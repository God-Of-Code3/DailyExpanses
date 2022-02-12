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
use DateTime;


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
            // Если попытка удачная, то переадресуем на главную
            return redirect(route('main-get'));
        } else {
            // Если нет, то отправляем обратно с ошибкой
            return redirect(route('login-get'))->withErrors(['form' => 'Не удалось авторизоваться']);
        }
    }

    public function main() {
        $user = User::find(Auth::user()->id);

        // Выборка транзакций за последнюю неделю
        $start = date('Y-m-d 00:00:00', strtotime("monday this week"));
        $end = date('Y-m-d 23:59:59', strtotime("sunday this week"));
        $transactions = Transaction::where('user_id', '=', $user->id)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();

        // Вывод главной страницы
        return view('main', ['transactions' => $transactions, 'money' => TransactionController::formatSum($user->money)]);
    }

    public function formatMonth($text) {
        // Переводим месяц
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

        // Смещение периода для года, месяца, недели
        $adding = $shift > 0 ? "+ $shift" : "- ".abs($shift);
        // Смещение периода для квартала
        $addingQuarters = $shift > 0 ? "+ ".($shift * 3) : "- ".abs($shift * 3);
        switch ($period) {
            case 'year': // Период для года
                $start = date('Y-m-d 00:00:00', strtotime("first day of January this year $adding year"));
                $end = date('Y-m-d 23:59:59', strtotime("last day of December this year $adding year"));
                $periodText = date('Y', strtotime("this year $adding year"));
                break;

            case 'month': // Период для месяца
                $start = date('Y-m-d 00:00:00', strtotime("first day of this month $adding month"));
                $end = date('Y-m-d 23:59:59', strtotime("last day of this month $adding month"));
                $periodText = $this->formatMonth(date('M Y', strtotime("this month $adding month")));
                break;

            case 'week': // Период для недели
                $start = date('Y-m-d 00:00:00', strtotime("monday this week $adding weeks"));
                $end = date('Y-m-d 23:59:59', strtotime("sunday this week $adding weeks"));
                $periodText = $this->formatMonth(date("d M - ", strtotime($start))."".date('d M', strtotime($end)));
                break;

            case 'quarter': // Период для квартала
                $m = date('m', strtotime("this month"));
                $y = date('Y', strtotime("this month"));

                // Получение текущего квартала
                if ($m < 4) {
                    $start = date("Y-m-d 00:00:00", strtotime("first day of january"));
                    $end = date("Y-m-d 23:59:59", strtotime("last day of march"));
                } elseif ($m < 7) {
                    $start = date("Y-m-d 00:00:00", strtotime("first day of april"));
                    $end = date("Y-m-d 23:59:59", strtotime("last day of june"));
                } elseif ($m < 10) {
                    $start = date("Y-m-d 00:00:00", strtotime("first day of july"));
                    $end = date("Y-m-d 23:59:59", strtotime("last day of september"));
                } elseif ($m > 9) {
                    $start = date("Y-m-d 00:00:00", strtotime("first day of october"));
                    $end = date("Y-m-d 23:59:59", strtotime("last day of december"));
                }

                $start = date('Y-m-d 00:00:00', strtotime("$addingQuarters month", strtotime($start)));
                $end = date('Y-m-d 23:59:59', strtotime("$addingQuarters month", strtotime($end)));

                $m = date('m', strtotime("this month $addingQuarters month"));
                $y = date('Y', strtotime("this month $addingQuarters month"));
                $periodText = date((floor(($m - 1) / 3) + 1)." кв. $y");

                break;
        }

        return [
            'start' => $start,
            'end' => $end,
            'periodText' => $periodText,
        ];
    }

    public function getPeriod($data, $shift) {
        $period = $data['period'];
        
        // Получение текущего периода
        $periodText = $this->formatMonth(date('M Y'));

        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-t 23:59:59');

        
        if ($period == 'other') {
            // Если выбран свой период
            $start = date('Y-m-d 00:00:00', strtotime($data['start-period-date']));
            $end = date('Y-m-d 23:59:59', strtotime($data['end-period-date']));
            $periodText = $this->formatMonth(date('d M - ', strtotime($start)).date('d M', strtotime($end)));
        } else {
            // Если выбран определенный период
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
        // Получение данных из пост-запроса
        $data = $req->all();

        if ($data) {
            // Если пост-запрос пришел, то сохраняем настройки в сессию
            session(['data' => $req->all()]);
        } else {
            // Иначе берем данные из сессии
            $data = session('data');
        }

        $periodText = $this->formatMonth(date('M Y'));

        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-t 23:59:59');
        $category = null;

        // Определение данных по умолчанию
        $nullComparison = $statistics ? '<' : '<>';
        $typeText = $statistics ? 'Расходы' : 'Доходы и расходы';

        $settings = [
            "period" => 'month',
            "category" => '0',
            "type" => ($statistics ? 'outcome' : 'all'),
            "start-period-date" => date("d.m.Y"),
            "end-period-date" => date("d.m.Y"),
        ];

        // Если данные так и не определены, то устанавливаем настройки по умолчанию
        if (!$data) {
            $data = $settings;
        }

        $errors = [];

        $period = $this->getPeriod($data, $shift);
        $start = $period['start'];
        $end = $period['end'];
        $periodText = $period['periodText'];

        // Поиск ошибок
        if (strtotime($start) > strtotime($end)) {
            $errors[] = 'Период не может заканчиваться раньше, чем начался';
        }

        // Определение настроек
        $data['category'] = isset($data["category-$data[type]"]) ? $data["category-$data[type]"] : "";
        $category = Category::find($data['category']);

        $nullComparison = $data['type'] == 'all' ? '<>' : ($data['type'] == 'income' ? '>' : '<');
        $typeText = $data['type'] == 'all' ? 'Доходы и расходы' : ($data['type'] == 'income' ? 'Доходы' : 'Расходы');

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
        
        // Получение всех данных настроек
        $filterData = $this->getFilterData($req);
        $start = $filterData['start'];
        $end = $filterData['end'];
        $errors = $filterData['errors'];
        $periodText = $filterData['periodText'];
        $typeText = $filterData['typeText'];
        $data = $filterData['data'];
        $category = $filterData['category'];
        $nullComparison = $filterData['nullComparison'];

        // Вывод ошибок
        if (!empty($errors) and !session()->get('errors')) {
            return redirect()->to(route('history-post'))->with(['errors' => $errors])->withErrors($errors);
        }

        // Получение транзакций
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

        // Вывод истории
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
        
        // Получени данных фильтра
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

        // Если мы производим непосредственного экспорт, то получаем транзакции
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
            // Добавление заголовков
            array_unshift($transactions, ['Сумма', 'Дата создания', 'Категория']);
            
            // Рассматриваем оба экспорта
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

    public function getGraphData($user, $start, $end, $nullComparison) {
        $start = DateTime::createFromFormat("Y-m-d H:i:s", $start);
        $end = DateTime::createFromFormat("Y-m-d H:i:s", $end);

        $interval = $start->diff($end)->format("%a");

        // Определение типов отображения
        $mode = "d";
        $modeName = "days";
        $modeText = "по дням";
        if ($interval > 31 and $interval <= 90) {
            $mode = "W";
            $modeName = "weeks";
            $modeText = "по неделям";
        } elseif ($interval > 90) {
            $mode = "m";
            $modeName = "month";
            $modeText = "по месяцам";
        }

        $start = $start->format("Y-m-d H:i:s");
        $end = $end->format("Y-m-d H:i:s");

        $sectors = [];
        $maxSum = 0;
        // Двигаемся по периоду, получаем транзакции и сохраняем их анные
        while ($start < $end) {
            $end1 = min($end, date('Y-m-d 00:00:00', strtotime("+ 1 $modeName", strtotime($start))));
            $transactions = Transaction::where('user_id', '=', $user->id)
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end1)
                ->where('sum', $nullComparison, '0')
                ->groupByRaw("category_id")
                ->selectRaw("abs(sum(sum)) as sum, category_id")
                ->get()
                ->toArray();

            $sum = 0;
            // Получение цвета категорий
            foreach ($transactions as $key => $trs) {
                $sum += $trs['sum'];
                $transactions[$key]['color'] = Category::find($trs['category_id'])->color;
            }
            
            $maxSum = max($maxSum, $sum);

            $sectors[] = [
                date($mode, strtotime($start)),
                $transactions,
                $sum
            ];
            $start = $end1;
        }

        $i = 0;
        if ($maxSum == 0) {
            $maxSum = 1;
        }
        // Вычисоение высоты и порядкового номера столбца
        foreach ($sectors as $key => $sector) {
            $sectors[$key] = [
                'number' => $sector[0],
                'height' => $sector[2] / $maxSum * 100,
                'transactions' => $sector[1],
                'sum' => $sector[2]
            ];
            $i += 1;
        }

        return [$sectors, $modeText, $maxSum];
    }

    public function getDiagramData($user, $start, $end, $nullComparison) {
        // Получение данных по категориям за период
        $transactions = Transaction::where('user_id', '=', $user->id)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->where('sum', $nullComparison, '0')
            ->groupBy('category_id')
            ->selectRaw('abs(sum(sum)) as sum, category_id')
            ->pluck('sum','category_id');

        $categories = [];
        $sum = array_sum($transactions->toArray());
        // Выбор цвета сектора, определение суммы, процента, названия категории
        foreach ($transactions as $category_id => $sectorSum) {
            $category = Category::find($category_id);
            $categories[] = [
                'color' => $category->color,
                'percent' => $sectorSum / $sum * 100,
                'sum' => $sectorSum,
                'name' => $category->name
            ];
        }

        // Определение секторов меньших 4%
        uasort($categories, function ($a, $b) { return $a['percent'] > $b['percent']; });
        $sectors = [];
        $fourthPercent = 0;
        $joinedCategories = 0;

        foreach ($categories as $category) {
            // Если процент категории меньше критического значения, обусловленного графическим видом диаграммы добавляем его значение к счетчику объединенных секторов
            if ($category['percent'] < 4) {
                $fourthPercent += $category['percent'];
                $joinedCategories += 1;

                // Если это первая категория, то создаем категорию как обычно
                if (empty($sectors)) {
                    $sectors[] = [
                        'color' => $category['color'],
                        'percent' => $category['percent'],
                    ];
                // Иначе перекрашиваем сектор в серый цвет, а в ее размер добавляем процент текущей категории
                } else {
                    $sectors[0]['percent'] = $fourthPercent;
                    $sectors[0]['color'] = '#ABABAB';
                }
            } else {
                $sectors[] = [
                    'color' => $category['color'],
                    'percent' => $category['percent'],
                ];
            }
        }
        // Группа категория "другое"
        $otherLevel = 0;
        // Расширение группы "другое" до 4%
        if ($fourthPercent > 0 and $fourthPercent < 4) {
            $compression = (100 - (4 - $fourthPercent)) / 100;
            $otherLevel = $joinedCategories > 1 ? count($sectors) - 1 : 0;
            for ($i = 1; $i < count($sectors); $i ++) {
                $sectors[$i]['percent'] *= $compression;
            }
            $sectors[0]['percent'] = 4;
        }

        // Сортировка категорий по возрастанию
        uasort($categories, function ($a, $b) { return $a['percent'] < $b['percent']; });
        uasort($sectors, function ($a, $b) { return $a['percent'] < $b['percent']; });
        return [$categories, $sectors, $sum, $otherLevel];
    }

    public function statistics(Request $req, $shift=0) {
        $user = User::find(Auth::user()->id);

        // Получение данных фильтра
        $filterData = $this->getFilterData($req, true, $shift);

        $start = $filterData['start'];
        $end = $filterData['end'];
        $errors = $filterData['errors'];
        $periodText = $filterData['periodText'];
        $typeText = $filterData['typeText'];
        $data = $filterData['data'];
        $nullComparison = $filterData['nullComparison'];

        // Получение данных для графика
        $graphData = $this->getGraphData($user, $start, $end, $nullComparison);
        $modeText = $graphData[1];
        $maxSum = $graphData[2];
        $sectors = $graphData[0];

        $indicators = [];
        $c = 4;
        for ($i = 0; $i < $c; $i ++) {
            $indicators[] = [(100 / ($c - 1)) * $i, TransactionController::formatSum($i / ($c - 1) * $maxSum)];
        }

        // Вывод ошибок
        if (!empty($errors) and !session()->get('errors')) {
            return redirect()->to(route('statistics-post'))->with(['errors' => $errors])->withErrors($errors);
        }

        // Получение данных для диаграммы
        $diagramData = $this->getDiagramData($user, $start, $end, $nullComparison);
        $sum = $diagramData[2];
        $diagramSectors = $diagramData[1];
        $otherLevel = $diagramData[3];
        $categories = $diagramData[0];

        // Вывод данных статистики
        return view('statistics', [
            'categories' => $categories,
            'sum' => TransactionController::formatSum($sum),
            'periodText' => $periodText,
            'typeText' => $typeText,
            'shift' => $shift,
            'settings' => $data,
            'sectors' => $sectors,
            'mode' => $modeText,
            'indicators' => $indicators,
            'diagramSectors' => $diagramSectors,
            'otherLevel' => $otherLevel,
        ]);
    }

    public function getCPI() {
        // Запрос к сайту investing.com и получение текущего индекса потребительских цен
        $url = 'https://ru.investing.com/economic-calendar/russian-cpi-1180';
        $ch = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        curl_close($ch);
        $releaseStr = '<span>Прогноз<div class="arial_14 noBold">';
        $start = strpos($html, $releaseStr) + strlen($releaseStr);
        $end = strpos($html, "%</div>", $start);

        $ICP = (float)(str_replace(",", ".", substr($html, $start, $end - $start)));

        // Возвращение коэффициента инфляции
        return 1 + ($ICP / 100);
    }

    public function getForecast($user) {

        // Определение месяца начала использования и текущего месяца
        $monthNumber = date('Y') * 12 + (int)date('m');
        $startUsingMonth = date('Y' , strtotime($user->created_at)) * 12 + (int)date('m' , strtotime($user->created_at));

        // Выбор транзакций за период
        $transactions = Transaction::where('user_id', '=', $user->id)
            ->where('sum', '<', '0')
            ->groupByRaw("Year(created_at) * 12 + Month(created_at)")
            ->selectRaw("abs(sum(sum)) as sum, (Year(created_at) * 12 +  Month(created_at)) AS month")
            ->pluck('sum','month');

        // Получение фактических трат за месяц
        $fact = isset($transactions[$monthNumber]) ? $transactions[$monthNumber] : 0;

        $i = 0;

        // Рассчет методом линейной регрессии
        $sX = 0; // Сумма месяцов с начала пользования
        $sY = 0; // Сумма трат за все время
        $sXY = 0; // Сумма произведений трат на месяц
        $sXSq = 0; // Сумма квадратов сроков
        $n = 0; // Количество месяцев

        for ($i = $startUsingMonth; $i < $monthNumber; $i ++) {
            $x = $i - $startUsingMonth + 1; // Перевод в относительные месяцы
            $y = isset($transactions[$i]) ? $transactions[$i] : 0;

            // Регистрация данных за месяц
            $sX += $x;
            $sY += $y;
            $sXY += $x * $y;
            $sXSq += $x * $x;
            $n += 1;
        }

        if ($n == 0) { // Если данных для прогноза не хватает, возвращаем прогноз -1
            return [$fact, -1];

        } elseif ($n == 1) { // В случае одного месяца сумма квадратов сроков будет равна квадрату суммы, так что для одного месяца просто возвращаем траты за последний месяц месяц 

            return [$fact, $sY];
        }
        // Нахождение общего определителя
        $det = $sXSq * $n - $sX * $sX;
        
        // Нахождение определителя для свободного члена
        $detA = $sXSq * $sY - $sX * $sXY;

        // Нахождение свободного члена
        $a = ($detA / $det);

        // Нахождение определителя коэффициента
        $detB = $sXY * $n - $sY * $sX;

        // Нахождение коэффициента
        $b = ($detB / $det);

        // Прогнозирование трат по формуле y = bx + a
        $forecast = ($monthNumber - $startUsingMonth) * $b + $a;


        return [$fact, max(0, $forecast)]; // Отсекаем значения меньше нуля, т.к. отрицательных расходов быть не может
    }

    public function forecast() {
        $user = User::find(Auth::user()->id);

        // Чтобы не совершать запросы к сайту при постоянном обновлении страницы, сохраняем текущие данные об ИПЦ в сессию
        if (session('cpi')) {
            $cpi = session('cpi'); 
        } else {
            $cpi = $this->getCPI();
            session(['cpi' => $cpi]);
        }
        $money = $user->money;
        
        // Рассчет текущего остатка с учетом инфляции на разные сроки
        $monthes = [
            '3' => TransactionController::formatSum($money * pow($cpi, 3 / 12)),
            '6' => TransactionController::formatSum($money * pow($cpi, 6 / 12)),
            '12' => TransactionController::formatSum($money * pow($cpi, 12 / 12)),
        ];

        $monthNumber = date('Y') * 12 + (int)date('m');
        $data = $this->getForecast($user);

        $fact = $data[0];
        $forecast = $data[1];

        $forecastIsset = $forecast != -1; // Если возвращенный прогноз равен -1, то данных для прогноза не хватает

        // Сравнение прогноза с реальными расходами
        $difference = $fact > $forecast ? 
            "Фактические траты выше прогноза на ".TransactionController::formatSum($fact - $forecast) : 
            "Фактические траты ниже прогноза на ".TransactionController::formatSum($forecast - $fact);

        // Форматирование названия месяца
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
            'forecastIsset' => $forecastIsset
        ]);
    }
}