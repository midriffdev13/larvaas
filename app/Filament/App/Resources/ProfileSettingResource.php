<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ProfileSettingResource\Pages;
use App\Models\Teams\Authorization\TeamMemberPermissionPivot;
use App\Models\Teams\TeamMemberPivot;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Users\User;
use App\Models\Teams\Team;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Panel;
use Illuminate\Support\Collection;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Illuminate\Database\Eloquent\Model;



class ProfileSettingResource extends Resource
{
    protected static ?string $model = User::class;

    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Profile Setting';
    protected static ?string $navigationLabel = 'Teams';

    protected static ?string $tenantOwnershipRelationshipName = 'teams';



    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    // public static function getGlobalSearchResultDetails(Model $record): array
    // {
    //     return [
    //         'Members' => $record->members->count(),
    //     ];
    // }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfileSettings::route('/'),
            'create' => Pages\CreateProfileSetting::route('/create'),
            'edit' => Pages\EditProfileSetting::route('/{record}/edit'),
            'email' => Pages\EmailSetting::route('/{record}/email'),
            'security' => Pages\PasswordSettings::route('/{record}/security'),
        ];
    }
}
