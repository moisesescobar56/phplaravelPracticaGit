@extends('layouts.app')

@section('content')

    @if (session('success'))
        <div class="alert alert-success fade show m-2" id="success-message" data-bs-dismiss="alert" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <h1>Marcar Asistencia</h1>
    <form action="{{ route('asistencias.store') }}" method="POST">
        @csrf

        @if ( isset($estudianteGrupos) )
            <div class="row">
                <div class="col-md-5">
                    {{-- {{ dd($estudianteGrupos) }} --}}
                    <label for="grupo_id" class="form-label">Grupo</label>
                    <input type="hidden" name="estudiante_id" value="{{ $estudianteGrupos->first()->estudiante_id }}">
                    <select name="grupo_id" class="form-select" required>
                        <option value="0">Seleccione un grupo</option>
                        @foreach ($estudianteGrupos as $estudianteGrupo)
                            <option value="{{ $estudianteGrupo->grupo_id }}">{{ $estudianteGrupo->grupo->nombre }} - {{ $estudianteGrupo->grupo->descripcion }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-5">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label for="pin" class="form-label">Pin</label>
                    <input type="password" class="form-control" id="pin" name="pin" required>
                </div>
            </div>
        @endif

        <div class="row mt-2">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success">Confirmar</button>
                <a href="{{ route('docentes.login') }}" class="btn btn-link">Ir al Login</a>

            </div>
        </div>
    </form>
@endsection
