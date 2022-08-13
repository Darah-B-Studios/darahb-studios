<?php

namespace App\Http\Livewire;

use App\Models\NavigationMenu;
use App\Models\Page;
use Livewire\Component;

class Frontpage extends Component
{
    public $title;
    public $content;
    public $page_slug;

    /**
     * Base function to run when component has loaded
     *
     * @param  mixed $page_slug
     * @return void
     */
    public function mount($page_slug)
    {
        $this->page_slug = $page_slug;
        $this->load_page_data($page_slug);
    }

    /**
     * Load page content from database, for page that has
     * the provided slug
     *
     * @param  mixed $slug
     * @return void
     */
    public function load_page_data($slug)
    {
        $data = Page::where('slug', $slug)->firstOrFail();
        $this->title = $data->title;
        $this->content = $data->content;
    }

    public function render()
    {
        return view('livewire.frontpage', [
            "menus" => NavigationMenu::all()
        ])->layout('layouts.frontend');
    }
}