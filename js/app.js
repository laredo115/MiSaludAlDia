"use strict";

const CLAVE = "mi-salud-al-dia-v1";
const $ = (id) => document.getElementById(id);

let datos = {
  medicamentos: [],
  citas: [],
  tomas: {}
};

let almacenamientoDisponible = true;

try {
  const guardados = localStorage.getItem(CLAVE);

  if (guardados) {
    const contenido = JSON.parse(guardados);

    if (
      !contenido ||
      !Array.isArray(contenido.medicamentos) ||
      !Array.isArray(contenido.citas) ||
      !contenido.tomas ||
      typeof contenido.tomas !== "object" ||
      Array.isArray(contenido.tomas)
    ) {
      throw new Error("Formato de datos inválido");
    }

    datos = contenido;
  }
} catch {
  almacenamientoDisponible = false;
  mostrarMensaje(
    "No se pudieron cargar los datos. No se sobrescribirá lo guardado."
  );
}

function mostrarMensaje(texto) {
  $("mensaje").textContent = texto;
}

function guardar(cambios, mensaje) {
  if (!almacenamientoDisponible) {
    mostrarMensaje(
      "El almacenamiento no está disponible. No se guardó el cambio."
    );
    return false;
  }

  try {
    localStorage.setItem(CLAVE, JSON.stringify(cambios));
    datos = cambios;
    renderizar();
    mostrarMensaje(mensaje);
    return true;
  } catch {
    mostrarMensaje(
      "No se pudo guardar. Revisa los permisos o el espacio del navegador."
    );
    return false;
  }
}

function crearId() {
  return globalThis.crypto?.randomUUID?.() ??
    `${Date.now()}-${Math.random().toString(16).slice(2)}`;
}

function fechaLocal() {
  const ahora = new Date();
  const anio = ahora.getFullYear();
  const mes = String(ahora.getMonth() + 1).padStart(2, "0");
  const dia = String(ahora.getDate()).padStart(2, "0");

  return `${anio}-${mes}-${dia}`;
}

function elemento(etiqueta, texto, clase) {
  const nodo = document.createElement(etiqueta);

  if (texto !== undefined) {
    nodo.textContent = texto;
  }

  if (clase) {
    nodo.className = clase;
  }

  return nodo;
}

function boton(texto, clase, accion) {
  const nodo = elemento("button", texto, clase);
  nodo.type = "button";
  nodo.addEventListener("click", accion);
  return nodo;
}

function prepararLista(id, mensaje) {
  const lista = $(id);
  lista.replaceChildren();

  if (mensaje) {
    lista.append(elemento("li", mensaje, "empty-state"));
  }

  return lista;
}

function crearTarjeta(titulo, detalles) {
  const tarjeta = elemento("li", undefined, "item-card");
  const contenido = elemento("div", undefined, "item-content");
  const acciones = elemento("div", undefined, "item-actions");

  contenido.append(elemento("h3", titulo));

  detalles.filter(Boolean).forEach((detalle) => {
    contenido.append(elemento("p", detalle));
  });

  tarjeta.append(contenido, acciones);
  return { tarjeta, contenido, acciones };
}

$("form-medicamento").addEventListener("submit", (evento) => {
  evento.preventDefault();

  const formulario = evento.currentTarget;

  if (!formulario.reportValidity()) return;

  const nombre = $("nombre-medicamento").value.trim();
  const dosis = $("dosis-medicamento").value.trim();
  const hora = $("hora-medicamento").value;
  const notas = $("notas-medicamento").value.trim();

  if (!nombre || !dosis) {
    mostrarMensaje("Escribe el nombre y la dosis indicada.");
    return;
  }

  const medicamento = {
    id: crearId(),
    nombre,
    dosis,
    hora,
    notas
  };

  const cambios = {
    ...datos,
    medicamentos: [...datos.medicamentos, medicamento]
  };

  if (guardar(cambios, "Medicamento agregado correctamente.")) {
    formulario.reset();
  }
});

$("form-cita").addEventListener("submit", (evento) => {
  evento.preventDefault();

  const formulario = evento.currentTarget;

  if (!formulario.reportValidity()) return;

  const especialidad = $("especialidad-cita").value.trim();
  const fecha = $("fecha-cita").value;
  const lugar = $("lugar-cita").value.trim();
  const preguntas = $("preguntas-cita").value.trim();
  const fechaElegida = new Date(fecha);

  if (!especialidad) {
    mostrarMensaje("Escribe la especialidad o el motivo de la cita.");
    return;
  }

  if (
    !Number.isFinite(fechaElegida.getTime()) ||
    fechaElegida.getTime() <= Date.now()
  ) {
    mostrarMensaje("Selecciona una fecha y hora futuras para la cita.");
    return;
  }

  const cita = {
    id: crearId(),
    especialidad,
    fecha,
    lugar,
    preguntas
  };

  const cambios = {
    ...datos,
    citas: [...datos.citas, cita]
  };

  if (guardar(cambios, "Cita guardada correctamente.")) {
    formulario.reset();
  }
});

