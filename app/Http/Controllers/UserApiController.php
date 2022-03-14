<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{

    /**
     * @return string
     */
    public function index(): string
    {
        $feeds = User::all()->where('deleted_at', 'IS', null);
        return $feeds->toJson();
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function store(Request $request): bool|string
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return json_encode(['Request not valid!']);
        }

        if (User::firstWhere('email', $request->email)) {
            return json_encode(['User already exists!']);
        }

        try {
            User::create($validator->validated());
            return json_encode(['User Created']);
        } catch (\Exception $e) {
            return json_encode(['There was an error!']);
        }
    }


    /**
     * @param $id
     * @param Request $request
     * @return false|string
     */
    public function update($id, Request $request): bool|string
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return json_encode(['Request not valid!']);
        }

        $uniqueUserCheck = User::firstWhere('email', $request->email);

        if (null !== $uniqueUserCheck && $uniqueUserCheck->id !== $user->id) {
            return json_encode(['User email already exists!']);
        }

        try {
            $user->fill($validator->validated())->save();
            return json_encode(['User Updated']);
        } catch (\Exception $e) {
            return json_encode(['There was an error!']);
        }
    }


    /**
     * @param $id
     * @return false|string
     */
    public function delete($id): bool|string
    {
        $user = User::findOrFail($id);

        try {
            $user->deleted_at = new \DateTime('now');
            $user->save();

            return json_encode(['User Deleted']);
        } catch (\Exception $e) {
            return json_encode(['There was an error!']);
        }
    }


    /**
     * @param $id
     * @return string
     */
    public function show($id): string
    {
        $user = User::findOrFail($id);
        return $user->toJson();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function workEntries($userId)
    {
        $user = User::findOrFail($userId);

        //Defined in model relationship
        $workEntries = $user->entries;

        return $workEntries->toJson();
    }

}
