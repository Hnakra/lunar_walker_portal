<?php
namespace App\Traits;
use App\Filters\Statistic\StatisticDateFilter;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;

trait Filter{
    //private $collection;
    public $selectedDropdowns = [];
    public $filter;
    public $filterData = ['date', 'tournamentName', 'team'];
/*    public function init_filter(&$collection){
        $this->collection = $collection;

    }*/


    private function prepareFilters($name, $params)
    {
        if(!isset($this->filter)){
            $this->initFilter($params);
        }
        $classList = array_map(fn($p) => $p['class'], $params);

        $this->games = app(Pipeline::class)
            ->send((object)['games'=>$this->games, 'filters' => $this->filter])
            ->through($classList)
            ->thenReturn()->games;
    }

    public function update_checkbox($type, $value){
        $this->filter[$type][$value] = !$this->filter[$type][$value];
        $this->refresh();
    }
    public function isFiltered($type): bool
    {
        return in_array(true, $this->filter[$type]);
    }
    public function update_checkbox_all($type)
    {
        $isFiltered = !$this->isFiltered($type);
        foreach ($this->filter[$type] as $k => $v){
            $this->filter[$type][$k] = $isFiltered;
        }
        $this->refresh();
    }
    public function show_dropdown($dropdown_name){
        if (!in_array($dropdown_name, $this->selectedDropdowns)){
            array_push($this->selectedDropdowns, $dropdown_name);
        }
    }
    public function close_dropdown($dropdown_name){
        unset($this->selectedDropdowns[array_search($dropdown_name,$this->selectedDropdowns)]);
    }

    private function initFilter($params)
    {
        $this->filter = array_combine(array_keys($params), array_map(fn($item) => [], array_keys($params)));
        foreach ($params as $k => $v) {
            $this->filter[$k] = $v['data'];
        }
    }
}
