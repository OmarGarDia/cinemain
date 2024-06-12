function confirmDeletion(event, userId) {
    alert("Llega");
    event.preventDefault();
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        document.getElementById("delete-form-" + userId).submit();
    }
}
