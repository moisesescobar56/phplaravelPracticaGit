@extends('layouts.app')

@section('content')

    @if (session('success'))
    <div class="alert alert-success fade show m-4" id="success-message" data-bs-dismiss="alert" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <h1>Marcar Asistencia</h1>
    <form action="{{ route('estudiantes.confirmar') }}" method="POST">
        @csrf
        {{-- <div class="row">
            <div class="col-md-6">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-4">
                <label for="pin" class="form-label">Pin</label>
                <input type="password" class="form-control" id="pin" name="pin" required>
            </div>
        </div>
        <div style="margin-top: 10px" class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Confirmar</button>
                <br>
                <br>
                <a href="{{ route('docentes.login') }}" class="btn btn-secondary">Ir al Login</a>

            </div>
        </div>
        <div style="margin-top: 10px" class="row">
            {{-- @error('InvalidCredentials')
            <div class="alert alert-success fade show" id="success-message" data-bs-dismiss="alert" role="alert">
                {{ $message }}
            </div>
            @enderror --}}
        </div>
    </form>
@endsection
