<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();

        if (isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']);
        }

        $test = Test::findOrFail('user_id', $user->id);

        if (isset($test)) {

            if (isset($request->test_administration)) {
                $test->test_administration = $request->test_administration;
            }
            if (isset($request->tested_on)) {
                $test->tested_on = $request->tested_on;
            }
            if (isset($request->record_locater)) {
                $test->record_locater = $request->record_locater;
            }
            if (isset($request->total_score)) {
                $test->total_score = $request->total_score;
            }

            $test->save();
        }

        $user->update($input);
        $user->save();

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $user
        ]);
    }


    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['api_token'] =  $user->createToken('MyApp')->plainTextToken;

            return response()->json([
                "success" => true,
                "status" => 200,
                "data" => [
                    "user" => $user,
                    "api_token" => $success['api_token']
                ]
            ]);
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $input['role'] = "admin";

        $user = User::create($input);
        $user->save();
        $success['api_token'] =  $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "user" => $user,
                "api_token" => $success['api_token']
            ]
        ]);
    }

    public function verify_token(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->api_token);
        if (!$token) {
            return response()->json(
                [
                    'success' => false,
                    'status' => 404,
                    'message' => 'Not Found'
                ],
                404
            );
        }
        $user = $token->tokenable;

        if ($user == null) {
            return response()->json(
                [
                    'success' => false,
                    'status' => 404,
                    'message' => 'Not Found'
                ],
                404
            );
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "user" => $user,
                "api_token" => $request->api_token
            ]
        ]);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function create_users(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'grade' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $input['role'] = "student";
        $user = User::create($input);
        $user->save();

        $test = new Test;

        $test->user_id = $user->id;


        if (isset($request->test_administration)) {
            $test->test_administration = $request->test_administration;
        }
        if (isset($request->tested_on)) {
            $test->tested_on = $request->tested_on;
        }
        if (isset($request->record_locater)) {
            $test->record_locater = $request->record_locater;
        }
        if (isset($request->total_score)) {
            $test->total_score = $request->total_score;
        }

        $test->save();

        $success['api_token'] =  $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [

                "user" => $user,
                "api_token" => $success['api_token']
            ]

        ]);
    }
}
