<a href="#!" id="filter" wire:click="show_dropdown('{{$type}}')" >
    <div>
        @if($this->isFiltered($type))
            <i class="fas fa-filter"></i>
        @else
            <svg class="filter-icon" viewBox="0 0 120 120" ><path fill="#000000" d="M2.788,0h117.297c1.544,0,2.795,1.251,2.795,2.795c0,0.85-0.379,1.611-0.978,2.124l-46.82,46.586v39.979 c0,1.107-0.643,2.063-1.576,2.516l-22.086,12.752c-1.333,0.771-3.039,0.316-3.812-1.016c-0.255-0.441-0.376-0.922-0.375-1.398 h-0.006V51.496L0.811,4.761C-0.275,3.669-0.27,1.904,0.822,0.819c0.544-0.541,1.255-0.811,1.966-0.811V0L2.788,0z M113.323,5.591 H9.493L51.851,48.24c0.592,0.512,0.966,1.27,0.966,2.114v49.149l16.674-9.625V50.354h0.008c0-0.716,0.274-1.432,0.822-1.977 L113.323,5.591L113.323,5.591z"/></svg>
        @endif
    </div>
</a>
@if(in_array($type, $selectedDropdowns))
    <div id="dropdown">
        <ul>
            <li>
                <input @if(!$this->isFiltered($type)) checked @endif type="checkbox" id="checkbox-all-{{$type}}" wire:change="update_checkbox_all('{{$type}}')">
                <label for="checkbox-all-{{$type}}">(Выбрать все)</label>
            </li>
            @foreach($filter[$type] as $k => $v)
                <li>
                    <input @if(!$v) checked @endif type="checkbox" id="checkbox-{{$k}}" wire:change="update_checkbox('{{$type}}', '{{$k}}')">
                    <label for="checkbox-{{$k}}">{{$k}}</label>
                </li>
            @endforeach
        </ul>
    </div>
    <script>
        closeDropdown('{{$type}}');
        function closeDropdown(dropdown){
            document.addEventListener('click', function(e) {
                e.target.closest('#dropdown') ? closeDropdown(dropdown) : @this.close_dropdown(dropdown)
            } , {once : true});
        }
    </script>
@endif
