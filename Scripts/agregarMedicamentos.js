// Obtener los elementos del DOM
const formularioMedicamento = document.getElementById(
  "formulario-agregar-medicamento"
);
const tablaMedicamentos = document
  .getElementById("tabla-medicamentos")
  .getElementsByTagName("tbody")[0];
const botonConsultar = document.getElementById("boton-consultar");
const tablaMedicamentosSection = document.getElementById("tabla-medicamentos");
const buscarMedicamentoInput = document.getElementById("buscar-medicamento");

// Escuchar el evento de agregar medicamento
formularioMedicamento.addEventListener("submit", function (e) {
  e.preventDefault();

  // Obtener los valores de los campos
  const nombreMedicamento = document.getElementById("nombre-medicamento").value;
  const cantidadMedicamento = document.getElementById(
    "cantidad-medicamento"
  ).value;

  // Crear una nueva fila en la tabla
  const nuevaFila = tablaMedicamentos.insertRow();

  // Agregar celdas a la fila
  const celdaNombre = nuevaFila.insertCell(0);
  const celdaCantidad = nuevaFila.insertCell(1);
  const celdaAcciones = nuevaFila.insertCell(2);

  // Asignar los valores a las celdas
  celdaNombre.innerText = nombreMedicamento;
  celdaCantidad.innerText = cantidadMedicamento;
  celdaAcciones.innerHTML = `
    <button class="editar">Editar</button>
    <button class="eliminar">Eliminar</button>
  `;

  // Limpiar los campos del formulario
  formularioMedicamento.reset();

  // Funcionalidad para eliminar medicamento
  celdaAcciones
    .querySelector(".eliminar")
    .addEventListener("click", function () {
      tablaMedicamentos.deleteRow(nuevaFila.rowIndex - 1);
    });

  // Funcionalidad para editar medicamento
  celdaAcciones.querySelector(".editar").addEventListener("click", function () {
    const nuevoNombre = prompt(
      "Nuevo nombre del medicamento",
      nombreMedicamento
    );
    const nuevaCantidad = prompt("Nueva cantidad", cantidadMedicamento);

    if (nuevoNombre && nuevaCantidad) {
      celdaNombre.innerText = nuevoNombre;
      celdaCantidad.innerText = nuevaCantidad;
    }
  });
});

// Mostrar la tabla y el campo de búsqueda al hacer clic en "Consultar"
botonConsultar.addEventListener("click", function () {
  buscarMedicamentoInput.style.display = "block";
  tablaMedicamentosSection.style.display = "table";
});

// Buscar medicamento por nombre
buscarMedicamentoInput.addEventListener("keyup", function () {
  const filtro = buscarMedicamentoInput.value.toLowerCase();
  const filas = tablaMedicamentos.getElementsByTagName("tr");

  for (let i = 0; i < filas.length; i++) {
    const celdaNombre = filas[i].getElementsByTagName("td")[0];
    if (celdaNombre) {
      const nombre = celdaNombre.textContent || celdaNombre.innerText;
      if (nombre.toLowerCase().indexOf(filtro) > -1) {
        filas[i].style.display = "";
      } else {
        filas[i].style.display = "none";
      }
    }
  }
});
