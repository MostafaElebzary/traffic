<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    public function transactions(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $query = Transaction::query();
            if ($request->from && $request->to) {
                $query = $query->whereBetween('transaction_date', [$request->from, $request->to]);
            }
            if ($request->state_id) {
                $query = $query->where('state_id', $request->state_id);
            }

            $query = $query->orderBy('id', 'desc')->paginate(10);

            $data = TransactionResource::collection($query)->response()->getData(true);

            return response()->json(msgdata(success(), 'تم  بنجاح', $data));
        }
        return msgdata(not_authoize(), 'برجاء تسجيل الدخول', (object)[]);
    }

    public function AddTransaction(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $rule = [
                'transaction_date' => 'required|date',
                'state_id' => 'required|exists:states,id',
                'num_private_transport' => 'required|numeric',
                'price_private_transport' => 'required|numeric',
                'num_taxi_motorbike' => 'required|numeric',
                'price_taxi_motorbike' => 'required|numeric',
                'num_private_without_exam' => 'required|numeric',
                'price_private_without_exam' => 'required|numeric',
                'num_permissions_data' => 'required|numeric',
                'price_permissions_data' => 'required|numeric',
                'num_driving' => 'required|numeric',
                'price_driving' => 'required|numeric',
                'expenses' => 'nullable|numeric',
                'num_license' => 'nullable|numeric',
                'price_license' => 'nullable|numeric',
                'num_extinguisher' => 'nullable|numeric',
                'price_extinguisher' => 'nullable|numeric',
                'num_internet_card' => 'nullable|numeric',
                'price_internet_card' => 'nullable|numeric',


            ];

            $validate = Validator::make($request->all(), $rule);
            if ($validate->fails()) {
                return response()->json(msg(failed(), $validate->messages()->first()));
            }
            $is_exists = Transaction::where('state_id', $request->state_id)
                ->where('transaction_date', $request->transaction_date)
                ->first();
            if ($is_exists) {
                return msgdata(failed(), "يوجد عمليه بهذا التاريخ لهذا المركز!", (object)[]);
            }
            $data = Transaction::create($validate->validated());
            $data = new TransactionResource($data);

            return response()->json(msgdata(success(), trans('lang.success'), $data));
        } else {
            return msgdata(failed(), trans('lang.not_authorized'), (object)[]);
        }
    }

    public function EditTransaction(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $rule = [
                'transaction_date' => 'required|date',
                'state_id' => 'required|exists:states,id',
                'num_private_transport' => 'required|numeric',
                'price_private_transport' => 'required|numeric',
                'num_taxi_motorbike' => 'required|numeric',
                'price_taxi_motorbike' => 'required|numeric',
                'num_private_without_exam' => 'required|numeric',
                'price_private_without_exam' => 'required|numeric',
                'num_permissions_data' => 'required|numeric',
                'price_permissions_data' => 'required|numeric',
                'num_driving' => 'required|numeric',
                'price_driving' => 'required|numeric',
                'expenses' => 'nullable|numeric',
                'id' => 'required|exists:transactions,id',
                'num_license' => 'nullable|numeric',
                'price_license' => 'nullable|numeric',
                'num_extinguisher' => 'nullable|numeric',
                'price_extinguisher' => 'nullable|numeric',
                'num_internet_card' => 'nullable|numeric',
                'price_internet_card' => 'nullable|numeric',

            ];

            $validate = Validator::make($request->all(), $rule);
            if ($validate->fails()) {
                return response()->json(msg(failed(), $validate->messages()->first()));
            }

            $data = Transaction::where('id', $request->id)->update($validate->validated());

            $data = Transaction::whereId($request->id)->first();
            $data = new TransactionResource($data);

            return response()->json(msgdata(success(), trans('lang.success'), $data));
        } else {
            return msgdata(failed(), trans('lang.not_authorized'), (object)[]);
        }
    }

    public function deleteTransaction(Request $request, $id)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $data = Transaction::where('id', $id)->first();
            if (!$data) {
                return msgdata(not_found(), "العملية غير موجودة", (object)[]);
            }
            $data->delete();
            return response()->json(msgdata(success(), trans('lang.success'), (object)[]));
        } else {
            return msgdata(failed(), trans('lang.not_authorized'), (object)[]);
        }
    }

}
