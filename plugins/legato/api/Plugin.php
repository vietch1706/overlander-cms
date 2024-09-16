<?php

namespace Legato\Api;

use Backend\Facades\Backend;
use Backend\Models\User;
use Illuminate\Support\Facades\Event;
use Legato\Api\Middlewares\LangOverride;
use Legato\Api\Middlewares\LangV3;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Legato\Api\Listeners\TokenSessionHandler;
use Legato\Api\Listeners\TokenWebHandler;
use Legato\Api\Middlewares\Auth;
use Legato\Api\Middlewares\Lang;
use Legato\Api\Middlewares\Rest;
use Legato\Api\Models\Settings;
use Legato\Api\Repositories\Token;

/**
 * Api Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = [];

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        app()->make('router')->aliasMiddleware('rest', Rest::class);
        app()->make('router')->aliasMiddleware('lang', Lang::class);
        app()->make('router')->aliasMiddleware('lang-v3', LangV3::class);
        app()->make('router')->aliasMiddleware('lang-override', LangOverride::class);
        app()->make('router')->aliasMiddleware('auth', Auth::class);

        Event::listen('legato.api.login.after', TokenSessionHandler::class);
        Event::listen('legato.api.response.after', TokenWebHandler::class);

        User::extend(function ($model) {
            $tokenRepository = new Token();
            $model->bindEvent('model.afterUpdate', function() use ($model, $tokenRepository) {
                if (!$model->is_activated) {
                    $tokenRepository->deleteById($model->id);
                }
            });

            $model->bindEvent('model.beforeDelete', function() use ($model, $tokenRepository) {
                $tokenRepository->deleteById($model->id);
            });
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Legato\Api\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'legato.api.manage' => [
                'tab' => 'legato.api::lang.plugin.name',
                'label' => 'legato.api::lang.permissions.manage',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'api' => [
                'label' => 'legato.api::lang.plugin.name',
                'url' => Backend::url('legato/api/apis'),
                'icon' => 'icon-leaf',
                'permissions' => ['legato.api.*'],
                'order' => 500,
            ],
        ];
    }

    /**
     * Registers back-end settings items for this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'api' => [
                'label'       => 'legato.api::lang.settings.title',
                'description' => 'legato.api::lang.settings.description',
                'category'    => SettingsManager::CATEGORY_BACKEND,
                'icon'        => 'icon-server',
                'order'       => 100,
                'class' => Settings::class,
            ]
        ];
    }
}
