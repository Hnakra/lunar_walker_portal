<?php
    namespace App\Filters\Statistic;

    use Closure;
    use App\Filters\Pipe;

    class StatisticTeamFilter implements Pipe{
        public function handle($content, Closure $next)
        {
            $keys = array_keys(array_filter($content->filters['team'], fn($v) => $v));
            $content->query = $content->query->where(function ($query) use ($keys) {
                $query->whereNotIn('T1.name', $keys)->orWhereNotIn('T2.name', $keys);
            });
            return $next($content);
        }
    }
