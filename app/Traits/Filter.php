<?php
namespace App\Traits;
use Illuminate\Pipeline\Pipeline;

/**
 * Trait Filter
 * @package App\Traits
 * Трейт, подключаемый к классу контроллера для возможностей фильтрации коллекции $data
 * Единственное условие данного контроллера - наличие метода refresh():void, обновляющий данные в коллекции
 * Позволяет не только фильтровать данные, но и организует управление front-частью фильтра (всплывающие окна)
 * Фронт часть фильтра: resources/views/layouts/filter.blade.php
 * Пример использования фильтра в контроллере:
 *  Используйте в QueryBulider следующую конструкцию:
 *       ->where(function($query){
 *           $this->filter($query, $classlist, $callable);
 *       })
 *  где $classlist - список классов, в которых реализован фильтр
 *    (пример: $classlist = [StatisticDateFilter::class, StatisticTournamentFilter::class]; )
 *  где $callable - функция, возвращающая array, содержимое которого "ключ_фильтра" => "массив_возможных_значений_фильтра"
 *    (пример: $callable = fn() => ['date' => ['2022-12-11', '2022-11-06']];
 * Пример использования окна фильтрации в view:
 *
 *      @include("layouts.filter", ['type'=>'ключ_даты_записи'])
 * Класс реализации для каждого фильтра необходимо прописать, используя интерфейс App\Filters\Pipe
 */
trait Filter{
    use Searcher;
    public $selectedDropdowns = [];

    /**
     * @var $filter
     * массив фильтров
     * структура данных:
     * [
     *  typeFilter:string => [
     *   dataOfFilter:string => isSelected:bool
     *  ]
     * ]
     */
    public $filter, $classList;
    private function isNotInitFilter(): bool
    {
        return !isset($this->filter);
    }
    private function filter($query, $classList, $callableWithFilterLists)
    {
        if($this->isNotInitFilter()){
            $this->initFilter($classList, $callableWithFilterLists);
        }
        $this->filterBySearch($this->filter);
        app(Pipeline::class)
            ->send((object)['query'=>$query, 'filters' => $this->filter])
            ->through($this->classList)
            ->thenReturn();
    }
    private function initFilter($classList, $callableWithFilterLists)
    {
        $this->classList = $classList;
        $this->filter = [];
        $filterLists = $callableWithFilterLists();
        array_walk($filterLists, function($values, $k){
            $this->filter[$k] = array_combine($values, array_fill(0, count($values), false));
        } );
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


}
