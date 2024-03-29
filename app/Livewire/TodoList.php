<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{

    use WithPagination;

    #[Rule('required|min:3|max:30')]
    public $name;

    public $search;

    public function create()
    {

        $validate = $this->validateOnly('name');
        Todo::create($validate);

        $this->reset('name');

        session()->flash('success', 'Todo created successfully');
    }

    public function delete($id)
    {
        Todo::find($id)->delete();
    }

    public function render()
    {

        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)
        ]);
    }
}
