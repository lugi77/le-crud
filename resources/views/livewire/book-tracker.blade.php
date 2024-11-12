<div x-data="{ open: false }">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book Tracker') }}
        </h2>
    </x-slot>

    <!-- Data Table -->
    <div class="py-12 min-h-screen">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-full">
                <div class="p-6">
                    <!-- Flash Message -->
                    @if (session()->has('message'))
                        <div class="alert alert-success mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Button to open modal -->
                    <div class="flex items-center justify-between mb-4">
                        <!-- Create Entry Button -->
                        <button @click="open = true"
                            class="flex items-center bg-blue-600 dark:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-300">
                            <!-- Plus Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add Book
                        </button>


                        <!-- Search Input -->
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search books..."
                            class="w-full max-w-md px-4 py-2 ml-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-md">
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto flex justify-center">
                        <table class="text-white w-full max-w-6xl border-collapse mt-6 text-center">
                            <thead>
                                <tr>

                                    <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100">Title</th>
                                    <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100">Author</th>
                                    <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100">Genre</th>
                                    <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100">Status</th>
                                    <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100">Rating</th>
                                    <th class="px-6 py-3 border-b font-semibold text-lg text-gray-100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                    <tr>

                                        <td class="px-6 py-4 border-b text-gray-100">{{ $book->title }}</td>
                                        <td class="px-6 py-4 border-b text-gray-100">{{ $book->author }}</td>
                                        <td class="px-6 py-4 border-b text-gray-100">{{ $book->genre }}</td>
                                        <td class="px-6 py-4 border-b text-gray-100">{{ $book->status }}</td>
                                        <td class="px-6 py-4 border-b text-gray-100">{{ $book->rating }}</td>
                                        <td class="px-6 py-4 border-b text-gray-100">
                                            <!-- Edit Button -->
                                            <button wire:click="edit({{ $book->id }})"
                                                class="text-blue-500 hover:text-blue-700">Edit</button>

                                            <!-- Delete Button -->
                                            <button
                                                @click="if(confirm('Are you sure you want to delete this book?')) { $wire.deleteBook({{ $book->id }}) }"
                                                class="text-red-500 hover:text-red-700 ml-4">
                                                Delete
                                            </button>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-data="{ open: @entangle('openEditModal') }" x-show="open" @click.away="open = false"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-4">
                <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Edit Book Entry</h2>

                <form wire:submit.prevent="update">
                    <!-- Title -->
                    <div class="mb-5">
                        <label for="title" class="block text-sm font-semibold text-gray-700">Title</label>
                        <input type="text" id="title" wire:model="title"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Author -->
                    <div class="mb-5">
                        <label for="author" class="block text-sm font-semibold text-gray-700">Author</label>
                        <input type="text" id="author" wire:model="author"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('author') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Genre -->
                    <div class="mb-5">
                        <label for="genre" class="block text-sm font-semibold text-gray-700">Genre</label>
                        <select id="genre" wire:model="genre"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Select a genre</option>
                            <option value="Fiction">Fiction</option>
                            <option value="Non-Fiction">Non-Fiction</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Science Fiction">Science Fiction</option>
                            <option value="Biography">Biography</option>
                            <option value="Historical Fiction">Historical Fiction</option>
                            <option value="Romance">Romance</option>
                            <option value="Self-Help">Self-Help</option>
                            <option value="Thriller">Thriller</option>
                            <!-- Add more genres as needed -->
                            <option value="Other">Other</option>
                        </select>
                        @error('genre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-5">
                        <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                        <select id="status" wire:model="status"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="To Read">To Read</option>
                            <option value="Reading">Reading</option>
                            <option value="Read">Read</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Rating -->
                    <div class="mb-5">
                        <label for="rating" class="block text-sm font-semibold text-gray-700">Rating (1-5)</label>
                        <input type="number" id="rating" wire:model="rating" max="5" min="0" step="0.1"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Optional">
                        @error('rating') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="button" @click="open = false; $wire.resetForm()"
                            class=" text-black py-3 rounded-lg font-medium hover:bg-red-700 transition duration-300">Cancel</button>
                        <button type="submit"
                            class="text-black px-3  py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal for Creating Entry -->
        <div x-show="open" @click.away="open = false"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-4">
                <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Create New Book Entry</h2>

                <form wire:submit.prevent="store">
                    <!-- Title -->
                    <div class="mb-5">
                        <label for="title" class="block text-sm font-semibold text-gray-700">Title</label>
                        <input type="text" id="title" wire:model="title"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Author -->
                    <div class="mb-5">
                        <label for="author" class="block text-sm font-semibold text-gray-700">Author</label>
                        <input type="text" id="author" wire:model="author"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('author') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Genre -->
                    <div class="mb-5">
                        <label for="genre" class="block text-sm font-semibold text-gray-700">Genre</label>
                        <select id="genre" wire:model="genre"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Select a genre</option>
                            <option value="Fiction">Fiction</option>
                            <option value="Non-Fiction">Non-Fiction</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Science Fiction">Science Fiction</option>
                            <option value="Biography">Biography</option>
                            <option value="Historical Fiction">Historical Fiction</option>
                            <option value="Romance">Romance</option>
                            <option value="Self-Help">Self-Help</option>
                            <option value="Thriller">Thriller</option>
                            <!-- Add more genres as needed -->
                            <option value="Other">Other</option>
                        </select>
                        @error('genre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-5">
                        <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                        <select id="status" wire:model="status"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="To Read">To Read</option>
                            <option value="Reading">Reading</option>
                            <option value="Read">Read</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Rating -->
                    <div class="mb-5">
                        <label for="rating" class="block text-sm font-semibold text-gray-700">Rating (1-5)</label>
                        <input type="number" id="rating" wire:model="rating" max="5" min="0" step="0.1"
                            class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Optional">
                        @error('rating') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end mt-6">
                        <button type="button" @click="open = false; $wire.resetForm()"
                            class=" text-black  py-3 rounded-lg font-medium hover:bg-gray-500 transition duration-300">Cancel</button>
                        <button type="submit"
                            class=" text-black px-3 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>