<?php
require_once 'src/config/timezone.php';
require_once 'src/controllers/CountryController.php';

// Crear una instancia del controlador de país
$countryController = new CountryController();

// Obtener el listado de países admitidos
$countries = $countryController->getSupportedCountries();

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el país seleccionado del formulario
    $country = strtolower($_POST['country'] ?? '');

    // Establecer la zona horaria en función del país seleccionado
    $countryController->setTimezone($country);

    // obtener hora en formato de 12hr
    $time = date("g:i A", strtotime($countryController->getCurrentTime()));

    // Procesar la entrada del usuario y obtener el saludo
    $greeting = $countryController->processCountry($country);
}
?>

<!-- Incluir el encabezado de la página -->
<?php include 'src/views/header.php'; ?>

<!-- Contenido principal de la página -->
<main class="bg-emerald-950 text-white h-screen w-full flex items-center justify-center">
    <?php if (isset($greeting)) : ?>
        <!-- Mostrar el saludo resultante -->
        <div class="text-center">
            <h1 class="text-4xl mb-5"><?php echo "Bienvenido a " . ucfirst($country); ?></h1>
            <h3 class="text-2xl mb-5">Son las: <span class="text-emerald-500"><?php echo $time ?></span></h3>
            <h3 class="text-2xl text-emerald-700 mb-5"><?php echo $greeting ?></h3>

            <a href="index.php" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg w-full">Volver</a>
        </div>
    <?php else : ?>
        <!-- Mostrar el formulario para seleccionar el país -->
        <section class="flex flex-col gap-5 p-5 sm:p-0">
            <h1 class="text-2xl sm:text-4xl mb-7">Seleccione su país de destino</h1>
            <form class="gap-5" action="index.php" method="POST">
                <select class="w-full bg-emerald-700 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg mb-5" id="country" name="country" required>
                    <?php foreach ($countries as $country) : ?>
                        <option value="<?php echo strtolower($country); ?>"><?php echo $country; ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg w-full" type="submit">Procesar</button>
            </form>
        </section>
    <?php endif; ?>
</main>

<!-- Incluir el pie de página -->
<?php include 'src/views/footer.php'; ?>