<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre: </label>
    <input 
    type="text" 
    id="nombre" 
    placeholder="Nombre vendedor(a)" 
    name="vendedor[nombre]" 
    value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido: </label>
    <input 
    type="text" 
    id="apellido" 
    placeholder="Apellido vendedor(a)" 
    name="vendedor[apellido]" 
    value="<?php echo s($vendedor->apellido); ?>">
</fieldset>

<fieldset>
    <legend>Información General</legend>

    <label for="telefono">Télefono: </label>
    <input 
    type="text" 
    id="telefono" 
    placeholder="Télefono vendedor(a)" 
    name="vendedor[telefono]" 
    value="<?php echo s($vendedor->telefono); ?>">
</fieldset>