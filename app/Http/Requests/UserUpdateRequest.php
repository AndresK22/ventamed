<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
        //dd($this->route->parameter('user'));
    }

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            //Rule::unique('users', 'email')->ignore($this->route->parameter('user')),
            //'email' => 'required|email|string|unique:users,email,'.$this->route->parameter('user'),
            'email' => 'required|email|string|unique:users,email,'.$this->route->parameter('user').'id',
            'rol' => 'required|string',
        ];
    }
}