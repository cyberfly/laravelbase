<?php

namespace App\Http\Requests\Admin;

use App\Models\SpatiePermission\WebRole;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
        $role = new WebRole();
        $role_table = $role->getTable();

        return [
            'name' => "required|unique:$role_table,name,NULL,id,guard_name,web",
            'display_name' => "required",
            'description' => "required",
            'permissions' => 'required|array',
            'permissions.*' => 'required|numeric',
        ];
    }
}
