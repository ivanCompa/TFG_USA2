document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("formRegistro");

    form.addEventListener("submit", (e) => {
        // Evitar envío automático
        e.preventDefault();

        const datos = new FormData(form);

        // Validaciones básicas
        if (datos.get("password").length < 4) {
            alert("La contraseña debe tener al menos 4 caracteres");
            return;
        }

        // Enviar al controlador
        fetch(form.action, {
            method: "POST",
            body: datos
        })
        .then(res => res.json())
        .then(data => {

            if (data.error) {
                alert(data.error);
                return;
            }

            // Registro correcto
            window.location.href = data.redirect;
        })
        .catch(err => {
            console.error("Error en el registro:", err);
        });
    });

});
