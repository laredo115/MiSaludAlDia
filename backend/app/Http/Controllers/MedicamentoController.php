<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicamentoController extends Controller
{
    public function index(Request $request): View
    {
        $medicamentos = $request->user()
            ->medicamentos()
            ->orderBy('hora')
            ->orderBy('nombre')
            ->get();

        return view('medicamentos.index', compact('medicamentos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'dosis' => ['required', 'string', 'max:150'],
            'hora' => ['required', 'date_format:H:i'],
            'notas' => ['nullable', 'string', 'max:2000'],
        ]);

        $request->user()->medicamentos()->create($datos);

        return redirect()
            ->route('medicamentos.index')
            ->with('status', 'Medicamento guardado correctamente.');
    }

    public function destroy(
        Request $request,
        int $medicamento
    ): RedirectResponse {
        $registro = $request->user()
            ->medicamentos()
            ->findOrFail($medicamento);

        $registro->delete();

        return redirect()
            ->route('medicamentos.index')
            ->with('status', 'Medicamento eliminado correctamente.');
    }
}