<?php

namespace Geekflix\Http\Requests;


use Geekflix\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            //'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * Store user in request  to the database
     *
     * @return redirect()
     */

    public function storeUser()
    {
        $user = User::create([
            'name' => $this->name,
            'username' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);

        $user->save();

        session()->flash('success', 'User created successfully.');

        return redirect()->route('users.show', $user->slug);
    }
}
