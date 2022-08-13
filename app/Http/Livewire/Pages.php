<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;

class Pages extends Component
{
    public $slug;
    public $title;
    public $content;
    public $page;
    public $modalFormVisible = false;
    public $modalConfirmDelete = false;

    public function rules()
    {
        return [
            'title' => 'required|string',
            'slug' => ['required', Rule::unique('pages', 'slug')->ignore($this->page)],
        ];
    }

    /**
     * Show the form modal for the page create functionality
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->reset();
        $this->modalFormVisible = true;
        $this->clearValidation();
    }

    public function showDeleteModal(Page $page)
    {
        $this->page = $page;
        $this->modalConfirmDelete = true;
    }

    /**
     * Create new page
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Page::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
        $this->sendNotification("New page created successfully");
    }

    public function read()
    {
        return Page::paginate(5);
    }

    public function edit(Page $page)
    {
        $this->clearValidation();
        $this->modalFormVisible = true;
        $this->loadData($page);
        $this->page = $page;
    }

    public function update(Page $page)
    {
        $this->page = $page;
        $this->modalFormVisible = true;
        $page->update($this->modelData());
        $this->modalFormVisible = false;

        $this->sendNotification("Page updated successfully");
    }

    public function delete(Page $page)
    {
        $this->page = $page;
        $page->delete();
        $this->modalConfirmDelete = false;
        $this->reset();
        $this->sendNotification("Page deleted successfully");
    }

    public function loadData(Page $page)
    {
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content;
    }

    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content
        ];
    }

    public function updatedTitle()
    {
        $this->slug = Str::slug($this->title);
    }

    public function sendNotification($title = "Success", $message = null)
    {
        $this->dispatchBrowserEvent('event-notification', [
            'title' => $title,
            'message' => $message
        ]);
    }

    /**
     * The livewire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages', [
            'pages' => $this->read(),
        ]);
    }
}