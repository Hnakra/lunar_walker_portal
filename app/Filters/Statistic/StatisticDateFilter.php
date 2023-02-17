<?php
    namespace App\Filters\Statistic;

    use Closure;
    use App\Filters\Pipe;

    class StatisticDateFilter implements Pipe{
        public function handle($content, Closure $next)
        {
            $filters = array_filter($content->filters['date'], fn($v) => $v);
            foreach($filters as $filter_key => $_){
                $content->games = $content->games->where('date', $filter_key);
            }
            return $next($content);
        }
    }
