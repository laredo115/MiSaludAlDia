<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CitaController extends Controller
{
    public function index(Request $request): View
    {
        $citas = $request->user()
            ->citas()
            ->orderBy('fecha_hora')
            ->get();

        return view('citas.index', compact('citas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'especialidad' => ['required', 'string', 'max:150'],
            'fecha_hora' => ['required', 'date_format:Y-m-d\TH:i'],
            'lugar' => ['nullable', 'string', 'max:255'],
            'preguntas' => ['nullable', 'string', 'max:2000'],
        ]);

        $request->user()->citas()->create($datos);

        return redirect()
            ->route('citas.index')
            ->with('status', 'Cita guardada correctamente.');
    }

    public function destroy(
        Request $request,
        int $cita
    ): RedirectResponse {
        $registro = $request->user()
            ->citas()
            ->findOrFail($cita);

        $registro->delete();

        return redirect()
            ->route('citas.index')
            ->with('status', 'Cita eliminada correctamente.');
    }
}