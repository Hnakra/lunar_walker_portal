<div class="feedback-form">
    <h1>{{__('Связаться с нами')}}</h1>

        <div>
            <div class = "success">{{$message}}</div> <br/>
            <input wire:model.defer="name" class="form-data" type="text" name="demo-name" id="demo-name" value="" placeholder="{{__('Имя')}}" />
            <input wire:model.defer="email" class="form-data" type="email" name="demo-email" id="demo-email" value="" placeholder="{{__('Email')}}" />
            @error('name')<div> <span class="error">{{ $message }}</span> </div>@enderror
            @error('email') <div><span class="error">{{ $message }}</span> </div>@enderror
            <textarea wire:model.defer="question" name="demo-message" id="demo-message" placeholder="{{__('Задайте вопрос')}}" rows="6"></textarea>
            @error('question') <div><span class="error">{{ $message }}</span></div> @enderror
            <div class="footer-form">
                <a href="#!" class="button big-button" wire:click="send"> {{__('ОТПРАВИТЬ')}} </a>
            </div>
        </div>
</div>
