<div class="flex items-center">
	<div class="relative">
		<button id="userButton" class="bg-transparent border-none flex items-center space-x-2 py-0 px-1 rounded-md hover:bg-gray-100 focus:outline-none transition-colors duration-200">
			<div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
				<span class="text-white font-semibold">JD</span>
			</div>
			<span class="hidden md:inline text-gray-700">John Doe</span>
		</button>

		<div id="userPopover" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 transform origin-top-right transition-all duration-200 z-50">
			<div class="px-4 py-2 border-b border-gray-100">
				<p class="text-sm font-medium text-gray-900">John Doe</p>
				<p class="text-sm text-gray-500">Administrator</p>
			</div>
			<a href="/logout" class="text-gray-600 hover:text-gray-900 no-underline">
				<button id="logoutButton" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
					Sign out
				</button>
			</a>
		</div>
	</div>
</div>
<script>
	const userButton = document.getElementById('userButton');
	const userPopover = document.getElementById('userPopover');
	const logoutButton = document.getElementById('logoutButton');

	// Toggle popover
	userButton.addEventListener('click', () => {
		userPopover.classList.toggle('hidden');
	});

	// Close popover when clicking outside
	document.addEventListener('click', (event) => {
		if (!userButton.contains(event.target) && !userPopover.contains(event.target)) {
			userPopover.classList.add('hidden');
		}
	});

	// Handle logout
	logoutButton.addEventListener('click', () => {
		alert('Logging out...');
		userPopover.classList.add('hidden');
	});

	// Close popover when pressing Escape
	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape') {
			userPopover.classList.add('hidden');
		}
	});
</script>