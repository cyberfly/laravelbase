<?php

namespace App\Http\Controllers\Example;

use App\Filters\Common\UserFilter;
use App\Http\Requests\Example\StoreMultiFormRequest;
use App\Http\Resources\Example\VuePaginationResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VuePaginationController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('examples.vuepaginations.index');
    }

    /**
     * Example data for Vue Pagination axios request
     * @param UserFilter $filter
     * @return VuePaginationResource
     * @internal param Request $request
     */
    public function getUsers(UserFilter $filter)
    {
        $users = $this->user
            ->filter($filter)
            ->paginate(5);

        return new VuePaginationResource($users);
    }
}
