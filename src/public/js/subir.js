let mainImageFile = null;
let extraImageFiles = [];

// PREVISUALIZAR IMAGEN PRINCIPAL
function previewMainImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    mainImageFile = file;

    const wrapper = document.getElementById("main-wrapper");
    const img = document.getElementById("preview-main");

    img.src = URL.createObjectURL(file);
    wrapper.classList.remove("hidden");
}

// ELIMINAR IMAGEN PRINCIPAL
function removeMainImage() {
    mainImageFile = null;

    document.querySelector("input[name='imagen']").value = "";
    document.getElementById("main-wrapper").classList.add("hidden");
}

// PREVISUALIZAR IMÁGENES EXTRA
function previewExtraImages(event) {
    const contenedor = document.getElementById("preview-extra");
    contenedor.innerHTML = "";

    extraImageFiles = Array.from(event.target.files);

    extraImageFiles.forEach((file, index) => {
        const wrapper = document.createElement("div");
        wrapper.className = "relative inline-block";

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.className = "w-28 h-28 object-cover rounded-lg border";

        const btn = document.createElement("span");
        btn.innerHTML = "✕";
        btn.className = "absolute top-1 right-1 bg-red-600 text-white w-6 h-6 flex items-center justify-center rounded-full cursor-pointer opacity-0 hover:opacity-100 transition";

        btn.onclick = () => removeExtraImage(index);

        wrapper.appendChild(img);
        wrapper.appendChild(btn);
        contenedor.appendChild(wrapper);
    });
}

// ELIMINAR UNA IMAGEN EXTRA
function removeExtraImage(index) {
    extraImageFiles.splice(index, 1);

    const input = document.querySelector("input[name='imagenes_extra[]']");
    const dataTransfer = new DataTransfer();

    extraImageFiles.forEach(file => dataTransfer.items.add(file));

    input.files = dataTransfer.files;

    previewExtraImages({ target: input });
}
