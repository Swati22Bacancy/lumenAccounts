<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\CommonHelper;

class AccountController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $accounts = Account::all();
        return $this->successResponse($accounts);
    }

    //Create new account
    public function store(Request $request)
    {
        $rules = [
            'customer_id' => 'required|min:1',
            'currency' => 'required|max:10',
            'amount' => 'required|min:1',
            'crdb' => 'required|max:10',
            'description' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $account = Account::create($request->all());

        return $this->successResponse($account, Response::HTTP_CREATED);
    }

    //Show the account
    public function show($account)
    {
        $account = Account::findOrFail($account);

        return $this->successResponse($account);
    }

    //Update the account
    public function updateaccount(Request $request, $account)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required',
        ];

        $this->validate($request, $rules);

        $account = Account::findOrFail($account);

        $account->fill($request->all());

        if ($account->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $account->save();

        return $this->successResponse($account);
    }

    //Remove the account
    public function destroy($account)
    {
        $account = Account::findOrFail($account);

        $account->delete();

        return $this->successResponse($account);
    }

    public function accountCommonFunction()
    {
        $randomString = CommonHelper::generateRandomString(8);
        return $this->successResponse($randomString);
    }
}
