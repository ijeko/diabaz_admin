<?php

namespace App\Http\Controllers;

use App\Factories\UserFactory;
use App\Http\Sevices\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->service = new UserService();
    }

    //
    public function GetList()
    {

        $Factory = new UserFactory();
//        dd(__METHOD__, $Factory->make(User::class));
        return $Factory->make(User::class)->get();
    }

    public function EditUser(Request $request)
    {
        return $this->service->EditUser(json_decode($request->data, 1));
    }

    public function AddUser(Request $request)
    {
        return $this->service->AddUser(json_decode($request->data, 1));
    }

    public function DeleteUser (Request $request)
    {
        return $this->service->Delete(['id' => $request->id]);
    }
}
