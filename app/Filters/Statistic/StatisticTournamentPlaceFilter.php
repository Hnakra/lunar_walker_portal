<?php
    namespace App\Filters\Statistic;

    use Closure;
    use App\Filters\Pipe;

    class StatisticTournamentPlaceFilter implements Pipe{
        public function handle($content, Closure $next)
        {
            $keys = array_keys(array_filter($content->filters['placeName'], fn($v) => $v));
            $content->query = $content->query->whereNotIn('places.name', $keys);
            return $next($content);
        }
    }
