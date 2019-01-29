<?php

namespace App\Http\Controllers\Example;

use App\Http\Requests\Example\StoreMultiFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MultiFormController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $users = [
            [
                'name' => 'Sample 1',
                'ic' => '8108080101a',
                'email' => 'sample@gmail.test',
                'phone' => '012345567',
            ],
            [
                'name' => 'Sample 2',
                'ic' => '8208080202a',
                'email' => 'sample2@gmail.test',
                'phone' => '012345555',
            ],
        ];

        return view('examples/multiforms/create', compact('users'));
    }

    /**
     * @param StoreMultiFormRequest $request
     * @return bool
     */
    public function store(StoreMultiFormRequest $request)
    {
        if ($request->filled('users')) {

            foreach ($request->users as $user) {

                // do something with the data

            }

        }

        return response()->json(['message' => 'success'], 200);
    }
}
