
  document.getElementById('formulacionTicket').addEventListener('submit', function(e) {
    const titulo = this.titulo.value.trim();
    const descripcion = this.descripcion.value.trim();
    const prioridad = this.prioridad.value;
   

    if (!titulo || !descripcion || !prioridad ) {
      e.preventDefault();
      alert("Completa los campos obligatorios: Título, Descripción, Prioridad.");
      return false;
    }
  });
