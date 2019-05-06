<?php
/**
 * Created by PhpStorm.
 * User: roshani
 * Date: 6/5/19
 * Time: 11:00 PM
 */

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;


class UserController extends Controller
{
    public function login(Request $request) {
        try {
            $response = array();
            $result = array();

            $username = trim($request->input("username"));
            $password = $request->input("password");
            print_r($username);
            exit();
            $validatedData = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($validatedData->fails()) {
                $response = array();
                $response['code'] = 201;
                $response['content'] = $validatedData->errors();

                return response($response, $response['code'])
                    ->header('content-type', 'application/json');
            }
            if (isset($username) && $password) {
                $userCheck = User::where("username", '=', $username)->first();

                if (isset($userCheck)) {
                    if ($userCheck->password = Hash::make($password)) {
                        $response['code'] = 200;
                        $response['message'] = 'success';
                        $response['content'] = 'success';
                    } else {
                        $response['code'] = 400;
                        $response['message'] = 'error';
                        $response['content'] = "There is Some Error in login";
                    }
                }
            }
        } catch (\Exception $e) {
            $response['code'] = 400;
            $response['message'] = 'error';
            $response['content'] = $e->getMessage();
        }
        return response($response, $response['code'])
            ->header('content_type', 'appication/json');
    }
}