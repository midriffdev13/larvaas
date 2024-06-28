<?php
namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use App\Filament\Admin\Resources\Teams\TeamResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Illuminate\Support\Js;


class EditTeamProfile extends EditTenantProfile
{


    protected static string $resource = TeamResource::class;

    // public function getFilamentName(): string
    // {
    //     return "{$this->name}'s";
    // }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         DeleteAction::make()
    //             ->hidden(fn() => !auth()->user()->can('team.delete')),
    //     ];
    // }

    public function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getCancelFormAction(): Action
    {
        return $this->backAction();
    }

    public function backAction(): Action
    {
        return Action::make('back')
            ->label(__('filament-panels::pages/auth/edit-profile.actions.cancel.label'))
            ->alpineClickHandler('document.referrer ? window.history.back() : (window.location.href = ' . Js::from(filament()->getUrl()) . ')')
            ->color('gray');
    }
    public static function getLabel(): string
    {
        return 'Edit Profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->disabled()
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn($record): ?string => $record->created_at?->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn($record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

}