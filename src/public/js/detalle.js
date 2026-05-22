document.addEventListener("DOMContentLoaded", () => {

    const inner = document.getElementById("carruselInner");
    const imgs = inner.querySelectorAll(".img-carrusel");
    const dots = document.querySelectorAll("#dots .dot");

    const flechaIzq = document.getElementById("flechaIzq");
    const flechaDer = document.getElementById("flechaDer");

    let index = 0;
    const width = 350;

    if (imgs.length <= 1) return;

    function actualizar() {
        inner.style.transform = `translateX(-${index * width}px)`;
        dots.forEach((d, i) => d.classList.toggle("active", i === index));
    }

    flechaDer?.addEventListener("click", () => {
        index = (index + 1) % imgs.length;
        actualizar();
    });

    flechaIzq?.addEventListener("click", () => {
        index = (index - 1 + imgs.length) % imgs.length;
        actualizar();
    });

    dots.forEach((dot, i) => {
        dot.addEventListener("click", () => {
            index = i;
            actualizar();
        });
    });

});
