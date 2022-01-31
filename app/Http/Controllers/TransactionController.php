<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    public function getCategories($type='') {
        if ($type != '') {
            $categories = Category::where('type', '=', $type)->get();
        } else {
            $categories = Category::get();
        }

        return $categories;
    }

    public function createTransaction(Request $req) {
        if (!Auth::check()) {
            return redirect()->to(route('main-get'));
        } else {
            $data = $req->all();

            if ($data['sum'] <= 0) {
                return redirect()->to(route('main-get'))->withErrors('form', 'Сумма должна быть больше 0'); 
            }

            $transaction = new Transaction();
            $transaction->sum = $data['type'] == 'outcome' ? -$data['sum'] : $data['sum'];
            $transaction->user_id = Auth::user()->id;
            $transaction->category_id = $data["category-$data[type]"];

            $transaction->save();

            $user = User::find(Auth::user()->id);
            $user->money = $user->money + $transaction->sum;
            $user->save();

            return redirect()->to(route('main-get'));
        }  
    }

    public static function formatSum($sum) {
        return number_format($sum, 2, ',', ' ')." ₽";
    }
}
