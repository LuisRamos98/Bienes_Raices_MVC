<main class="contenedor seccion">
    <h1>Crear</h1>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php  echo $error;?> 
        </div>   
    <?php endforeach?>
    
    <form class="formulario" method="POST">
        <?php include __DIR__ . "/formulario.php"; ?>
        <input type="submit" class="boton boton-verde" value="Crear Propiedad">
    </form>
</main>