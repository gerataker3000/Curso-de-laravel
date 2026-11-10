<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumno;
use App\Repositories\AlumnoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Misma lógica que el controlador web, pero responde JSON.
 * Reutiliza el repositorio y los Form Requests.
 */
class AlumnoController extends Controller
{
    public function __construct(private AlumnoRepositoryInterface $alumnos) {}

    /**
     * GET /api/alumnos
     */
    public function index(): AnonymousResourceCollection
    {
        return AlumnoResource::collection($this->alumnos->paginar());
    }

    /**
     * POST /api/alumnos → 201 Created
     */
    public function store(StoreAlumnoRequest $request): JsonResponse
    {
        $alumno = $this->alumnos->crear($request->validated());

        return (new AlumnoResource($alumno))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * GET /api/alumnos/{alumno}
     */
    public function show(Alumno $alumno): AlumnoResource
    {
        return new AlumnoResource($alumno);
    }

    /**
     * PUT /api/alumnos/{alumno}
     */
    public function update(UpdateAlumnoRequest $request, Alumno $alumno): AlumnoResource
    {
        return new AlumnoResource($this->alumnos->actualizar($alumno, $request->validated()));
    }

    /**
     * DELETE /api/alumnos/{alumno} → 204 No Content
     */
    public function destroy(Alumno $alumno): Response
    {
        $this->alumnos->eliminar($alumno);

        return response()->noContent();
    }
}
