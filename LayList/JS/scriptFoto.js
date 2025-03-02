document.addEventListener("DOMContentLoaded", () => {
    const btnPerfil = document.getElementById("btn-perfil");
    const menuDrop = document.getElementById("menu-drop");
    const btnFoto = document.getElementById("btn-foto");
    const btnSesion = document.getElementById("btn-sesion");
    const nombreUsuario = document.getElementById("nombre-usuario");
    const formCambioNombre = document.querySelector("form");

    if (btnPerfil && menuDrop) {
        btnPerfil.addEventListener("click", (event) => {
            event.stopPropagation();
            menuDrop.classList.toggle("active");
        });

        document.addEventListener("click", (event) => {
            if (!menuDrop.contains(event.target) && event.target !== btnPerfil) {
                menuDrop.classList.remove("active");
            }
        });
    }

    if (btnFoto) {
        const inputFoto = document.createElement("input");
        inputFoto.type = "file";
        inputFoto.accept = "image/*";

        btnFoto.addEventListener("click", (e) => {
            e.preventDefault();
            inputFoto.click();
        });

        inputFoto.addEventListener("change", (e) => {
            const archivo = e.target.files[0];
            if (archivo) {
                const lector = new FileReader();
                lector.onload = (event) => {
                    const imgPerfil = btnPerfil.querySelector("img") || btnPerfil;
                    if (imgPerfil.tagName === "IMG") {
                        imgPerfil.src = event.target.result;
                        localStorage.setItem("fotoPerfil", event.target.result);
                    }
                };
                lector.readAsDataURL(archivo);
            }
        });

        const imagenGuardada = localStorage.getItem("fotoPerfil");
        if (imagenGuardada) {
            const imgPerfil = btnPerfil.querySelector("img") || btnPerfil;
            if (imgPerfil.tagName === "IMG") {
                imgPerfil.src = imagenGuardada;
            }
        }
    }

    if (btnSesion) {
        btnSesion.addEventListener("click", (e) => {
            e.preventDefault();
            window.location.href = "cerrar_sesion.php"; 
        });
    }
    if (formCambioNombre && nombreUsuario) {
        formCambioNombre.addEventListener("submit", (e) => {
            e.preventDefault();
            const nuevoNombre = e.target.nombre.value.trim();
            if (nuevoNombre) {
                fetch("actualizar_nombre.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "nombre=" + encodeURIComponent(nuevoNombre),
                })
                    .then((response) => response.text())
                    .then((data) => {
                        if (data === "success") {
                            nombreUsuario.textContent = nuevoNombre;
                        } else {
                            alert("Error al actualizar el nombre.");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Error al actualizar el nombre.");
                    });
            }
        });
    }
});