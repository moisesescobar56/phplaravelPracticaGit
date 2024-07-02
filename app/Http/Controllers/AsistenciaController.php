<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\EstudianteGrupo;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Carbon\Carbon; // fecha y hora

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Asistencia::query();

        if ($request->has('estudiante_id') && is_numeric($request->estudiante_id)) {
            $query->where('estudiante_id', '=', $request->estudiante_id);
        }
        if ($request->has('grupo_id') && is_numeric($request->grupo_id)) {
            $query->where('grupo_id', '=', $request->grupo_id);
        }
        if ($request->has('fecha') && $request->fecha != null) {
            $query->where('fecha', '=', $request->fecha);
        }
        $asistencias = $query->with('estudiante', 'grupo')
            ->orderBy('id', 'desc')
            ->simplePaginate(10);
        $asistencias = $query->orderBy('id', 'desc')->simplePaginate(10);

        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();
        return view('asistencias.index', compact('asistencias','estudiantes', 'grupos'));
    }

    public function create()
    {
        return view('asistencias.create');
    }

    private function marcar($estudianteGrupo){
        // Fecha y Hora actual
        $date = Carbon::now()->setTimezone('America/El_Salvador');
        // Crear objeto de asistencia
        $asistencia = [
            'estudiante_id' => $estudianteGrupo->estudiante_id,
            'grupo_id' => $estudianteGrupo->grupo_id,
            'fecha' => $date->format('Y-m-d'),
            'hora_entrada' => $date->format('H:i:s'),
        ];
        // Guardar datos de asistencia
        $marcacion = Asistencia::create($asistencia);
        return $marcacion;
    }

    public function store(Request $request)
    {
        $marcacion;
        // Validaciones
        if ( $request->has('email') && $request->has('pin') ) {
            // Verificacion de datos de estudiante
            $estudiante = Estudiante::where([
                ['email', '=', $request->email],
                ['pin', '=', $request->pin],
            ])->firstOrFail();

            // no se encontro al estudiante
            if (!$estudiante) { return abort(404); }

            $estudianteGrupos = EstudianteGrupo::where('estudiante_id', '=', $estudiante->id);

            // el estudiante no pertenece a ningun grupo
            if (!$estudianteGrupos) { return abort(404); }

            // verificar a cuantos grupos pertenece el estudiante
            if($estudianteGrupos->count() > 1){
                // Mostrar grupos asignados en pantalla para la marcacion
                $estudianteGrupos = $estudianteGrupos->get();
                return view('asistencias.create', compact('estudianteGrupos'));
            } else{
                // Marcar asistencia, el estudiante solo pertenece a un grupo
                $marcacion = $this->marcar( $estudianteGrupos->first() );
            }
        }

        // Validar marcacion de asistencia
        if( ($request->has('estudiante_id') && is_numeric($request->estudiante_id))
            && $request->has('grupo_id') && is_numeric($request->grupo_id)) {

            // Marcar asistencia en grupo especifico
            $estudianteGrupo = EstudianteGrupo::where([
                ['estudiante_id', '=', $request->estudiante_id],
                ['grupo_id', '=', $request->grupo_id],
            ])->firstOrFail();

            // el estudiante no pertenece a ningun grupo
            if ( !$estudianteGrupo ) { return abort(404); }

            // Marcar asistencia en el grupo especifico
            $marcacion = $this->marcar( $estudianteGrupo );
        }

        // Error al marcar la asistencia
        if( !$marcacion ){ return abort(404);  }

        return redirect()->route('asistencias.create')->with('success', 'Asistencia registrada correctamente');
    }

    public function destroy($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return abort(404);
        }

        $asistencia->delete();

        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente.');
    }
}
