<?php
namespace App\Traits;
use Illuminate\Support\Facades\Log;

trait Searcher{
    public $searchData = [], $visibleFilters = [];
    function filterBySearch($params){
        if($this->searchData == []){
            $this->initFilterBySearch($params);
        }
        foreach($this->searchData as $key => $searchText){
            if($searchText == ""){
                $this->visibleFilters[$key] = array_combine(array_keys($this->visibleFilters[$key]), array_fill(0, count($this->visibleFilters[$key]), true));
            }
            else {
                array_walk($this->visibleFilters[$key],
                    function (&$v, $k)use($searchText){
                        $v = mb_strripos($k, $searchText) !== false;
                    }
                );
            }
        }
    }

    private function initFilterBySearch($params)
    {
        $this->searchData = array_combine(array_keys($params), array_fill(0, count($params), ""));
        foreach($params as $key => $array){
            $this->visibleFilters[$key] = array_combine(array_keys($array['data']), array_fill(0, count($array['data']), true));
        }
    }
}