function eliminarMedicamento(id) {
  if (!confirm("¿Eliminar este medicamento y sus registros de tomas?")) {
    return;
  }

  const tomas = {};

  Object.entries(datos.tomas).forEach(([fecha, registros]) => {
    const copia = { ...registros };
    delete copia[id];
    tomas[fecha] = copia;
  });

  guardar(
    {
      ...datos,
      medicamentos: datos.medicamentos.filter((med) => med.id !== id),
      tomas
    },
    "Medicamento eliminado."
  );
}

function cambiarToma(id) {
  const hoy = fechaLocal();
  const registros = { ...(datos.tomas[hoy] ?? {}) };

  if (registros[id]) {
    if (!confirm("¿Deshacer el registro de esta toma de hoy?")) return;
    delete registros[id];
  } else {
    registros[id] = new Date().toISOString();
  }

  guardar(
    {
      ...datos,
      tomas: { ...datos.tomas, [hoy]: registros }
    },
    registros[id] ? "Toma registrada." : "Registro de toma deshecho."
  );
}

function eliminarCita(id) {
  if (!confirm("¿Eliminar esta cita?")) return;

  guardar(
    {
      ...datos,
      citas: datos.citas.filter((cita) => cita.id !== id)
    },
    "Cita eliminada."
  );
}

function renderizar() {
  const hoy = fechaLocal();
  const registros = datos.tomas[hoy] ?? {};

  $("fecha-hoy").textContent = new Date().toLocaleDateString("es", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric"
  });

  $("total-medicamentos").textContent = datos.medicamentos.length;

  $("total-tomas").textContent = datos.medicamentos.filter(
    (med) => registros[med.id]
  ).length;

  $("total-citas").textContent = datos.citas.filter(
    (cita) => new Date(cita.fecha).getTime() > Date.now()
  ).length;

  const medicamentos = [...datos.medicamentos].sort(
    (a, b) => a.hora.localeCompare(b.hora)
  );

  const listaMedicamentos = prepararLista(
    "lista-medicamentos",
    medicamentos.length ? "" : "Todavía no has registrado medicamentos."
  );

  const listaTomas = prepararLista(
    "lista-tomas",
    medicamentos.length ? "" : "Agrega un medicamento para ver su horario aquí."
  );

  medicamentos.forEach((med) => {
    const ficha = crearTarjeta(med.nombre, [
      `Dosis indicada: ${med.dosis}`,
      `Horario diario: ${med.hora}`,
      med.notas ? `Notas: ${med.notas}` : ""
    ]);

    ficha.acciones.append(
      boton("Eliminar", "btn-danger", () => eliminarMedicamento(med.id))
    );

    listaMedicamentos.append(ficha.tarjeta);

    const realizada = Boolean(registros[med.id]);
    const toma = crearTarjeta(med.nombre, [
      `Horario: ${med.hora} · Dosis indicada: ${med.dosis}`
    ]);

    toma.contenido.append(
      elemento(
        "span",
        realizada ? "Toma registrada" : "Sin registro",
        realizada ? "badge completed" : "badge"
      )
    );

    if (realizada) {
      toma.contenido.append(
        elemento(
          "p",
          `Registrada a las ${new Date(registros[med.id]).toLocaleTimeString(
            "es",
            { hour: "2-digit", minute: "2-digit" }
          )}`
        )
      );
    }

    toma.acciones.append(
      boton(
        realizada ? "Deshacer registro" : "Registrar toma",
        realizada ? "btn-secondary" : "btn-primary",
        () => cambiarToma(med.id)
      )
    );

    listaTomas.append(toma.tarjeta);
  });

  const citas = [...datos.citas].sort(
    (a, b) => new Date(a.fecha) - new Date(b.fecha)
  );

  const listaCitas = prepararLista(
    "lista-citas",
    citas.length ? "" : "Todavía no has registrado citas."
  );

  citas.forEach((cita) => {
    const fecha = new Date(cita.fecha);
    const ficha = crearTarjeta(cita.especialidad, [
      fecha.toLocaleString("es", {
        dateStyle: "long",
        timeStyle: "short"
      }),
      cita.lugar ? `Lugar: ${cita.lugar}` : "",
      cita.preguntas ? `Preguntas: ${cita.preguntas}` : ""
    ]);

    if (fecha.getTime() <= Date.now()) {
      ficha.contenido.append(elemento("span", "Cita pasada", "badge"));
    }

    ficha.acciones.append(
      boton("Eliminar", "btn-danger", () => eliminarCita(cita.id))
    );

    listaCitas.append(ficha.tarjeta);
  });
}

renderizar();

// Actualiza la fecha y los contadores si la página permanece abierta.
setInterval(renderizar, 60000);

document.addEventListener("visibilitychange", () => {
  if (!document.hidden) renderizar();
});