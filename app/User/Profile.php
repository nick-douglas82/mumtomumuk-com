<?php
namespace App\User;

use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\CurrentMatchesPassword;
use App\Slug;


class Profile
{
    protected $response;

    protected $user;

    public function __construct($response)
    {
        $this->response = $response;
        $this->user     = Auth::user();
    }

    public function updateName($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|min:1',
        ]);

        $data['slug'] = Slug::create($data['name']);

        return $this->validate($validator, $data);
    }

    public function updateEmail($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);

        return $this->validate($validator, $data);
    }

    public function updatePassword($data)
    {
        if ( is_null($data['current']) && is_null($data['password']) && is_null($data['password_confirmation']) ) {
            return $this->response;
        }

        $validator = Validator::make($data, [
            'current'               => ['required', 'string', new CurrentMatchesPassword],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        if ( $validator->fails() ) {
            array_push($this->response['errors'], $validator->errors());
        }

        else {
            $this->user->password = Hash::make($data['password']);
            $this->user->save();
        }

        return $this->response;
    }

    private function validate($validator, $data)
    {
        if ( $validator->fails() ) {
            array_push($this->response['errors'], $validator->errors());
        }

        else {
            $this->user->update($data);
            $this->user->save();
        }

        return $this->response;
    }
}
