<?php

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\Resources\Users\UserResource\Pages;
use App\Filament\Admin\Resources\Users\UserResource\RelationManagers;
use App\Models\Users\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\Page;
use app\Filament\Admin\Pages\EditProfile;
use app\Filament\Admin\Resources\Users\UserResource\Pages\EditUser;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
    // public static function getRecordSubNavigation(Page $page): array
    // {
    //     return $page->generateNavigationItems([
    //         EditProfile::class,
    //         EditUser::class,
    //         // Pages\EditCustomer::class,
    //         // Pages\EditCustomerContact::class,
    //         // Pages\ManageCustomerAddresses::class,
    //         // Pages\ManageCustomerPayments::class,
    //     ]);
    // }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Email' => $record->email,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }
}