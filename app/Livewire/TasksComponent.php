<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TasksComponent extends Component
{
    public $tasks = [];
    public $modal = false;
    public $title;
    public $description;
    public $editingTask;
    public $id;

    public function mount()
    {
        $this->getTasks();
    }

    public function getTasks()
    {
        $user = Auth::User();
        $userTasks = $user->tasks;
        $sharedTasks = $user->sharedTasks;
        $this->tasks =  $sharedTasks->merge($userTasks);
    }

    public function openCreateModal(?Task $task = null)
    {
        if($task){
            $this->editingTask = $task;
            $this->title = $task->title;
            $this->description = $task->description;
            $this->id = $task->id;
        }else{
            $this->clearFields();
        }
        $this->modal = true;
    }

    public function closeCreateOrUpdateModal()
    {
        $this->modal = false;
    }

    public function createOrUpdateTask()
    {
        if($this->editingTask->id){
            $task = Task::find($this->editingTask->id);
            $task->update([
                'title' => $this->title,
                'description' => $this->description
            ]);
        }else{
            Task::create([
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => Auth::user()->id
            ]);
        }

        $this->closeCreateOrUpdateModal();
        $this->clearFields();
        $this->getTasks();
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
        $this->getTasks();
    }

    private function clearFields()
    {
        $this->title = '';
        $this->description = '';
    }

    public function render()
    {
        return view('livewire.tasks-component');
    }
}
