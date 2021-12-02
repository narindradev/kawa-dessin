<?php

namespace App\Http\Controllers\Logs;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\DataTables\Logs\AuditLogsDataTable;

class AuditLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuditLogsDataTable $dataTable)
    {
        return $dataTable->render('pages.log.audit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity = Activity::find($id);
        // Delete from db
        $activity->delete();
    }

    public function load_more(Request $request){
        $options = $request->all();
        $html = "";
        $offset = $request->offset + 8;
        $activities = ActivityLog::activities($options);
        foreach ($activities as $activity) {
            $html .= view("dashboard.widgets.activities.item",["data" => get_activities_template($activity)])->render();
        }
        return [ "success" => true, "html" => $html ,"offset" => $offset];
    }
}