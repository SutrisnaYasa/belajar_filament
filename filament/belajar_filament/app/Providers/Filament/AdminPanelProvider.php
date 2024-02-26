<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use App\Models\Team;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Navigation\UserMenuItem;
use Filament\Navigation\NavigationItem;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use App\Filament\Resources\NilaiResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\PeriodeResource;
use App\Filament\Resources\SubjectResource;
use App\Filament\Resources\TeacherResource;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Filament\Resources\AdjacencyResource;
use App\Filament\Resources\ClassroomResource;
use App\Filament\Resources\DepartmentResource;
use App\Filament\Resources\NewStudentResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Resources\CategoryNilaiResource;
use App\Filament\Resources\StudentHasClassResource;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->sidebarCollapsibleOnDesktop(true) // agar sidebar bisa besar kecil.
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            // Untuk Multi Tenancy
            // ->tenant(Team::class)
            // ->tenantRegistration(RegisterTeam::class)
            // End Untuk Multi Tenancy
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make()
                    ->items([
                        NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn (): string => Dashboard::getUrl()),
                        ...AdjacencyResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Academic')
                    ->items([
                        ...TeacherResource::getNavigationItems(),
                        ...NewStudentResource::getNavigationItems(),
                        ...StudentHasClassResource::getNavigationItems(),
                        ...SubjectResource::getNavigationItems(),
                        ...NilaiResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Source')
                    ->items([
                        ...CategoryNilaiResource::getNavigationItems(),
                        ...ClassroomResource::getNavigationItems(),
                        ...DepartmentResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Setting')
                        ->items([
                            ...PeriodeResource::getNavigationItems(),
                            NavigationItem::make('Roles')
                                ->icon('heroicon-o-user-group')
                                ->isActiveWhen(fn ():bool => request()->routeIs([
                                    'filament.admin.resources.roles.index',
                                    'filament.admin.resources.roles.create',
                                    'filament.admin.resources.roles.view',
                                    'filament.admin.resources.roles.edit',
                                ]))
                                ->url(fn (): string => '/admin/roles'),
                            NavigationItem::make('Permissions')
                                ->icon('heroicon-o-lock-closed')
                                ->isActiveWhen(fn ():bool => request()->routeIs([
                                    'filament.admin.resources.permissions.index',
                                    'filament.admin.resources.permissions.create',
                                    'filament.admin.resources.permissions.view',
                                    'filament.admin.resources.permissions.edit',
                                ]))
                                ->url(fn (): string => '/admin/permissions'),
                            ...UserResource::getNavigationItems(),
                        ]),
                ]);
            })
            ->databaseNotifications();
    }

    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                // UserMenuItem::make()
                //     ->label('Setting')
                //     ->url(PeriodeResource::getUrl())
                //     ->icon('heroicon-s-cog'),
            ]);
        });
    }
}
