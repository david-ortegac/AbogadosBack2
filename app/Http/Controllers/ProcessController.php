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
     * @param  string $processId
     * @return JsonResponse
     */
    public function getByIdPulic($processId)
    {
        $process = Process::where('processId', '=', $processId)
            ->where('status', '=', '1')
            ->get();

        if ($process->count() > 0) {
            foreach ($process as $p) {
                unset($p->id);
                unset($p->userId);
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
     * @param  string $documentType
     * @param  int $documentNumber
     * @return JsonResponse
     */
    public function getByIdIntranet(Request $request)
    {
        $user = User::where('documentNumber', '=', $request->documentNumber)
            ->where('documentType', '=', $request->documentType)
            ->where('status', '=', '1')
            ->first();

        if (isset($user)) {

            $process = Process::where('userId', $user->id)->get();

            $user->process = $process;

            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $user,
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
        $user = User::where('status', '=', '1')->paginate(20);

        foreach ($user as $u) {
            $u->process = Process::where('userId', $u->id)->get();
        }
        return $user;

    }

    public function getAllWithoutPagination()
    {
        $user = User::all();
        foreach ($user as $u) {
            $u->process = Process::where('userId', $u->id)->get();
        }
        return response()->json($user);
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
        $process->userId = $request->userId;
        $process->processId = $request->processId;
        $process->applicationDate = $request->applicationDate;
        $process->pendingPayment = $request->pendingPayment;
        $process->processTitle = $request->processTitle;
        $process->processStatus = $request->processStatus;
        $process->status = $request->status;

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
    public function update(Request $request)
    {
        $process = Process::find($request->id);

        if ($request->pendingPayment != null) {
            $process->pendingPayment = $request->pendingPayment;
        }
        if ($request->processTitle != null) {
            $process->processTitle = $request->processTitle;
        }
        if ($request->processStatus != null) {
            $process->processStatus = $request->processStatus;
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

    public function deactivateProcess(Request $request)
    {
        $process = Process::find($request->id);

        if (isset($process)) {
            $process->status = 0;
            $process->save();
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
