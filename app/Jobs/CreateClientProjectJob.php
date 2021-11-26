<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Project;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\ProjectAssignedNotification;
use App\Notifications\ProjectCreatedNotification;

class CreateClientProjectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue,  SerializesModels;

    protected $project;
    protected $attachements = [];
    protected $descriptions;
    protected $client;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, User $client, $descriptions, $attachements = [])
    {
        $this->project = $project;
        $this->client = $client;
        $this->attachements = $attachements;
        $this->descriptions = $descriptions;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $user = Project_assignment::getAssignTo('commercial'); // vrai
        $user = User::find(12); // test
        $this->project->members()->attach([$user->id]);
        $this->project->descriptions()->createMany($this->descriptions);
        if ($this->attachements) {
            $this->project->files()->createMany($this->attachements);
        }
        $user->notify(new ProjectAssignedNotification($this->project, null));
        $this->client->notify(new ProjectCreatedNotification());
        $this->project->status_id = 2;
        $this->project->save();
    }
}
