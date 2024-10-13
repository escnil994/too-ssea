<?php
$title = 'Dashboard';
require_once __DIR__ . '/components/header.php';
// echo ($productos);
// print_r($categories);
// print_r("hola");
?>


<body>
	<?php require_once __DIR__ . '/components/navbar.php'; ?>
	<main class="min-h-screen flex flex-col bg-gray-50">
		<section class="p-4">
			<div class="flex justify-between gap-4 mb-4">
				<h2 class="my-2">Productos</h2>
				<button id="new-product-button" class="p-2">Nuevo Producto</button>
			</div>
			<table id="products-table">
				<thead>
					<tr>
						<th class="rounded-tl-md bg-gray-500/20">Nombre del Producto</th>
						<th class="bg-gray-500/20">Precio</th>
						<th class="bg-gray-500/20">Descripción</th>
						<th class="rounded-tr-md bg-gray-500/20">Categoría</th>
						<th class="rounded-bl-md bg-gray-500/20">Acciones</th>
					</tr>
				</thead>
				<tbody>
					<!-- Aquí se insertarán los productos mediante JavaScript -->
				</tbody>
			</table>
		</section>
	</main>
	<dialog id="new-producto-dialog">
		<article>
			<header>
				<button aria-label="Close" rel="prev"></button>
				<p>
					<strong>Nuevo Producto</strong>
				</p>
			</header>
			<form action="/productos" method="POST">
				<fieldset>
					<label>
						Nombre del producto
						<input
							type="text"
							name="name"
							placeholder="Nombre del producto" required />
					</label>
					<label>
						Precio
						<input
							type="number"
							name="price"
							placeholder="Precio del producto"
							step="0.01"
							min="0.01"
							required />
					</label>
					<label>
						Descripción
						<textarea
							name="description"
							placeholder="Descripción del producto" required></textarea>
					</label>
					<label>
						Categoría
						<select name="category_id" required>
							<?php foreach ($categories as $category) : ?>
								<option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</label>
				</fieldset>

				<input
					type="submit"
					value="Guardar" />
			</form>
		</article>
	</dialog>
	<dialog id="edit-producto-dialog">
		<article>
			<header>
				<button aria-label="Close" rel="prev"></button>
				<p>
					<strong>Editar Producto</strong>
				</p>
			</header>
			<form action="#" method="POST" id="editar-producto-form">
				<input type="hidden" name="_method" value="PUT">
				<fieldset>
					<label>
						Nombre del producto
						<input
							type="text"
							name="name"
							placeholder="Nombre del producto" required />
					</label>
					<label>
						Precio
						<input
							type="number"
							name="price"
							placeholder="Precio del producto"
							step="0.01"
							min="0.01"
							required />
					</label>
					<label>
						Descripción
						<textarea
							name="description"
							placeholder="Descripción del producto" required></textarea>
					</label>
					<label>
						Categoría
						<select name="category_id" required>
							<?php foreach ($categories as $category) : ?>
								<option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</label>
				</fieldset>
				<input
					type="submit"
					value="Guardar" />
			</form>
		</article>
	</dialog>
	<dialog id="delete-producto-dialog">
		<article>
			<header>
				<button aria-label="Close" rel="prev"></button>
				<p>
					<strong>Eliminar Producto</strong>
				</p>
			</header>
			<form action="#" method="POST" id="delete-producto-form">
				<input type="hidden" name="_method" value="DELETE">
				<fieldset>
					<label>
						¿Estás seguro de que deseas eliminar este producto?
					</label>
				</fieldset>
				<input
					type="submit"
					value="Eliminar" />
			</form>
		</article>
	</dialog>
</body>
<script>

</script>
<script>
	const newProductDialog = document.querySelector('#new-producto-dialog');
	const newProductButton = document.querySelector('#new-product-button');

	newProductButton.addEventListener('click', () => {
		newProductDialog.showModal();
	});

	newProductDialog.querySelector('button').addEventListener('click', () => {
		newProductDialog.close();
		deleteForm.action = "#";

	});
</script>

<script>
	const categories = <?php echo json_encode($categories); ?>;
	const products = <?php echo json_encode($products); ?>;
	const deleteDialog = document.querySelector('#delete-producto-dialog');
	const deleteForm = document.querySelector('#delete-producto-form');
	const editDialog = document.querySelector('#edit-producto-dialog');
	const editForm = document.querySelector('#editar-producto-form');

	deleteDialog.querySelector('button').addEventListener('click', () => {
		deleteDialog.close();
	});

	editDialog.querySelector('button').addEventListener('click', () => {
		editDialog.close();
	});

	// asociar categorias con productos
	products.forEach(product => {
		const category = categories.find(category => category.id === product.category_id);
		product.category = category;
	});

	console.log(categories);
	console.log(products);

	const productsTableBody = document.querySelector('#products-table tbody');

	// Iterar sobre los productos para agregarlos a la tabla
	products.forEach((product, index) => {
		const row = document.createElement('tr');
		row.classList.add('group');

		// Crear celdas para cada columna de la tabla
		const nameCell = document.createElement('td');
		nameCell.textContent = product.name;

		const priceCell = document.createElement('td');
		priceCell.textContent = '$' + product.price.toFixed(2);

		const descriptionCell = document.createElement('td');
		descriptionCell.textContent = product.description;

		const categoryCell = document.createElement('td');
		categoryCell.textContent = product.category?.name;

		const actionsCell = document.createElement('td');
		actionsCell.classList.add('flex', 'gap-2', 'h-full', 'flex-col');

		const deleteButton = document.createElement('button');
		deleteButton.textContent = 'Eliminar';
		deleteButton.classList.add('p-1', 'bg-red-500', 'text-white', 'rounded-md', 'mr-2', 'text-xs', 'opacity-0', 'group-hover:opacity-100');
		deleteButton.addEventListener('click', () => {
			deleteDialog.showModal();
			deleteForm.action = `/productos?id=${product.id}`;
		});

		actionsCell.appendChild(deleteButton);

		const editButton = document.createElement('button');
		editButton.textContent = 'Editar';
		editButton.classList.add('p-1', 'bg-yellow-500', 'text-white', 'rounded-md', 'mr-2', 'text-xs', 'opacity-0', 'group-hover:opacity-100');
		editButton.addEventListener('click', () => {
			editDialog.showModal();
			editForm.action = `/productos?id=${product.id}`;
			editForm.querySelector('input[name=name]').value = product.name;
			editForm.querySelector('input[name=price]').value = product.price;
			editForm.querySelector('textarea[name=description]').value = product.description;
			editForm.querySelector('select[name=category_id]').value = product.category_id;
		});

		actionsCell.appendChild(editButton);

		// Agregar las celdas a la fila
		row.appendChild(nameCell);
		row.appendChild(priceCell);
		row.appendChild(descriptionCell);
		row.appendChild(categoryCell);
		row.appendChild(actionsCell);

		// Agregar la fila a la tabla
		productsTableBody.appendChild(row);
	});
</script>