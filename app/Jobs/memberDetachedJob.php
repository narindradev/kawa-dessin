<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class memberDetachedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $project;
    protected $created_by;
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project ,$id = [] ,User $created_by)
    {
        $this->project = $project;
        $this->id = $id;
        $this->created_by = $created_by;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        activity("project_member")->causedBy($this->created_by)->performedOn($this->project)->tap(function(Activity $activity)  {
            $activity->users = $this->project->members()->pluck("user_id")->implode(",","user_id");
         })->withProperties(['detached_members' => [$this->id]])->log('detached');
    }
}
