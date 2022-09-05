<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function branchAccountReportInbox(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        if ($jwt != "") {
            $user = checkJWT($jwt);
            if ($user) {

                $rules =
                    [
                        'from' => 'required|date',
                        'to' => 'required|date',
                        'branch_id' => 'required|exists:branches,id'

                    ];


                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['status' => 401, 'msg' => $validator->messages()
                        ->first(), 'data' => (object)[]]);
                }

                $branch_irregularities = BranchIrregularity::where('branch_id', $request->branch_id)
                    ->where('status', 'approved')
                    ->whereBetween('created_at', [$request->from, $request->to])
                    ->orderBy('id', 'desc')
                    ->with('irregularity_settlement')
                    ->with('employee')
                    ->get();

                $total = $branch_irregularities->sum('value');
                $total_paid = $branch_irregularities->where('type', 'paid')->sum('value');

                $branch = Branch::whereId($request->branch_id)->first();


                $data['branch_irregularities'] = $branch_irregularities;

                $data['branch'] = $branch;


                $data['debit'] = $total;
                $data['creditor'] = $total_paid;
                $data['total_debit'] = $total - $total_paid;
                $data['total_creditor'] = 0;


                $pdf = PDF::loadView('branchAccountReport', $data);
                $num = rand(1000, 9999);
                $pdf->save(public_path() . '/uploads/clients/' . $num . '.pdf');

                $file = $num . '.pdf';
                $input['message'] = 'كشف حساب فرع';
                $input['reciever_id'] = $branch->user_id;
                $input['branch_id'] = $request->branch_id;
                $input['sender_id'] = $user->id;
                $input['file'] = $file;
                $data = Inbox::create($input);
                InboxFile::create([
                    'inbox_id' => $data->id,
                    'file' => $file
                ]);

                return msgdata($request, success(), 'success', $data);

            } else {
                return response()->json(msgdata($request, not_authoize(), 'invalid_data', (object)[]));

            }
        } else {
            return response()->json(msgdata($request, not_authoize(), 'invalid_data', (object)[]));

        }
    }
}
