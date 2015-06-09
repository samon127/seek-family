<?php
namespace common\tool;

class Family
{
	public static function getProjectName($project)
	{

		if ($project->name)
		{
		    return $project->name;
		}

		$name = '';
		if ($project->city)
		{
		    $name = $project->city->name . '-';
		}
	    if ($project->teacher)
	    {
	        $name .= $project->teacher->name . '-';
	    }
	    if ($project->client)
	    {
	        $name .= $project->client->name . '-';
	    }
	    $name .= $project->type->name;

		return $name;
	}

	public function getProjectNames($projects)
	{
	    $name = '';
	    foreach ($projects as $project)
	    {
	        $name .= self::getProjectName($project) . '<br />';
	    }
        return $name;
	}

	public static function percentExist($month, $project, $userProjectTimes)
	{
	    foreach ($userProjectTimes as $userProjectTime)
	    {
            foreach ($userProjectTime->times as $time)
            {
                if ($time->month == $month && $time->project_id == $project->id)
                {
                    return $time->percent;
                }
            }
	    }

        return false;
	}

	public static function getProjectStyle($project)
	{
	    $styles = [ 1 => '独立项目', 2 => '母项目', 3 => '子项目'];

	    return $styles[$project->style];
	}


}
