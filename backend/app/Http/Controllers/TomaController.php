<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TomaController extends Controller
{
    public function store(
        Request $request,
        int $medicamento
    ): RedirectResponse {
        $registro = $request->user()
            ->medicamentos()
            ->findOrFail($medicamento);

        $ahora = now();

        $toma = $registro->tomas()->firstOrCreate(
            ['fecha' => $ahora->toDateString()],
            ['registrada_en' => $ahora]
        );

        return redirect()
            ->route('medicamentos.index')
            ->with(
                'status',
                $toma->wasRecentlyCreated
                    ? 'Toma registrada correctamente.'
                    : 'Este medicamento ya tiene una toma registrada hoy.'
            );
    }
}