<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Book;
use Livewire\Component;

#[Layout('layouts.app')]
class BookTracker extends Component
{
    use WithPagination;
    public $perPage = 5;

    public $title, $author, $genre, $status, $rating;

    public $bookId; // Store the selected book's ID for editing
    public $confirmDelete = false; // Whether to show delete confirmation modal
    public $openEditModal = false; // Manage edit modal visibility
    public $search = '';

    // For displaying flash messages
    protected $listeners = ['bookStored', 'openEditModal', 'confirmDelete' => '$refresh'];

    // Store book entry
    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255|unique:books,title',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'status' => 'required|string',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        Book::create([
            'title' => $this->title,
            'author' => $this->author,
            'genre' => $this->genre,
            'status' => $this->status,
            'rating' => $this->rating,
        ]);

        session()->flash('message', 'Book entry created successfully!');

        // Reset form fields
        $this->reset(['title', 'author', 'genre', 'status', 'rating']);

        $this->dispatch('closeModal');

        $this->dispatch('bookStored'); // Emit event to refresh data
    }

    // Edit Book Entry
    public function edit($bookId)
    {
        $book = Book::findOrFail($bookId);

        // Prepopulate the form fields for editing
        $this->bookId = $book->id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->genre = $book->genre;
        $this->status = $book->status;
        $this->rating = $book->rating;

        $this->openEditModal = true; // Open modal for editing
    }

    public function resetForm()
    {
        $this->title = '';
        $this->author = '';
        $this->genre = '';
        $this->status = '';
        $this->rating = null;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255|unique:books,title,' . $this->bookId,
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'status' => 'required|string',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        // Find the book by its ID and update it
        $book = Book::findOrFail($this->bookId);
        $book->update([
            'title' => $this->title,
            'author' => $this->author,
            'genre' => $this->genre,
            'status' => $this->status,
            'rating' => $this->rating,
        ]);

        // Close the modal and reset the form
        $this->open = false;
        $this->resetForm();

        // Emit event to refresh data
        $this->dispatch('bookStored');
    }

    // Delete Book Entry
    public function deleteBook($bookId)
    {
        $book = Book::findOrFail($bookId);
        $book->delete();
    
        session()->flash('message', 'Book entry deleted successfully!');
    
        $this->dispatch('bookStored'); // Refresh the list
    }


    public function render()
    {
        // Paginate books, 5 per page
        $books = Book::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('author', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.book-tracker', [
            'books' => $books, // Pass paginated books
        ]);
    }
}
