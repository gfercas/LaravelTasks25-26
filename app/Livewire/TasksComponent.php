<?php

namespace App\Livewire;

use App\Mail\SharedTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class TasksComponent extends Component
{
    public $tasks = [];
    public $modal = false;
    public $shareModal = false;
    public $title;
    public $description;
    public $id;
    public $users;
    public $user_id;
    public $editingTask;
    public $permission;

    public function mount()
    {
        $this->getTasks();
        $this->users = User::where('id', '!=', auth()->user()->id)->get();
    }

    public function getTasks()
    {
        $user = Auth::User();
        $userTasks = $user->tasks;
        $sharedTasks = $user->sharedTasks;
        $this->tasks =  $sharedTasks->merge($userTasks);
    }

    public function openCreateOrUpdateModal(?Task $task = null)
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

    public function openShareModal(Task $task)
    {
        $this->editingTask = $task;
        $this->shareModal = true;
    }

    public function closeShareModal()
    {
        $this->shareModal = false;
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

    public function shareTask()
    {
        $user = User::find($this->user_id);
        $user->sharedTasks()->attach($this->editingTask->id, ['permission' => $this->permission]);
        $this->getTasks();
        $this->closeShareModal();
        $this->clearFields();
        Mail::to($user->email)->send(new SharedTask($this->editingTask, auth()->user()));
    }

    public function deleteRelationshipTask(Task $task)
    {
        $user = auth()->user();
        $user->sharedTasks()->detach($task->id);
        $this->getTasks();
        $this->closeShareModal();
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
        $this->user_id = '';
        $this->permission = '';
    }

    public function render()
    {
        return view('livewire.tasks-component');
    }
}
