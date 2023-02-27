<?php
namespace App\Traits;
use App\Filters\Statistic\StatisticDateFilter;
use Illuminate\Pipeline\Pipeline;

/**
 * Trait Filter
 * @package App\Traits
 * Трейт, подключаемый к классу для возможностей фильтрации коллекции $data
 * Позволяет не только фильтровать данные, но и организует управление front-частью фильтра (всплывающие окна)
 * Фронт часть фильтра: resources/views/layouts/filter.blade.php
 * Пример использования фильтра в контроллере:
 *
 *       $this->filter($фильтруемые_данные, [
 *           'ключ_даты_записи' => [
 *               'data' => [
 *                   "2022-12-11" => false,
 *                   "2022-06-11" => true
 *               ]),
 *               'class' => StatisticDateFilter::class
 *       ]);
 * Пример использования окна фильтрации в view:
 *
 *      @include("layouts.filter", ['type'=>'ключ_даты_записи'])
 * Класс реализации для каждого фильтра необходимо прописать, используя интерфейс App\Filters\Pipe
 */
trait Filter{
    public $selectedDropdowns = [];
    public $filter;

    private function filter(&$data, $params)
    {
        if(!isset($this->filter)){
            $this->initFilter($params);
        }
        $classList = array_map(fn($p) => $p['class'], $params);
        $data = app(Pipeline::class)
            ->send((object)['data'=>$data, 'filters' => $this->filter])
            ->through($classList)
            ->thenReturn()->data;
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
