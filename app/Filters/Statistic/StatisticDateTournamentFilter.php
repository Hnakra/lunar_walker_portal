<?php
    namespace App\Filters\Statistic;

    use Closure;
    use App\Filters\Pipe;

    class StatisticDateTournamentFilter implements Pipe{
        public function handle($content, Closure $next)
        {
            $keys = array_keys(array_filter($content->filters['date'], fn($v) => $v));
            foreach($keys as $key){
                $content->query = $content->query->whereDate('tournaments.date_time', '!=', $key);
            }
            return $next($content);
        }
    }
