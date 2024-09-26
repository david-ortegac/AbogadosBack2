<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProcessController
 * @package App\Http\Controllers
 */
class ProcessController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function getByIdPulic($processId)
    {
        $process = Process::where('processId', '=', $processId)
            ->where('status', '=', '1')
            ->get();

        if ($process->count() > 0) {
            foreach($process as $p){
                unset($p->id);
                unset($p->pendingPayment);
                unset($p->validationKey);
                unset($p->status);
                unset($p->created_at);
                unset($p->updated_at);
            }
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $process,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => 'No existen registros para retornar',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function getByIdIntranet($documentType, $documentNumber)
    {
        $process = User::where('documentNumber', '=', $documentNumber)
            ->where('documentType', '=', $documentType)
            ->where('status', '=', '1')
            ->get();

        if ($process->count() > 0) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $process,
            ]);
        } else {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => 'No existen registros para retornar',
            ]);
        }

    }

    public function getAll()
    {
        $process = Process::where('status', '=', '1')->paginate(20);

        if ($process->count() > 0) {
            return $process;
        } else {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => 'No existen registros para retornar',
            ]);
        }

    }

    public function getAllWithoutPagination()
    {
        $process = Process::all();
        return response()->json($process);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->input(), Process::$rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->all(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $process = new Process;
        $process->processId = $request->processId;
        $process->documentType = $request->documentType;
        $process->documentNumber = $request->documentNumber;
        $process->name = $request->name;
        $process->lastName = $request->lastName;
        $process->nationality = $request->nationality;
        $process->applicationDate = $request->applicationDate;
        $process->pendingPayment = $request->pendingPayment;
        $process->processTitle = $request->processTitle;
        $process->processStatus = $request->processStatus;
        $process->status = 1;
        $process->Link = $request->Link;
        $process->validationKey = rand(1000, 9999);

        $process->save();

        if (isset($process)) {
            return response()->json([
                'status' => 201,
                'data' => $process,
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'status' => 400,
                'data' => 'Error al guardar',
            ], Response::HTTP_BAD_REQUEST);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Process $process
     * @return JsonResponse
     */
    public function update(Request $request, Process $process)
    {
        $process = Process::find($request->id);

        if ($request->processId != null) {
            $process->processId = $request->processId;
        }
        if ($request->documentType != null) {
            $process->documentType = $request->documentType;
        }
        if ($request->documentNumber != null) {
            $process->documentNumber = $request->documentNumber;
        }
        if ($request->name != null) {
            $process->name = $request->name;
        }
        if ($request->lastName != null) {
            $process->lastName = $request->lastName;
        }
        if ($request->nationality != null) {
            $process->nationality = $request->nationality;
        }
        if ($request->applicationDate != null) {
            $process->applicationDate = $request->applicationDate;
        }
        if ($request->pendingPayment != null) {
            $process->pendingPayment = $request->pendingPayment;
        }
        if ($request->processTitle != null) {
            $process->processTitle = $request->processTitle;
        }
        if ($request->processStatus != null) {
            $process->processStatus = $request->processStatus;
        }
        if ($request->status != null) {
            $process->status = $request->status;
        }
        if ($request->Link != null) {
            $process->Link = $request->Link;
        }

        $process->save();

        if ($process->count() > 0) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $process,
            ]);
        } else {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => 'Error al actualizar, validar datos enviados!',
            ]);
        }

    }

    public function deactivate(Request $request)
    {
        $process = Process::find($request->id);

        $process->status = 0;
        $process->save();

        if ($process->count() > 0) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $process,
            ]);
        } else {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => 'No existen registros para retornar',
            ]);
        }

    }

}
