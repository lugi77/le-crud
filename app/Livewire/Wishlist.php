<?php

namespace App\Livewire;

use App\Models\Wishlists;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Wishlist extends Component
{
    use WithPagination;

    public $title, $author, $genre, $notes;
    public $wishlistId; // For updating existing wishlist items
    public $perPage = 5;

    // Create a new wishlist entry
    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Wishlists::create([
            'title' => $this->title,
            'author' => $this->author,
            'genre' => $this->genre,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Book added to wishlist!');
        $this->resetForm();
    }

    // Edit an existing wishlist entry
    public function edit($id)
    {
        $wishlist = Wishlists::findOrFail($id);

        $this->wishlistId = $wishlist->id;
        $this->title = $wishlist->title;
        $this->author = $wishlist->author;
        $this->genre = $wishlist->genre;
        $this->notes = $wishlist->notes;
    }

    // Update an existing wishlist entry
    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $wishlist = Wishlists::findOrFail($this->wishlistId);
        $wishlist->update([
            'title' => $this->title,
            'author' => $this->author,
            'genre' => $this->genre,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Wishlist item updated!');
        $this->resetForm();
    }

    // Delete a wishlist entry
    public function delete($id)
    {
        $wishlist = Wishlists::findOrFail($id);
        $wishlist->delete();

        session()->flash('message', 'Wishlist item deleted!');
    }

    // Reset the form
    public function resetForm()
    {
        $this->title = '';
        $this->author = '';
        $this->genre = '';
        $this->notes = '';
        $this->wishlistId = null;
    }

    public function render()
    {
        // Paginate wishlist items
        $wishlists = Wishlists::paginate($this->perPage);
        return view('livewire.wish-list', ['wishlists' => $wishlists]);
    }
}
