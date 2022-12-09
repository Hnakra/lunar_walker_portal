<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class ChangeStateController extends Component
{
    public $game, $id_game;
    public $time, $id_state, $max_seconds_match, $is_sounded = true;

    public function game_start(){
        $this->is_sounded = false;
        $this->game->id_state = $this->game->id_state+1;
        $this->game->num_periods = $this->game->num_periods+1;
        $this->game->datetime_state = date("Y-m-d H:i:s", strtotime('now'));
        $this->update();
    }
    public function game_stop(){
        $this->game->id_state = 3;
        $this->game->datetime_state = date("Y-m-d H:i:s",strtotime('now')-strtotime($this->game->datetime_state));
        $this->update();
    }
    public function game_continue(){
        $this->is_sounded = false;
        $this->game->id_state = 2;
        $this->game->datetime_state = date("Y-m-d H:i:s",strtotime('now')-strtotime($this->game->datetime_state));
        $this->update();
    }
    public function time_exit(){
        $this->game->id_state = 4;
        $this->update();
    }
    public function game_exit(){
        $this->game->id_state = 0;
        $this->update();
    }
    public function time_new(){
        $this->is_sounded = false;
        $this->game->id_state = 2;
        $this->game->num_periods = $this->game->num_periods+1;
        $this->game->datetime_state = date("Y-m-d H:i:s", strtotime('now'));
        $this->update();
    }
    public function updateTime(){
        $this->time = strtotime(date("Y-m-d H:i:s", strtotime('now')))-strtotime($this->game->datetime_state);
        $this->id_state = $this->game->id_state;
    }
    private function update(){
        $this->game->save();
        $this->emit('stateChanged');
    }

    public function render()
    {
        $this->game = Game::find($this->id_game);
        $this->max_seconds_match = $this->game->max_seconds_match;

        return view('livewire.change-state-controller');
    }
}
