<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateResource;
use App\Http\Resources\UserResource;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $rule = [
            'phone' => 'required',
            'password' => 'required|min:6',
        ];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return response()->json(msgdata(failed(), $validate->messages()->first(), (object)[]));
        } else {
            $credentials = $request->only(['phone', 'password']);
            $token = Auth::attempt($credentials);
            //return token
            if (!$token) {
                return msgdata(not_authoize(), 'رقم الهاتف او كلمه المرور خاطئة', (object)[]);
            }
            $user = Auth::user();
            User::where('id', $user->id)->update(['jwt' => Str::random(60)]);
            $user = User::whereId($user->id)->first();
            $data = new UserResource($user);

            return response()->json(msgdata(success(), 'تم الدخول بنجاح', $data));
        }
    }

    public function updateProfile(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $rule = [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'nullable|email',
                'password' => 'nullable|confirmed|min:6',
            ];
            $validate = Validator::make($request->all(), $rule);
            if ($validate->fails()) {
                return response()->json(msgdata(failed(), $validate->messages()->first(), (object)[]));
            } else {

                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->phone = $request->phone;
                $user->jwt = Str::random(60);
                if ($request->password) {
                    $user->password = $request->password;
                }
                if ($request->email) {
                    $user->email = $request->email;
                }
                $user->save();
                $data = new UserResource($user);
                return response()->json(msgdata(success(), 'تم التعديل بنجاح', $data));
            }
        } else {
            return msgdata(not_authoize(), 'برجاء تسجيل الدخول', (object)[]);
        }
    }

    public function states(Request $request)
    {
        $jwt = ($request->hasHeader('jwt') ? $request->header('jwt') : "");
        $user = check_jwt($jwt);
        if ($user) {
            $state = State::orderBy('id', 'asc')->get();
            $data = StateResource::collection($state);
            return response()->json(msgdata(success(), 'تم  بنجاح', $data));
        }
        return msgdata(not_authoize(), 'برجاء تسجيل الدخول', (object)[]);
    }
}
