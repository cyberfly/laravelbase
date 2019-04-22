<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Resources\Common\UserResource;
use App\User;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    protected $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    /**
     * Get subcategories by category_id
     * @param Request $request
     * @return UserResource
     */
    public function getUsers(Request $request)
    {
        $users = $this->user
            ->get();

        return new UserResource($users);
    }
}
