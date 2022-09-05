<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\State;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class ReportsController extends Controller
{

    public function with_state(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $rule = [
                'state_id' => 'required|exists:states,id',
                'from' => 'required',
                'to' => 'required|after_or_equal:' . $request->from,
            ];
            $validate = Validator::make($request->all(), $rule);
            if ($validate->fails()) {
                return response()->json(msg(failed(), $validate->messages()->first()));
            }

            $data['sum_price_private_transport'] = Transaction::where('state_id',$request->state_id)->whereBetween('created_at', [$request->from, $request->to])->sum('price_private_transport');
            $data['sum_price_taxi_motorbike'] = Transaction::where('state_id',$request->state_id)->whereBetween('created_at', [$request->from, $request->to])->sum('price_taxi_motorbike');
            $data['sum_price_private_without_exam'] = Transaction::where('state_id',$request->state_id)->whereBetween('created_at', [$request->from, $request->to])->sum('price_private_without_exam');
            $data['sum_price_permissions_data'] = Transaction::where('state_id',$request->state_id)->whereBetween('created_at', [$request->from, $request->to])->sum('price_permissions_data');
            $data['sum_price_driving'] = Transaction::where('state_id',$request->state_id)->whereBetween('created_at', [$request->from, $request->to])->sum('price_driving');
            $data['total'] = $data['sum_price_private_transport'] + $data['sum_price_taxi_motorbike'] + $data['sum_price_private_without_exam'] + $data['sum_price_permissions_data'] + $data['sum_price_driving'] ;

            $state = State::findOrFail($request->state_id);
            $pdf = PDF::loadView('StateReport', ['data' => $data,'state'=>$state,'from'=>$request->from , 'to'=>$request->to]);
            $num = rand(1000, 9999);
            $pdf->save(public_path() . '/reports/' . $num . '.pdf');

            return response()->json(msgdata(success(), trans('lang.success'), env('APP_URL')  .'/reports/'.$num.'.pdf'));
        } else {
            return msgdata(failed(), trans('lang.not_authorized'), (object)[]);
        }
    }
}
