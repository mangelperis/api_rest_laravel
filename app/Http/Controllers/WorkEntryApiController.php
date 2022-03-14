<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkEntryApiController extends Controller
{

    /**
     * @param Request $request
     * @return bool|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): bool|string
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return json_encode(['Request not valid!']);
        }

        if (!User::firstWhere('id', $request->user_id)) {
            return json_encode(['User not found']);
        }

        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');


        if (null !== $endDate && $endDate < $startDate) {
            return json_encode(['Error : Param `end_date` cant be minor than `start_date` value']);
        } else {
            $values = array_merge(['end_date' => $endDate], $validator->validated());
        }

        try {
            WorkEntry::create($values);
            return json_encode(['WorkEntry Created']);
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
        $workEntry = WorkEntry::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'end_date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return json_encode(['Request not valid!']);
        }

        $endDate = $request->get('end_date');

        if ($endDate < $workEntry->start_date) {
            return json_encode(['Error : Param `end_date` cant be minor than `start_date` value']);
        }

        try {
            $workEntry->fill($validator->validated())->save();
            return json_encode(['WorkEntry Updated']);
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
        $workEntry = WorkEntry::findOrFail($id);

        try {
            $workEntry->deleted_at = new \DateTime('now');
            $workEntry->save();

            return json_encode(['WorkEntry Deleted']);
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
        $workEntry = WorkEntry::findOrFail($id);

        $user = User::find($workEntry->user_id);

        $workEntry->user_name = $user->name;

        return $workEntry->toJson();
    }
}
