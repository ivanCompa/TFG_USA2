const carrusel = document.querySelector('.carrusel .productos');
const btnIzq = document.querySelector('.flecha.izq');
const btnDer = document.querySelector('.flecha.der');

if (carrusel && btnIzq && btnDer) {
    const productoWidth = 200 + 35;
    const scrollAmount = productoWidth * 4;

    btnIzq.addEventListener('click', () => {
        carrusel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });

    btnDer.addEventListener('click', () => {
        carrusel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
}


/* CARRUSEL */
const carrusel = document.querySelector('.carrusel .productos');
const btnIzq = document.querySelector('.flecha.izq');
const btnDer = document.querySelector('.flecha.der');

if (carrusel && btnIzq && btnDer) {
    const productoWidth = 200 + 35; 
    const scrollAmount = productoWidth * 4;

    btnIzq.addEventListener('click', () => {
        carrusel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });

    btnDer.addEventListener('click', () => {
        carrusel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
}


/* FLECHA DEL COMBOBOX */
document.addEventListener("DOMContentLoaded", () => {
    const select = document.querySelector(".custom-select");
    const arrow = document.querySelector(".select-arrow");

    if (!select || !arrow) return;

    let abierto = false;

    // Detecta clic para abrir/cerrar
    select.addEventListener("pointerdown", () => {
        abierto = !abierto;
        arrow.style.transform = abierto
            ? "translateY(-50%) rotate(180deg)"
            : "translateY(-50%) rotate(0deg)";
    });

    // Si pierde el foco por clic fuera
    select.addEventListener("blur", () => {
        abierto = false;
        arrow.style.transform = "translateY(-50%) rotate(0deg)";
    });
});
