<main class="contenedor seccion contenido-centrado">
    <h1>Inicio de Sesión</h1>
    <?php foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error?>
    </div>
    <?php endforeach ?>

    <form class="formulario" method="POST" action="/login">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" >
            <label for="password">Password</label>
            <input type="password" name="password" id="password" >
        </fieldset>

        <input type="submit" value="Inciar Sesión" class="boton boton-verde">
    </form>
</main>