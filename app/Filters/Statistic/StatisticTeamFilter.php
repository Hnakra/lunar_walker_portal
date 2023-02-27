<?php
    namespace App\Filters\Statistic;

    use Closure;
    use App\Filters\Pipe;

    class StatisticTeamFilter implements Pipe{
        public function handle($content, Closure $next)
        {
            $keys = array_keys(array_filter($content->filters['team'], fn($v) => $v));
            $c1 = $content->data->whereNotIn('t1_name', $keys);
            $c2 = $content->data->whereNotIn('t2_name', $keys);
            $content->data = $c1->merge($c2);
            return $next($content);
        }
    }
