<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<!-- TAILWIND -->
<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<nav class="ruta text-xl font-semibold py-4 px-6 text-gray-700">
  Inicio
</nav>

<div class="bloque-superior bg-white border-b-2 border-[#bcd8f0] p-6 rounded-lg shadow-md">

  <!-- BUSCADOR -->
  <form action="<?= isset($_GET['cat']) ? RUTA_URL . '/paginas/index' : RUTA_URL . '/productos/buscar' ?>" method="GET"
    class="busqueda flex flex-col md:flex-row md:items-center gap-4 mb-6">

    <label class="text-xl font-semibold">Buscar:</label>

    <div class="flex gap-3 items-center">

      <?php if (isset($_GET['cat'])): ?>
        <input type="hidden" name="cat" value="<?= htmlspecialchars($_GET['cat']) ?>">
      <?php endif; ?>

      <!-- BARRA DE BUSQUEDA -->
      <div class="relative">
        <input type="text" name="buscar" placeholder="Buscar producto..."
          value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>" class="search-input border border-gray-400 rounded-lg px-4 py-2 w-72 text-lg
                    focus:outline-none transition-all shadow-sm">
        <span class="focus-line"></span>
      </div>

      <!-- FILTRO ORDENAR POR -->
      <div class="relative">
        <select name="orden" class="custom-select border border-gray-400 rounded-lg px-4 py-2 text-lg bg-white shadow-sm
                     focus:outline-none transition-all" onchange="this.form.submit()">

          <option value="">Ordenar por…</option>
          <option value="az" <?= ($_GET['orden'] ?? '') === 'az' ? 'selected' : '' ?>>A → Z</option>
          <option value="za" <?= ($_GET['orden'] ?? '') === 'za' ? 'selected' : '' ?>>Z → A</option>
          <option value="precio_asc" <?= ($_GET['orden'] ?? '') === 'precio_asc' ? 'selected' : '' ?>>Precio ↑</option>
          <option value="precio_desc" <?= ($_GET['orden'] ?? '') === 'precio_desc' ? 'selected' : '' ?>>Precio ↓</option>

        </select>

        <div class="select-arrow"></div>
      </div>

      <!-- BOTÓN BUSCAR -->
      <button type="submit"
        class="bg-[#0077cc] text-white px-6 py-2 rounded-lg hover:bg-[#005fa3] transition shadow-md text-lg">
        Buscar
      </button>

    </div>
  </form>


  <!-- CATEGORÍAS (CARGADAS DESDE LA BASE DE DATOS) -->
  <aside class="categorias">
    <h3 class="text-2xl font-bold mb-4">Categorías:</h3>

    <div class="fila-categorias flex flex-wrap gap-4">

      <?php foreach ($datos['categorias'] as $cat): ?>
        <a href="<?= RUTA_URL ?>/paginas/index?cat=<?= htmlspecialchars($cat['slug']) ?>">
          <button
            class="px-5 py-3 text-lg bg-white border-2 border-[#a0b8d0] rounded-lg hover:bg-[#e6f2ff] transition shadow-sm">
            <?= htmlspecialchars($cat['nombre']) ?>
          </button>
        </a>
      <?php endforeach; ?>

    </div>
  </aside>

</div>


<main class="px-6 py-8">

  <!-- PRODUCTOS DESTACADOS -->
  <div
    class="destacados-box bg-[#e8d7ff] border-2 border-[#c7aef5] rounded-xl p-8 shadow-lg w-[calc(100%-40px)] mx-auto">

    <h3 class="text-2xl font-bold mb-6">
      Productos destacados
      <?php if (!empty($datos['categoriaSeleccionada'])): ?>
        en <?= htmlspecialchars($datos['categoriaSeleccionada']) ?>
      <?php endif; ?>:
    </h3>

    <div class="carrusel flex items-center justify-center gap-6">

      <button
        class="flecha izq bg-[#0077cc] text-white text-3xl px-5 py-3 rounded-lg shadow hover:bg-[#005fa3] transition">
        ◀
      </button>

      <div class="productos flex gap-8 overflow-visible w-[calc(200px*4+35px*3)] mx-auto">

        <?php foreach ($datos['destacados'] as $p): ?>
          <a href="<?= RUTA_URL ?>/productos/detalle/<?= $p['producto_id'] ?>"
            class="producto bg-white border border-gray-300 rounded-xl p-4 shadow-md hover:shadow-xl transition transform hover:scale-105 text-center w-[200px]">

            <img src="<?= RUTA_URL ?>/img/productos/<?= $p['imagen'] ?>"
              alt="<?= htmlspecialchars($p['titulo']) ?>"
              class="rounded-lg mb-3 w-full h-[180px] object-contain bg-white p-2 shadow-sm">

            <p class="text-2xl font-bold"><?= $p['precio'] ?> €</p>
          </a>
        <?php endforeach; ?>

      </div>

      <button
        class="flecha der bg-[#0077cc] text-white text-3xl px-5 py-3 rounded-lg shadow hover:bg-[#005fa3] transition">
        ▶
      </button>

    </div>
  </div>

  <!-- RESTO DE PRODUCTOS -->
  <?php if (!empty($datos['restoProductos'])): ?>
    <div
      class="todos-productos-box bg-[#e8d7ff] border-2 border-[#c7aef5] rounded-xl p-8 shadow-lg w-[calc(100%-40px)] mx-auto mt-10">

      <h3 class="text-2xl font-bold mb-6">
        Todos los productos de <?= htmlspecialchars($datos['categoriaSeleccionada']) ?>
      </h3>

      <div class="productos flex flex-wrap justify-center gap-10">

        <?php foreach ($datos['restoProductos'] as $p): ?>
          <a href="<?= RUTA_URL ?>/productos/detalle/<?= $p['producto_id'] ?>"
            class="producto bg-white border border-gray-300 rounded-xl p-4 shadow-md hover:shadow-xl transition transform hover:scale-105 text-center w-[200px]">

            <img src="<?= RUTA_URL ?>/img/productos/<?= $p['imagen'] ?>" alt="<?= htmlspecialchars($p['titulo']) ?>"
              class="rounded-lg mb-3 w-full h-[180px] object-contain bg-white p-2 shadow-sm">

            <p class="text-2xl font-bold"><?= $p['precio'] ?> €</p>
          </a>
        <?php endforeach; ?>

      </div>

    </div>
  <?php endif; ?>

</main>

<script src="<?= RUTA_URL ?>/public/js/main.js"></script>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>