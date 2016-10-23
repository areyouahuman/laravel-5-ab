<?php
namespace RCAlmeida\AB\Models;

class Report {
    public static function getReport()
    {
        $experiments = Experiment::active()->get();
        $goals = array_unique(Goal::active()->orderBy('name')->lists('name'));

        $rows = [array_merge(['Experiment', 'Visitors', 'Engagement'], array_map('ucfirst', $goals))];

        foreach ($experiments as $experiment) {
            $engagement = $experiment->visitors ? ($experiment->engagement / $experiment->visitors * 100) : 0;

            $row = [
                $experiment->name,
                $experiment->visitors,
                number_format($engagement, 2) . " % (" . $experiment->engagement . ")",
            ];

            $results = $experiment->goals()->lists('count', 'name');

            foreach ($goals as $column) {
                $count = array_get($results, $column, 0);
                $percentage = $experiment->visitors ? ($count / $experiment->visitors * 100) : 0;

                $row[] = number_format($percentage, 2) . " % ($count)";
            }

            $rows[] = $row;
        }

        return $rows;
    }

}