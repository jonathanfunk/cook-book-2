document.addEventListener('DOMContentLoaded', function () {
	console.log('Yes!');
	const addIngredientButton = document.getElementById('addIngredient');
	const ingredientInputs = document.getElementById('ingredientInputs');

	addIngredientButton.addEventListener('click', function () {
		const newIngredientInput = document.createElement('div');
		newIngredientInput.className = 'input-group mb-2';
		const inputField = document.createElement('input');
		inputField.type = 'text';
		inputField.className = 'form-control';
		inputField.name = 'ingredient[]';
		inputField.value = ''; // Set initial value to empty string
		inputField.required = true;

		const removeButton = document.createElement('button');
		removeButton.type = 'button';
		removeButton.className = 'btn btn-danger remove-ingredient';
		removeButton.textContent = 'Remove';
		removeButton.addEventListener('click', function () {
			ingredientInputs.removeChild(newIngredientInput);
		});

		newIngredientInput.appendChild(inputField);
		newIngredientInput.appendChild(removeButton);
		ingredientInputs.appendChild(newIngredientInput);
	});

	// Add event listener for dynamically added remove buttons
	ingredientInputs.addEventListener('click', function (e) {
		if (e.target.classList.contains('remove-ingredient')) {
			e.target.parentElement.parentElement.remove();
		}
	});
});
