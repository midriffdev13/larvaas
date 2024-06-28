<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\Auth\Register;
use App\Filament\Admin\Pages\EditProfile;
use App\Filament\Admin\Pages\EditTeamProfile;
use App\Filament\Admin\Pages\RegisterTeam;
use App\Models\Teams\Team;
// use app\Filament\Pages\Auth\EditProfile;

use app\Filament\App\Resources\ProfileSettingResource\Pages\EditProfileSetting;
use app\Filament\App\Resources\ProfileSettingResource\Pages\PasswordSettings;
// use App\Filament\Pages\Settings;
use app\Filament\App\Resources\ProfileSettingResource;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Actions\Action;
use Filament\Tables;

use Jeffgreco13\FilamentBreezy\BreezyCore;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->login()
            ->registration(Register::class)
            ->profile(EditProfile::class)
            ->emailVerification()
            ->passwordReset()
            ->databaseNotifications()
            ->plugin(
                BreezyCore::make()
            )

            // ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            //     return $builder->items([
            //         NavigationItem::make('Dashboard')
            //             ->icon('heroicon-o-home')
            //             // ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
            //             ->url(fn (): string => ProfileSettingResource::getUrl().'/'.auth()->user()->slug .'/edit'),
            //         ...ProfileSettingResource::getNavigationItems(),
            //         // ...Settings::getNavigationItems(),
            //     ]);
            // })
            ->navigationItems([
                NavigationItem::make('Profile')
                    ->url(fn(): string => ProfileSettingResource::getUrl() . '/' . auth()->user()->slug . '/edit')
                    // ->icon('heroicon-o-presentation-chart-line')
                    ->icon('heroicon-c-user')

                    ->group('Profile Setting')
                // ->sort(3)
                ,
                
                NavigationItem::make('Emails/Notifications')
                    // ->label(fn (): string => __('filament-panels::pages/dashboard.title'))
                    ->url(fn(): string => ProfileSettingResource::getUrl() . '/' . auth()->user()->slug . '/email')
                    ->group('Profile Setting')
                    ->icon('heroicon-c-pencil-square'),
                NavigationItem::make('Security')
                    // ->label(fn (): string => __('filament-panels::pages/dashboard.title'))
                    ->url(fn(): string => ProfileSettingResource::getUrl() . '/' . auth()->user()->slug . '/security')
                    ->group('Profile Setting')
                    ->icon('heroicon-s-key')
                // ...
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandName('Larvaas')
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->pages([
                Pages\Dashboard::class,
                // EditProfile::class
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->tenant(
                model: Team::class,
                ownershipRelationship: 'team',
                slugAttribute: 'slug'
            )
            ->tenantRoutePrefix('team')
            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeamProfile::class)
        ;

    }
}
