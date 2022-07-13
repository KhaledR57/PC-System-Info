<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\Computer as ComputerResource;
use App\Models\Computer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComputerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $computers = Computer::all();
        return $this->sendResponse(ComputerResource::collection($computers), 'Computers fetched.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = $this->getValidationFactory()
            ->make($request->all(), [
                'os_name' => 'required',
                'os_version' => 'required',
                'proc_info' => 'required',
                'gpu_info' => 'required',
                'disk_info' => 'required',
                'system_ram' => 'required',
                'model_info' => 'required',
                'hash' => 'required',
                'created_by' => 'required',
                'serial' => 'required|unique:computers',
            ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $computer = new Computer($input);
        $computer->save();
        return $this->sendResponse(new ComputerResource($computer), 'Computer created.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $computer = Computer::find($id);
        if (is_null($computer)) {
            return $this->sendError('Computer does not exist.');
        }
        return $this->sendResponse(new ComputerResource($computer), 'Computer fetched.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $input = $request->all();
        $validator = $this->getValidationFactory()
            ->make($request->all(), [
                'os_name' => 'required',
                'os_version' => 'required',
                'proc_info' => 'required',
                'gpu_info' => 'required',
                'disk_info' => 'required',
                'system_ram' => 'required',
                'model_info' => 'required',
                'hash' => 'required',
                'created_by' => 'required',
                'serial' => 'required|unique:computers',
            ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $computer = Computer::find($id);
        $computer->fill($input);
        $computer->save();
        return $this->sendResponse(new ComputerResource($computer), 'Computer updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Computer $computer
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Computer $computer)
    {
        $computer->delete();
        return $this->sendResponse([], 'Computer deleted.');
    }
}
