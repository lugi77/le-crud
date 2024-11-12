<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Wishlist Blade Content -->
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100">My Wishlist</h2>

                <!-- Flash Message -->
                @if (session()->has('message'))
                    <div class="alert alert-success mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Alpine.js data scope -->
                <div x-data="{ formOpen: false }">
                    <!-- Toggle Button to Show/Hide Form -->
                    <button @click="formOpen = !formOpen" class="bg-blue-600 dark:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-300 mb-6">
                        {{ $wishlistId ? 'Update Wishlist' : 'Add to Wishlist' }}
                    </button>

                    <!-- Form to Add/Edit Wishlist Entry (Hidden/Shown based on Alpine.js state) -->
                    <div x-show="formOpen" @click.away="formOpen = false" class="transition-all duration-300">
                        <form wire:submit.prevent="{{ $wishlistId ? 'update' : 'store' }}" class="mb-6">
                            <!-- Title -->
                            <div class="mb-5">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Title</label>
                                <input type="text" id="title" wire:model="title" class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg" required>
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Author -->
                            <div class="mb-5">
                                <label for="author" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Author</label>
                                <input type="text" id="author" wire:model="author" class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg" required>
                                @error('author') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Genre -->
                            <div class="mb-5">
                                <label for="genre" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Genre</label>
                                <input type="text" id="genre" wire:model="genre" class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg" required>
                                @error('genre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Notes -->
                            <div class="mb-5">
                                <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Notes</label>
                                <textarea id="notes" wire:model="notes" class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg"></textarea>
                                @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-between">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300">
                                    {{ $wishlistId ? 'Update' : 'Add to Wishlist' }}
                                </button>

                                <!-- Close Button -->
                                <button type="button" @click="formOpen = false" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-700 transition duration-300">
                                    Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Wishlist Table -->
                <div class="overflow-x-auto flex justify-center">
                    <table class="text-white w-full max-w-6xl border-collapse mt-6 text-center">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100 dark:text-gray-200">Title</th>
                                <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100 dark:text-gray-200">Author</th>
                                <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100 dark:text-gray-200">Genre</th>
                                <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100 dark:text-gray-200">Notes</th>
                                <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100 dark:text-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wishlists as $wishlist)
                                <tr>
                                    <td class="px-6 py-4 border-b text-gray-100 dark:text-gray-300">{{ $wishlist->title }}</td>
                                    <td class="px-6 py-4 border-b text-gray-100 dark:text-gray-300">{{ $wishlist->author }}</td>
                                    <td class="px-6 py-4 border-b text-gray-100 dark:text-gray-300">{{ $wishlist->genre }}</td>
                                    <td class="px-6 py-4 border-b text-gray-100 dark:text-gray-300">{{ $wishlist->notes }}</td>
                                    <td class="px-6 py-4 border-b text-gray-100 dark:text-gray-300">
                                        <button wire:click="edit({{ $wishlist->id }})" class="text-blue-500 hover:text-blue-700">Edit</button>
                                        <button wire:click="delete({{ $wishlist->id }})" class="text-red-500 hover:text-red-700 ml-4">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $wishlists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
