<?php
namespace common\tool;

class Family
{
	public static function getProjectName($project)
	{
		return 1212;
		
		if ($project->name)
		{
		    return $project->name;
		}
		
	    $name = $project->city->name . '-';
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
}
