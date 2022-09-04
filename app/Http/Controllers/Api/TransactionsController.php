<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function transactions(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $query = Transaction::query();
            if ($request->from && $request->to) {
                $query->whereBetween('transaction_date', [$request->from, $request->to]);
            }
            if ($request->state_id) {
                $query->where('state_id', $request->state_id);
            }
            return response()->json(msgdata(success(), 'تم  بنجاح', $data));
        }
        return msgdata(not_authoize(), 'برجاء تسجيل الدخول', (object)[]);
    }
}
