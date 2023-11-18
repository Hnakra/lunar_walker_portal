<style>
    .big-button {
        align-items: center;box-shadow: none;background: rgba(228, 202, 64, 0.7)!important;color: var(--dark-color) !important;opacity: 0.8;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border: 1px solid rgba(0, 0, 0, 0.51);border-radius: 3px;
    }
    .button {text-decoration: none !important;padding: 10px 30px 10px 30px;border-radius: 4px;
    }
</style>
<p>
    {{__('Дорогой')}} {{$data['userName']}}!
</p>
<p>{{
            App::isLocale('ru') ?
                "Ваша команда ".$data['teamName']." участвует в турнире ".$data['tournamentName'].", на площадке ".$data['placeName'].", дата-время: ".$data['date_time'].". Подтвердите свое участие." :
                "Your ".$data['teamName']." team is participating in the ".$data['tournamentName']." tournament, on the ".$data['placeName']." place, date-time: ".$data['date_time'].". Confirm your participation."
            }}</p>
<br>
<div style="text-align: center;">
    <a href="moon.rfbl.ru/tournaments" style="align-items: center;box-shadow: none;background: rgba(228, 202, 64, 0.7)!important;color: var(--dark-color) !important;opacity: 0.8;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border: 1px solid rgba(0, 0, 0, 0.51);border-radius: 3px;text-decoration: none !important;padding: 10px 30px 10px 30px;border-radius: 4px;">{{__('ПОДТВЕРДИТЬ УЧАСТИЕ')}}</a>
</div>
