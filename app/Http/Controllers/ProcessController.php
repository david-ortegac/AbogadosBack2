<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Process;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

/**
 * Class ProcessController
 * @package App\Http\Controllers
 */
class ProcessController extends Controller
{
    /**
     * Consulta un proceso por su ID de manera publica
     *
     * @param string $processId
     * @return JsonResponse
     */
    public function getByIdPulic(string $processId): JsonResponse
    {
        $process = Process::where('processId', '=', $processId)
            ->where('status', '=', '1')
            ->get()->first();

        if (isset($process)) {
            unset($process->id);
            unset($process->userId);
            unset($process->pendingPayment);
            unset($process->validationKey);
            unset($process->status);
            unset($process->created_at);
            unset($process->updated_at);

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
     * Consulta los procesos en Intranet por tipo y numero de documento del usuario filtrado por ID del historial
     * organizado de manera descendente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByIdIntranet($documentType, $documentNumber): JsonResponse
    {
        $user = User::where('documentNumber', $documentNumber)
            ->where('documentType', $documentType)
            ->where('status', '1')
            ->first();

        if (isset($user)) {
            unset($user->bk);
            $process = Process::where('status', '1')->where('userId', $user->id)->orderBy('id', 'DESC')->get();

            foreach ($process as $p) {
                $p->history = History::where('processId', $p->id)->orderBy('id', 'DESC')->get();
            }

            $user->process = $process;

            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $user,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'No existen registros para retornar',
            ], Response::HTTP_NOT_FOUND);
        }

    }


    /**
     * Consulta los procesos en Intranet por tipo y numero de documento del usuario filtrado por ID del historial
     * organizado de manera descendente con paginacion
     *
     */
    public function getAll()
    {
        $user = User::where('status', '=', '1')->
        where('type', 'user')->paginate(20);

        foreach ($user as $u) {
            $u->process = Process::where('status', '1')->where('userId', $u->id)->get();
            foreach ($u->process as $p) {
                $p->history = History::where('processId', $p->id)->orderBy('id', 'DESC')->get();
            }
        }
        return $user;
    }


    /**
     * Consulta los procesos en Intranet por tipo y numero de documento del usuario filtrado por ID del historial
     * organizado de manera descendente sin paginacion
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllWithoutPagination(): \Illuminate\Support\Collection
    {
        $user = DB::table('users')
            ->join('processes', 'users.id', '=', 'processes.userId')
            ->select(
                'users.id',
                'users.documentType',
                'users.documentNumber',
                'users.nationality',
                'users.email',
                'users.bk as password',
                'users.name',
                'users.lastName',
                'processes.processId',
                'processes.applicationDate',
                'processes.pendingPayment',
                'processes.processTitle',
                'processes.processStatus',
                'processes.created_at as processCreated',
                'processes.updated_at as processUpdated'
            )
            ->get();

        return $user;
    }

    /**
     * Guarda un nuevo proceso y su primer registro del historial
     *
     * @param Request $request
     * @return JsonResponse
     */
    public
    function store(Request $request): JsonResponse
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

        //Guarda el historial del proceso
        $this->saveHistory($process);

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
     * Actualiza el proceso y guarda su historial
     *
     * @param Request $request
     * @return JsonResponse
     */
    public
    function update(Request $request): JsonResponse
    {
        $process = Process::find($request->id);
        $process->pendingPayment = $request->pendingPayment;
        $process->processTitle = $request->processTitle;
        $process->processStatus = $request->processStatus;
        $process->save();

        //Actualiza el historial del proceso
        $this->saveHistory($process);

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

    public
    function deactivateProcess($id): JsonResponse
    {
        $process = Process::find($id);

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

    function saveHistory(Process $request): History
    {
        $history = new History;
        $history->processId = $request->id;
        $history->applicationDate = $request->applicationDate;
        $history->processTitle = $request->processTitle;
        $history->processStatus = $request->processStatus;
        $history->save();
        return $history;
    }

}
