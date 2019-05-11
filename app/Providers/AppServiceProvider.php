<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('РАЗДЕЛЫ');
            $event->menu->add(
                [
                    'text'        => 'Песни',
                    'url'         => 'admin/songs',
                    'icon'        => 'music',
                    /*'label'       => 4,
                    'label_color' => 'success',*/
                ],
                [
                    'text'        => 'Стихи',
                    'url'         => 'admin/verses',
                    'icon'        => 'pencil-square-o',
                    /*'label'       => 4,
                    'label_color' => 'success',*/
                ],
                [
                    'text'        => 'Альбомы',
                    'url'         => 'admin/albums',
                    'icon'        => 'book',
                    /*'label'       => 4,
                    'label_color' => 'success',*/
                ]
            );
            $event->menu->add('НАСТРОЙКИ АККАУНТА');
            $event->menu->add(
                [
                    'text' => 'Профиль',
                    'url'  => 'admin/settings',
                    'icon' => 'user',
                ],
                [
                    'text' => 'Смена пароля',
                    'url'  => 'admin/settings',
                    'icon' => 'lock',
                ]
            );
        });
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
