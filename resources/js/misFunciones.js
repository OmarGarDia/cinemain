function confirmDeletion(event, userId) {
    alert("Llega");
    event.preventDefault();
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        document.getElementById("delete-form-" + userId).submit();
    }
}

function togglePassword(userId) {
    const passwordSpan = document.getElementById(`password-${userId}`);
    const toggleIcon = document.getElementById(`toggle-icon-${userId}`);
    const button = document.querySelector(
        `button[onclick="togglePassword(${userId})"]`
    );
    const password = button.getAttribute("data-password");

    if (passwordSpan.textContent === "••••••••") {
        passwordSpan.textContent = password;
        toggleIcon.classList.remove("mdi-eye");
        toggleIcon.classList.add("mdi-eye-off");
    } else {
        passwordSpan.textContent = "••••••••";
        toggleIcon.classList.remove("mdi-eye-off");
        toggleIcon.classList.add("mdi-eye");
    }
}

// Hacer la función globalmente accesible
window.togglePassword = togglePassword;
