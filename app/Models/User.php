<?php


namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable // implements UserInterface, RemindableInterface
{
    use LaratrustUserTrait; // add this trait to your user model HasRole,
    use Notifiable;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public static function rules($id = 0) {
        return [
            'email'             => 'required|max:50|min:10|email|unique:users,email' . ($id == 0 ? '' : ',' . $id),
            'name'          => 'required|max:50',
            'password'          => 'max:20|min:6' . ($id == 0 ? '|required' : ''),
            're_password'       => 'same:password',
            'roles'             => 'required',
        ];
    }



    public $fillable = [
        'name',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required'
    ];

    
}
