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
                'type' => 'nullable|in:private_transport,taxi_motorbike,private_without_exam,permissions_data,driving,expenses,license,internet_card,extinguisher'
            ];
            $validate = Validator::make($request->all(), $rule);
            if ($validate->fails()) {
                return response()->json(msg(failed(), $validate->messages()->first()));
            }

            $data['sum_price_private_transport'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->sum('price_private_transport');
            $data['sum_price_taxi_motorbike'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->sum('price_taxi_motorbike');
            $data['sum_price_private_without_exam'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->sum('price_private_without_exam');
            $data['sum_price_permissions_data'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->sum('price_permissions_data');
            $data['sum_price_driving'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->sum('price_driving');
            $data['sum_price_license'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->sum('price_license');
            $data['sum_price_extinguisher'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->sum('price_extinguisher');
            $data['sum_price_internet_card'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->sum('price_internet_card');
            $data['total'] = $data['sum_price_private_transport'] + $data['sum_price_taxi_motorbike'] +
                $data['sum_price_private_without_exam'] + $data['sum_price_permissions_data'] +
                $data['sum_price_driving'] + $data['sum_price_license'] +
                $data['sum_price_extinguisher'] + $data['sum_price_internet_card'];

            $data['all_rows'] = Transaction::where('state_id', $request->state_id)->whereBetween('transaction_date', [$request->from, $request->to])->orderBy('transaction_date', 'asc')->get();

//            select column on requested type
            $state = State::findOrFail($request->state_id);
            $pdf = PDF::loadView('StateReport', ['data' => $data, 'state' => $state, 'from' => $request->from, 'to' => $request->to, 'type' => $request->type]);
            $name = rand(1000, 9999) . time() . '.pdf';
            $pdf->save(public_path() . '/reports/' . $name);

            return response()->json(msgdata(success(), trans('lang.success'), url('/') . '/reports/' . $name));
        } else {
            return msgdata(failed(), trans('lang.not_authorized'), (object)[]);
        }
    }

    public function without_state(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $rule = [
                'from' => 'required',
                'to' => 'required|after_or_equal:' . $request->from,
            ];
            $validate = Validator::make($request->all(), $rule);
            if ($validate->fails()) {
                return response()->json(msg(failed(), $validate->messages()->first()));
            }

            $data['sum_price_private_transport'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->sum('price_private_transport');
            $data['sum_price_taxi_motorbike'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->sum('price_taxi_motorbike');
            $data['sum_price_private_without_exam'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->sum('price_private_without_exam');
            $data['sum_price_permissions_data'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->sum('price_permissions_data');
            $data['sum_price_driving'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->sum('price_driving');
            $data['sum_price_license'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->sum('price_license');
            $data['sum_price_extinguisher'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->sum('price_extinguisher');
            $data['sum_price_internet_card'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->sum('price_internet_card');
            $data['total'] = $data['sum_price_private_transport'] + $data['sum_price_taxi_motorbike'] +
                $data['sum_price_private_without_exam'] + $data['sum_price_permissions_data'] +
                $data['sum_price_driving'] + $data['sum_price_license'] + $data['sum_price_extinguisher'] +
                $data['sum_price_internet_card'];
            $data['all_rows'] = Transaction::whereBetween('transaction_date', [$request->from, $request->to])->orderBy('transaction_date', 'asc')->get();

            $pdf = PDF::loadView('Report', ['data' => $data, 'from' => $request->from, 'to' => $request->to]);
            $name = rand(1000, 9999) . time() . '.pdf';
            $pdf->save(public_path() . '/reports/' . $name);
            return response()->json(msgdata(success(), trans('lang.success'), url('/') . '/reports/' . $name));
        } else {
            return msgdata(failed(), trans('lang.not_authorized'), (object)[]);
        }
    }
}
