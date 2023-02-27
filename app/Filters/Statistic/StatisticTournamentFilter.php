<?php
    namespace App\Filters\Statistic;

    use Closure;
    use App\Filters\Pipe;

    class StatisticTournamentFilter implements Pipe{
        public function handle($content, Closure $next)
        {
            $keys = array_keys(array_filter($content->filters['tournamentName'], fn($v) => $v));
            $content->data = $content->data->whereNotIn('tournamentName', $keys);
            return $next($content);
        }
    }
