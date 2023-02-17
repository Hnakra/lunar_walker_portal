<?php
    namespace App\Filters\Statistic;

    use Closure;
    use App\Filters\Pipe;

    class StatisticDateFilter implements Pipe{
        public function handle($content, Closure $next)
        {
/*            if(request()->has('date_time')){
                $content->where('date_time', request('date_time'));
            }
            next($content);*/


         /*   if (! request()->has('active')) {
                return $next($content);
            }*/

           return $next($content)->where('date', "2022-12-11");
        }
    }
