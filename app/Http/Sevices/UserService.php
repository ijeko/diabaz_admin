<?php


namespace App\Http\Sevices;


use App\Factories\UserFactory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    public function EditUser($data)
    {
        $Factory = new UserFactory();
        $user = $Factory->make(User::class);
        if (!$this->validator($data)->fails()) {
            $validated = $this->validator($data)->validated();
            $newData = [
                'name' => $validated['name'],
                'role' => $validated['role'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ];
            $user->find($data['id'])
                ->update($newData);
        } else return $this->validator($data)->validate();
    }

    public function AddUser($data)
    {

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $Factory = new UserFactory();
        if (!$validator->fails()) {
            $newData = [
                'name' => $validator->validated()['name'],
                'role' => $validator->validated()['role'],
                'email' => $validator->validated()['email'],
                'password' => Hash::make($validator->validated()['password'])
            ];
            $user = $Factory->make(User::class, $newData);
            $user->save();
        } else return $validator->validated();
    }

    public function Delete ($data)
    {
        $Factory = new UserFactory();
        $user = $Factory->make(User::class)->find($data['id']);
        $user->delete();
    }
}
