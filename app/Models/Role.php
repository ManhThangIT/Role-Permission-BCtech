<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustRole;


class Role extends LaratrustRole
{
    use SoftDeletes;

    public $table = 'roles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public static function rules($id = 0) {
        return [
            'name'              => 'required|max:50|not_in:system|regex:/^[a-zA-Z0-9_]+([-.][a-zA-Z0-9_]+)*$/|unique:roles,name' . ($id == 0 ? '' : ',' . $id),
            'display_name'      => 'required|max:50',
            'description'       => 'max:255',
            'permissions'       => 'required'
        ];
    }


    public $fillable = [
        'name',
        'display_name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'display_name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'permission_role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function roleUsers()
    {
        return $this->hasMany(\App\Models\RoleUser::class);
    }
}
